<?php

namespace App\Http\Controllers;

use App\Support\TouristSpots;

use App\Helpers\CongestionHelper;
use App\Models\Spot;
use App\Support\ContentModeration;
use App\Support\LineMessaging;
use App\Support\Discovery;
use App\Models\Review;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    public function index(Request $request, ?string $category = null)
    {
        if ($category !== null) {
            abort_unless(isset(Discovery::CATEGORIES[$category]), 404);
        }
        $filters = $request->validate([
            'q' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:255',
            'tag' => ['nullable', Rule::in(array_keys(Discovery::TAGS))],
            'sort' => 'nullable|in:newest,reviews,rating',
            'verified' => 'nullable|in:1',
        ]);
        $query = Spot::query()->withCount('reviews')->withAvg('reviews', 'rating');
        if ($category) {
            Discovery::category($query, $category);
        }
        if ($request->filled('q')) {
            $term = str_replace(['%', '_'], ['\\%', '\\_'], $filters['q']);
            $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")->orWhere('description', 'like', "%{$term}%")->orWhere('area', 'like', "%{$term}%")->orWhere('address', 'like', "%{$term}%"));
        }

        if ($request->input('verified') === '1') {
            $query->whereNotNull('source_checked_at');
        }

        if ($request->filled('area')) {
            $query->where('area', $request->input('area'));
        }

        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->input('tag'));
        }

        match ($filters['sort'] ?? 'newest') {
            'reviews' => $query->orderByDesc('reviews_count'),
            'rating' => $query->orderByDesc('reviews_avg_rating')->orderByDesc('reviews_count'),
            default => $query->latest(),
        };
        $spots = $query->orderByDesc('id')->paginate(12)->withQueryString();
        $areaQuery = Spot::query()->whereNotNull('area');
        if ($category) { Discovery::category($areaQuery, $category); }
        $areaCounts = $areaQuery->selectRaw('area, count(*) as total')->groupBy('area')->orderBy('area')->pluck('total', 'area');
        $areas = $areaCounts->keys();
        $categoryCounts = collect(Discovery::CATEGORIES)->map(function ($item, $key) {
            $count = Spot::query();
            Discovery::category($count, $key);
            return $count->count();
        });
        $catalogStats = ['total' => Spot::count(), 'verified' => Spot::whereNotNull('source_checked_at')->count(), 'areas' => Spot::whereNotNull('area')->distinct()->count('area')];
        $latestReviews = Review::with('spot')->where('is_hidden', false)->latest()->limit(3)->get();

        return view('spots.index', compact('spots', 'areas', 'category', 'latestReviews', 'areaCounts', 'categoryCounts', 'catalogStats'));
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
            'category' => ['required', Rule::in(array_keys(Discovery::CATEGORIES))],
            'tags' => 'nullable|array|max:4',
            'tags.*' => [Rule::in(array_keys(Discovery::TAGS))],
            'official_url' => 'nullable|url:http,https|max:1000',
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

        // キャンプの前後に寄れる場所。楽天には観光スポットのAPIが無いため
        // OpenStreetMap から取っている（scripts/fetch-tourist-spots.py）。
        $tourist = TouristSpots::forPrefecture($area);

        return view('spots.area', compact('area', 'spots', 'otherAreas', 'tourist'));
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
                "「{$spot->name}」の混雑の参考情報が「{$newBucket}」に変わりました。"
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

    public function compare(Request $request)
    {
        $validated = $request->validate(['ids' => 'nullable|array|max:3', 'ids.*' => 'integer|distinct|exists:spots,id']);
        $spots = Spot::withCount('reviews')->withAvg('reviews', 'rating')->whereIn('id', $validated['ids'] ?? [])->get();
        return view('spots.compare', compact('spots'));
    }

    public function journal()
    {
        $reviews = Review::with('spot')->where('is_hidden', false)->latest()->paginate(12);
        return view('spots.journal', compact('reviews'));
    }

    public function shortlist(Request $request)
    {
        $validated = $request->validate(['ids' => 'nullable|array|max:50', 'ids.*' => 'integer|min:1|distinct']);
        $ids = $validated['ids'] ?? [];
        $spots = Spot::withCount('reviews')->withAvg('reviews', 'rating')->whereIn('id', $ids)->get()
            ->sortBy(fn ($spot) => array_search($spot->id, $ids))->values();
        return view('spots.shortlist', compact('spots'));
    }
}
