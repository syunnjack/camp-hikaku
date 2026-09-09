<?php

namespace App\Support;

class CityGuide
{
    public const CATEGORIES = ['glamping', 'solo', 'activity', 'ganbanyoku', 'healing', 'spa'];

    public static function cities(): array
    {
        return json_decode(file_get_contents(__DIR__.'/designated-cities.json'), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function all(): array
    {
        return json_decode(file_get_contents(__DIR__.'/city-guide.json'), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function forCity(string $city): array
    {
        $metadata = self::cities()[$city] ?? throw new \InvalidArgumentException('Unknown city.');
        $catalog = self::all();
        foreach (array_keys(RegionalGuide::REGIONS) as $region) {
            $catalog += RegionalGuide::all($region);
        }
        $guides = [];
        foreach ($metadata['facilities'] as $selection) {
            $guides[$selection['key']] = $catalog[$selection['key']] + $selection;
        }

        return $guides;
    }
}
