<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Support\CityGuide;
use App\Support\ApiVerifiedFacilities;
use App\Support\CapitalFacilities;

class CityGuideController extends Controller
{
    public function index()
    {
        $cities = CityGuide::cities();
        $counts = array_fill_keys(CityGuide::CATEGORIES, 0);
        $catalog = collect(array_merge(ApiVerifiedFacilities::all(), CapitalFacilities::all()));
        $available = Spot::whereIn('area', array_column($cities, 'area'))->get();
        $cityCounts = [];
        foreach (array_keys($cities) as $city) {
            $guides = collect(CityGuide::forCity($city));
            $records = $catalog->where('city', $city);
            $additional = $available->filter(fn ($spot) => ! $guides->has($spot->editorial_guide ?? '')
                && $records->contains(fn ($record) => ApiVerifiedFacilities::matches($spot, $record)));
            foreach ($guides->concat($additional) as $guide) {
                $counts[$guide['category']]++;
            }
            $cityCounts[$city] = ['city' => $guides->where('scope', 'city')->count() + $additional->count(), 'nearby' => $guides->where('scope', 'nearby')->count()];
        }

        return view('cities.index', compact('cities', 'counts', 'cityCounts'));
    }

    public function show(string $city)
    {
        $metadata = CityGuide::cities()[$city] ?? null;
        abort_unless($metadata, 404);
        $guides = CityGuide::forCity($city);
        $spots = Spot::whereIn('editorial_guide', array_keys($guides))->get()->keyBy('editorial_guide');

        $records = collect(array_merge(ApiVerifiedFacilities::all(), CapitalFacilities::all()))->where('city', $city);
        $additionalSpots = Spot::where('area', $metadata['area'])->get()
            ->filter(fn ($spot) => ! $spots->contains('id', $spot->id)
                && $records->contains(fn ($record) => ApiVerifiedFacilities::matches($spot, $record)));

        return view('cities.show', compact('city', 'metadata', 'guides', 'spots', 'additionalSpots'));
    }
}
