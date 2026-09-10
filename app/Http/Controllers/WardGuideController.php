<?php

namespace App\Http\Controllers;

use App\Support\Discovery;
use App\Support\WardGuide;

class WardGuideController extends Controller
{
    public function index(string $metro)
    {
        $metadata = WardGuide::METROS[$metro] ?? null;
        abort_unless($metadata, 404);
        $wards = WardGuide::wards($metro);
        $groups = WardGuide::groups();
        $counts = collect($wards)->mapWithKeys(fn ($label, $slug) => [$slug => $groups->get($metro.'/'.$slug, collect())->count()]);
        return view('wards.index', compact('metro', 'metadata', 'wards', 'counts'));
    }

    public function show(string $metro, string $ward)
    {
        $metadata = WardGuide::METROS[$metro] ?? null;
        $label = WardGuide::wards($metro)[$ward] ?? null;
        abort_unless($metadata && $label, 404);
        $spots = WardGuide::groups()->get($metro.'/'.$ward, collect());
        $categories = Discovery::CATEGORIES;
        $noindex = $spots->isEmpty();
        return view('wards.show', compact('metro', 'ward', 'metadata', 'label', 'spots', 'categories', 'noindex'));
    }
}
