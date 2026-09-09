<?php

namespace Database\Seeders;

use App\Support\RegionalGuide;

class KansaiGuideSeeder extends MetropolitanGuideSeeder
{
    protected function guides(): array
    {
        return RegionalGuide::all('kansai');
    }
}
