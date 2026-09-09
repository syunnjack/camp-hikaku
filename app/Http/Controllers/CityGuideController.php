<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Support\CityGuide;
use App\Support\ApiVerifiedFacilities;

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

        $records = collect(ApiVerifiedFacilities::all())->where('city', $city);
        $additionalSpots = Spot::where('area', $metadata['area'])->get()
            ->filter(fn ($spot) => ! $spots->contains('id', $spot->id)
                && $records->contains(fn ($record) => ApiVerifiedFacilities::matches($spot, $record)));

        return view('cities.show', compact('city', 'metadata', 'guides', 'spots', 'additionalSpots'));
    }
}
