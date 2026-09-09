<?php

namespace App\Support;

use App\Models\Spot;

class RegionalGuide
{
    public const REGIONS = [
        'metropolitan' => ['label'=>'首都圏', 'areas'=>'東京・神奈川・千葉・埼玉', 'eyebrow'=>'TOKYO · KANAGAWA · CHIBA · SAITAMA', 'checked_at'=>'2026-09-08', 'published_at'=>'2026-09-10'],
        'kansai' => ['label'=>'関西', 'areas'=>'大阪・京都・兵庫・奈良・滋賀・和歌山', 'eyebrow'=>'OSAKA · KYOTO · HYOGO · NARA · SHIGA · WAKAYAMA', 'checked_at'=>'2026-09-09', 'published_at'=>'2026-09-10'],
    ];

    public static function all(string $region): array
    {
        if (!isset(self::REGIONS[$region])) {
            throw new \InvalidArgumentException('Unknown guide region.');
        }

        return json_decode(file_get_contents(__DIR__."/{$region}-guide.json"), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function forSpot(Spot $spot): ?array
    {
        if (!$spot->editorial_guide) {
            return null;
        }
        foreach (self::REGIONS as $region => $metadata) {
            $guide = self::all($region)[$spot->editorial_guide] ?? null;
            if ($guide) {
                return $guide + ['region'=>$region, 'region_label'=>$metadata['label']];
            }
        }

        $guide = CityGuide::all()[$spot->editorial_guide] ?? null;
        if ($guide) {
            return $guide + ['region'=>'cities', 'region_label'=>CityGuide::cities()[$guide['city']]['label']];
        }

        return null;
    }
}
