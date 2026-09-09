<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Support\CityGuide;

class CityGuideController extends Controller
{
    public function index()
    {
        $cities = CityGuide::cities();
        $counts = array_fill_keys(CityGuide::CATEGORIES, 0);
        foreach (array_keys($cities) as $city) {
            foreach (CityGuide::forCity($city) as $guide) {
                $counts[$guide['category']]++;
            }
        }

        return view('cities.index', compact('cities', 'counts'));
    }

    public function show(string $city)
    {
        $metadata = CityGuide::cities()[$city] ?? null;
        abort_unless($metadata, 404);
        $guides = CityGuide::forCity($city);
        $spots = Spot::whereIn('editorial_guide', array_keys($guides))->get()->keyBy('editorial_guide');

        return view('cities.show', compact('city', 'metadata', 'guides', 'spots'));
    }
}
