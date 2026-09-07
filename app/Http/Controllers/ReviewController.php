<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Support\ContentModeration;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Support\Discovery;

class ReviewController extends Controller
{
    public function store(Request $request, Spot $spot)
    {
        if (! empty($request->input('website'))) {
            return back();
        }

        $validated = $request->validate([
            'nickname' => 'nullable|string|max:30',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:5|max:1000',
            'visited_on' => 'nullable|date_format:Y-m-d|before_or_equal:today',
            'party' => ['nullable', Rule::in(array_keys(Discovery::TAGS))],
            'cost' => 'nullable|integer|between:0,1000000',
        ]);

        if (ContentModeration::containsNgWord(($validated['nickname'] ?? '').' '.$validated['comment'])) {
            return back()->withErrors(['comment' => '投稿内容に使用できない文字列が含まれています。'])->withInput();
        }

        $ipHash = ContentModeration::clientIpHash($request);
        if (ContentModeration::isTooSoon("review:{$spot->id}:{$ipHash}", 30)) {
            return back()->withErrors(['comment' => '投稿間隔が短すぎます。しばらく待ってから再度お試しください。'])->withInput();
        }

        $spot->reviews()->create([
            'nickname' => ($validated['nickname'] ?? '') !== '' ? $validated['nickname'] : '匿名',
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'ip_hash' => $ipHash,
            'visited_on' => $validated['visited_on'] ?? null,
            'party' => $validated['party'] ?? null,
            'cost' => $validated['cost'] ?? null,
        ]);
        $spot->touch();

        return back()->with('success', '口コミを投稿しました。');
    }

    public function report(Request $request, Review $review)
    {
        abort_if($review->is_hidden, 404);
        $validated = $request->validate(['reason' => 'required|in:spam,personal,abuse,inaccurate']);
        DB::table('review_reports')->insertOrIgnore([
            'review_id' => $review->id, 'reason' => $validated['reason'],
            'ip_hash' => ContentModeration::clientIpHash($request),
            'created_at' => now(), 'updated_at' => now(),
        ]);
        return back()->with('success', '通報を受け付けました。運営が内容を確認します。');
    }
}
