<?php

namespace Database\Seeders;

use App\Support\CapitalFacilities;

class CapitalFacilitiesSeeder extends ApiVerifiedFacilitiesSeeder
{
    protected function records(): array
    {
        return CapitalFacilities::all();
    }
}
