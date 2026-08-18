<?php

use App\Http\Controllers\SpotController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LineLoginController;
use App\Http\Controllers\LineWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SpotController::class, 'index'])->name('spots.index');
Route::get('/create', [SpotController::class, 'create'])->name('spots.create');
Route::post('/spots', [SpotController::class, 'store'])->name('spots.store')->middleware('throttle:5,1');
Route::get('/areas', [SpotController::class, 'areaIndex'])->name('areas.index');
Route::get('/areas/{area}', [SpotController::class, 'areaShow'])->name('areas.show');
Route::get('/spots/{spot}', [SpotController::class, 'show'])->name('spots.show');
Route::post('/spots/{spot}/reviews', [ReviewController::class, 'store'])->name('spots.reviews.store')->middleware('throttle:10,1');
Route::post('/spots/{spot}/like', [SpotController::class, 'like'])->name('spots.like')->middleware('throttle:30,1');
Route::post('/spots/{spot}/congestion', [SpotController::class, 'reportCongestion'])->name('spots.congestion.report')->middleware('throttle:30,1');
Route::view('/thanks', 'spots.thanks')->name('spots.thanks');

Route::view('/about', 'about')->name('about');
Route::get('/sitemap.xml', [SpotController::class, 'sitemap'])->name('sitemap');

// LINE連携（お気に入りキャンプ場の空き状況通知）
Route::get('/line/login', [LineLoginController::class, 'redirect'])->name('line.login');
Route::get('/line/callback', [LineLoginController::class, 'callback'])->name('line.callback');
Route::post('/spots/{spot}/favorite', [FavoriteController::class, 'toggle'])
    ->name('spots.favorite.toggle')
    ->middleware('throttle:10,1');
Route::post('/line/webhook', [LineWebhookController::class, 'handle'])->name('line.webhook');
