<?php

namespace App\Support;

class CapitalFacilities
{
    public static function all(): array
    {
        return json_decode(file_get_contents(__DIR__.'/capital-facilities.json'), true, 512, JSON_THROW_ON_ERROR);
    }
}
