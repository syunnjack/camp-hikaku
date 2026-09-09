<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Support\RegionalGuide;

class MetropolitanGuideController extends Controller
{
    public function index(string $region = 'metropolitan')
    {
        abort_unless(isset(RegionalGuide::REGIONS[$region]), 404);
        $metadata = RegionalGuide::REGIONS[$region];
        $guides = RegionalGuide::all($region);
        $spots = Spot::whereIn('editorial_guide', array_keys($guides))->get()->keyBy('editorial_guide');

        return view('guides.metropolitan', compact('guides', 'spots', 'region', 'metadata'));
    }
}
