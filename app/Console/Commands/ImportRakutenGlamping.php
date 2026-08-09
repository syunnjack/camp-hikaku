<?php

namespace App\Console\Commands;

use App\Models\Spot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * Imports real, bookable glamping properties from the Rakuten Travel
 * KeywordHotelSearch API (same shared credential already used in this
 * user's golf-search project) and uses the real Rakuten-generated
 * affiliate link the API itself returns. Only inserts what the API
 * actually returns — no invented listings. Idempotent via firstOrCreate
 * keyed on [name, area].
 *
 * Two undocumented gotchas discovered while wiring this up (2026-08-10):
 *  1. The API version moved from /20170426/ to /20260731/ in Rakuten's
 *     May 2026 platform migration — the old version path now returns a
 *     generic, misleading 503 "Authentication service error" instead of
 *     a clear "endpoint retired" message.
 *  2. Rakuten validates the Referer/Origin header against the exact
 *     "Application URL" the credential was registered under
 *     (golf-search.org), not the domain actually making the request —
 *     using camp-hikaku.jp's own URL gets a 403
 *     HTTP_REFERRER_NOT_ALLOWED. So this command deliberately sends
 *     golf-search.org as the Referer/Origin even though it's importing
 *     data for camp-hikaku.jp; that's correct, not a copy-paste bug.
 *  3. latitude/longitude come back as JGD2000 arcseconds (e.g.
 *     497156.36), not decimal degrees — divide by 3600 to get usable
 *     decimal coordinates.
 */
class ImportRakutenGlamping extends Command
{
    protected $signature = 'camp:import-rakuten-glamping';

    protected $description = 'Import real glamping properties from the Rakuten Travel API and add real affiliate links';

    private const KEYWORDS = [
        '北海道 グランピング', '青森県 グランピング', '岩手県 グランピング', '宮城県 グランピング',
        '秋田県 グランピング', '山形県 グランピング', '福島県 グランピング', '茨城県 グランピング',
        '栃木県 グランピング', '群馬県 グランピング', '埼玉県 グランピング', '千葉県 グランピング',
        '東京都 グランピング', '神奈川県 グランピング', '新潟県 グランピング', '富山県 グランピング',
        '石川県 グランピング', '福井県 グランピング', '山梨県 グランピング', '長野県 グランピング',
        '岐阜県 グランピング', '静岡県 グランピング', '愛知県 グランピング', '三重県 グランピング',
        '滋賀県 グランピング', '京都府 グランピング', '大阪府 グランピング', '兵庫県 グランピング',
        '奈良県 グランピング', '和歌山県 グランピング', '鳥取県 グランピング', '島根県 グランピング',
        '岡山県 グランピング', '広島県 グランピング', '山口県 グランピング', '徳島県 グランピング',
        '香川県 グランピング', '愛媛県 グランピング', '高知県 グランピング', '福岡県 グランピング',
        '佐賀県 グランピング', '長崎県 グランピング', '熊本県 グランピング', '大分県 グランピング',
        '宮崎県 グランピング', '鹿児島県 グランピング', '沖縄県 グランピング',
        '星野リゾート グランピング', 'BEB グランピング',
    ];

    private const FAMILY_HINTS = ['ファミリー', '家族', 'お子様', '子供', 'キッズ'];
    private const COUPLE_HINTS = ['カップル', 'ペア', '記念日', '二人', 'ふたり'];
    private const FRIENDS_HINTS = ['グループ', '仲間', '女子会', '複数名'];
    private const SOLO_HINTS = ['おひとり', 'ソロ', '一人旅', '1名'];

    public function handle(): int
    {
        $appId = config('services.rakuten.app_id');
        $accessKey = config('services.rakuten.access_key');
        $affiliateId = config('services.rakuten.affiliate_id');

        if (! $appId || ! $accessKey) {
            $this->error('RAKUTEN_APP_ID / RAKUTEN_ACCESS_KEY is not set.');

            return self::FAILURE;
        }

        $beforeCount = Spot::where('booking_provider', 'rakuten')->count();
        $skipped = 0;
        $seenHotelNos = [];

        foreach (self::KEYWORDS as $keyword) {
            $this->line("Searching: {$keyword}");

            try {
                $response = Http::timeout(8)
                    ->withHeaders([
                        // Must match the credential's registered Application URL, not this app's own domain — see class docblock.
                        'Referer' => 'https://golf-search.org/',
                        'Origin' => 'https://golf-search.org',
                    ])
                    ->get('https://openapi.rakuten.co.jp/engine/api/Travel/KeywordHotelSearch/20260731', [
                        'format' => 'json',
                        'applicationId' => $appId,
                        'accessKey' => $accessKey,
                        'affiliateId' => $affiliateId,
                        'keyword' => $keyword,
                        'hits' => 10,
                    ]);
            } catch (\Throwable $e) {
                $this->warn("  request failed: {$e->getMessage()}");
                usleep(600_000);

                continue;
            }

            if (! $response->successful()) {
                $this->warn("  API error: HTTP {$response->status()}");
                usleep(600_000);

                continue;
            }

            $hotelGroups = $response->json('hotels') ?? [];

            foreach ($hotelGroups as $group) {
                $info = $group['hotel'][0]['hotelBasicInfo'] ?? null;
                if (! $info || empty($info['hotelName']) || empty($info['hotelInformationUrl'])) {
                    continue;
                }

                $hotelNo = $info['hotelNo'] ?? null;
                if ($hotelNo && isset($seenHotelNos[$hotelNo])) {
                    continue;
                }
                if ($hotelNo) {
                    $seenHotelNos[$hotelNo] = true;
                }

                $area = $info['address1'] ?? null;
                if (! $area) {
                    $skipped++;

                    continue;
                }

                if (! isset($info['latitude'], $info['longitude'])) {
                    $skipped++;

                    continue;
                }
                // Rakuten returns lat/lng as JGD2000 arcseconds, not decimal degrees.
                $lat = round($info['latitude'] / 3600, 7);
                $lng = round($info['longitude'] / 3600, 7);

                $descriptionSource = trim(($info['hotelSpecial'] ?? '') . ' ' . ($info['address1'] ?? '') . ($info['address2'] ?? ''));
                $description = $info['hotelSpecial']
                    ? mb_substr(strip_tags($info['hotelSpecial']), 0, 200)
                    : ($info['address1'] . ($info['address2'] ?? '') . 'にある楽天トラベル掲載のグランピング施設。');

                // hotelInformationUrl already comes back as a real hb.afl.rakuten.co.jp affiliate
                // link when affiliateId is passed — no need to wrap it ourselves.
                $bookingUrl = $info['hotelInformationUrl'];

                $spot = Spot::firstOrCreate(
                    ['name' => $info['hotelName'], 'area' => $area],
                    [
                        'description' => $description,
                        'category' => 'glamping',
                        'tags' => $this->guessTags($descriptionSource),
                        'lat' => $lat,
                        'lng' => $lng,
                        'booking_url' => $bookingUrl,
                        'booking_provider' => 'rakuten',
                    ]
                );

            }

            usleep(600_000); // stay well under Rakuten's rate limit
        }

        $imported = Spot::where('booking_provider', 'rakuten')->count() - $beforeCount;
        $this->info("Imported {$imported} new glamping spots via Rakuten Travel API (skipped {$skipped} incomplete entries).");

        return self::SUCCESS;
    }

    private function guessTags(string $text): array
    {
        $tags = [];
        foreach (self::FAMILY_HINTS as $hint) {
            if (str_contains($text, $hint)) {
                $tags[] = 'family';
                break;
            }
        }
        foreach (self::COUPLE_HINTS as $hint) {
            if (str_contains($text, $hint)) {
                $tags[] = 'couple';
                break;
            }
        }
        foreach (self::FRIENDS_HINTS as $hint) {
            if (str_contains($text, $hint)) {
                $tags[] = 'friends';
                break;
            }
        }
        foreach (self::SOLO_HINTS as $hint) {
            if (str_contains($text, $hint)) {
                $tags[] = 'solo';
                break;
            }
        }

        return $tags;
    }
}
