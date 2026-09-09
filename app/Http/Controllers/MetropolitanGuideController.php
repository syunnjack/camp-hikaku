<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Support\MetropolitanGuide;

class MetropolitanGuideController extends Controller
{
    public function index()
    {
        $guides = MetropolitanGuide::all();
        $spots = Spot::whereIn('editorial_guide', array_keys($guides))->get()->keyBy('editorial_guide');

        return view('guides.metropolitan', compact('guides', 'spots'));
    }
}
