<?php

namespace Database\Seeders;

use App\Support\CityGuide;

class CityGuideSeeder extends MetropolitanGuideSeeder
{
    protected function guides(): array
    {
        return CityGuide::all();
    }
}
