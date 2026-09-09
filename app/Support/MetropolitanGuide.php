<?php

namespace App\Support;

use App\Models\Spot;

class MetropolitanGuide
{
    public static function all(): array
    {
        return json_decode(file_get_contents(__DIR__.'/metropolitan-guide.json'), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function forSpot(Spot $spot): ?array
    {
        return self::all()[$spot->editorial_guide ?? ''] ?? null;
    }
}
