<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('reviews:reports', function () {
    $rows = \Illuminate\Support\Facades\DB::table('review_reports')
        ->join('reviews', 'reviews.id', '=', 'review_reports.review_id')
        ->select('reviews.id', 'reviews.nickname', 'reviews.comment', 'reviews.is_hidden', 'review_reports.reason', 'review_reports.created_at')
        ->orderByDesc('review_reports.id')->limit(100)->get();
    $this->table(['ID', '名前', '本文', '非表示', '理由', '通報日時'], $rows->map(fn ($row) => (array) $row)->all());
})->purpose('運営用：直近100件の体験記通報を確認');

Artisan::command('reviews:visibility {review} {state : hide or show}', function () {
    if (! in_array($this->argument('state'), ['hide', 'show'], true)) {
        $this->error('state は hide または show を指定してください。');
        return 1;
    }
    $review = \App\Models\Review::findOrFail($this->argument('review'));
    $review->is_hidden = $this->argument('state') === 'hide';
    $review->save();
    $review->spot->touch();
    $this->info('体験記の公開状態を更新しました。');
})->purpose('運営用：確認した体験記を非表示・再公開');
