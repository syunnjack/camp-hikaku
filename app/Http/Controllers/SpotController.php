<?php

namespace App\Http\Controllers;

use App\Helpers\CongestionHelper;
use App\Models\Spot;
use App\Support\ContentModeration;
use App\Support\LineMessaging;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    public function index(Request $request)
    {
        $query = Spot::query();

        if ($request->filled('area')) {
            $query->where('area', $request->input('area'));
        }

        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->input('tag'));
        }

        $spots = $query->latest()->get();
        $areas = Spot::query()->whereNotNull('area')->distinct()->pluck('area');

        return view('spots.index', compact('spots', 'areas'));
    }

    public function create()
    {
        return view('spots.create');
    }

    public function store(Request $request)
    {
        if (! empty($request->input('website'))) {
            return redirect()->route('spots.thanks');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'area' => 'nullable|string|max:255',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ]);

        if (ContentModeration::containsNgWord($validated['name'] . ' ' . ($validated['description'] ?? ''))) {
            return back()->withErrors(['name' => '投稿内容に使用できない文字列が含まれています。'])->withInput();
        }

        $ipHash = ContentModeration::clientIpHash($request);
        if (ContentModeration::isTooSoon("spot-create:{$ipHash}", 30)) {
            return back()->withErrors(['name' => '投稿間隔が短すぎます。しばらく待ってから再度お試しください。'])->withInput();
        }

        Spot::create($validated);

        return redirect()->route('spots.thanks');
    }

    public function show(Spot $spot)
    {
        $spot->load(['reviews' => fn ($q) => $q->latest()]);

        // 同じエリアの他のキャンプ場。個別ページから他ページへ行けるようにする
        $nearbySpots = Spot::query()
            ->where('area', $spot->area)
            ->whereNotNull('area')
            ->where('id', '!=', $spot->id)
            ->orderByDesc('likes_count')
            ->limit(8)
            ->get();

        return view('spots.show', compact('spot', 'nearbySpots'));
    }

    /**
     * 都道府県ごとの一覧ページ。
     *
     * これまで入口はトップの地図と個別ページだけで、「北海道 キャンプ場」の
     * ような地域名での検索に応えるページが無かった。エリアごとにまとめて
     * 見られるページを用意する。
     */
    public function areaIndex()
    {
        $areas = Spot::query()
            ->whereNotNull('area')
            ->selectRaw('area, count(*) as spots_count')
            ->groupBy('area')
            ->orderByDesc('spots_count')
            ->get();

        $total = Spot::query()->whereNotNull('area')->count();

        return view('spots.areas', compact('areas', 'total'));
    }

    public function areaShow(string $area)
    {
        $spots = Spot::query()
            ->where('area', $area)
            ->orderByDesc('likes_count')
            ->orderBy('name')
            ->get();

        abort_if($spots->isEmpty(), 404);

        $otherAreas = Spot::query()
            ->whereNotNull('area')
            ->where('area', '!=', $area)
            ->selectRaw('area, count(*) as spots_count')
            ->groupBy('area')
            ->orderByDesc('spots_count')
            ->get();

        return view('spots.area', compact('area', 'spots', 'otherAreas'));
    }

    public function reportCongestion(Request $request, Spot $spot)
    {
        $ipHash = ContentModeration::clientIpHash($request);
        if (ContentModeration::isTooSoon("congestion:{$spot->id}:{$ipHash}", 60)) {
            return response()->json(['error' => '報告間隔が短すぎます。しばらく待ってから再度お試しください。'], 429);
        }

        $validated = $request->validate([
            'level' => 'required|in:empty,slightly_crowded,crowded,very_crowded',
        ]);

        $levelMap = ['empty' => 1, 'slightly_crowded' => 2, 'crowded' => 3, 'very_crowded' => 4];
        $numericLevel = $levelMap[$validated['level']];

        $previousBucket = CongestionHelper::getText($spot->average_congestion);

        $reports = $spot->congestion_reports ?? [];
        $reports[] = $numericLevel;
        $average = array_sum($reports) / count($reports);

        $spot->congestion_reports = $reports;
        $spot->average_congestion = round($average, 2);
        $spot->save();

        $newBucket = CongestionHelper::getText($spot->average_congestion);
        if ($newBucket !== $previousBucket) {
            $this->notifyFavoritesOfCongestionChange($spot, $newBucket);
        }

        return response()->json(['average_congestion' => $spot->average_congestion]);
    }

    private function notifyFavoritesOfCongestionChange(Spot $spot, string $newBucket): void
    {
        $spot->loadMissing('favorites.lineUser');

        foreach ($spot->favorites as $favorite) {
            if (! $favorite->lineUser) {
                continue;
            }

            LineMessaging::push(
                $favorite->lineUser->line_user_id,
                "「{$spot->name}」の空き状況が「{$newBucket}」に変わりました。"
            );
        }
    }

    public function like(Request $request, Spot $spot)
    {
        $ipHash = ContentModeration::clientIpHash($request);
        if (ContentModeration::isTooSoon("like:{$spot->id}:{$ipHash}", 60)) {
            return response()->json(['error' => 'いいね！は少し時間を空けてから再度お試しください。'], 429);
        }

        $spot->increment('likes_count');
        $spot->refresh();

        return response()->json(['likes_count' => $spot->likes_count]);
    }

    public function sitemap()
    {
        $spots = Spot::select('id', 'updated_at')->get();
        $areas = Spot::query()->whereNotNull('area')->distinct()->orderBy('area')->pluck('area');
        $xml = view('sitemap', compact('spots', 'areas'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
