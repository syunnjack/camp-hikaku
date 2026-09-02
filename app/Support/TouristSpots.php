<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

/**
 * 都道府県ごとの観光スポット。
 *
 * 出典: OpenStreetMap contributors（ODbL）
 *       https://www.openstreetmap.org/copyright
 *
 * **楽天ウェブサービスに観光スポットのAPIは無い**（2026-09-02 に一覧を確認）。
 * 宿・施設は楽天から引き、観光スポットは OSM から取って組み合わせる。
 *
 * データは `scripts/fetch-tourist-spots.py` が
 * storage/app/tourist-spots.json を作る。名前が入っている施設だけ。
 *
 * **取得できなかった県は「0件」と言い切らない。** Overpass は混むと
 * 200 のまま空を返すため、失敗した県は failedPrefectures に記録してある。
 */
class TouristSpots
{
    private const FILE = 'tourist-spots.json';

    /**
     * @return array{spots: list<array<string, mixed>>, confirmedOn: string, incomplete: bool}
     */
    public static function forPrefecture(string $prefecture, int $limit = 12): array
    {
        $data = Cache::remember('tourist-spots', now()->addHours(12), function () {
            $path = storage_path('app/' . self::FILE);

            if (! is_file($path)) {
                return null;
            }

            return json_decode((string) file_get_contents($path), true);
        });

        if (! is_array($data)) {
            return ['spots' => [], 'confirmedOn' => '', 'incomplete' => false];
        }

        $spots = $data['byPrefecture'][$prefecture] ?? [];

        return [
            'spots' => array_slice($spots, 0, $limit),
            'confirmedOn' => $data['confirmedOn'] ?? '',
            'incomplete' => in_array($prefecture, $data['failedPrefectures'] ?? [], true),
        ];
    }
}
