@extends('layouts.plain')
@section('title', 'みんなの体験記 | '.config('app.name'))
@section('description', 'キャンプ、グランピング、アクティビティ、岩盤浴、ヒーリング、スパの訪問記録。利用者の実体験から次の休日を探せます。')
@section('content')
<div class="discovery-wrap results-section"><p class="eyebrow">REAL DAYS, REAL STORIES</p><h1>みんなの体験記</h1><p>行ってみたから、伝えたいことがある。</p>@if(session('success'))<p role="status">{{ session('success') }}</p>@endif<div class="journal-grid">@forelse($reviews as $review)@include('spots.review-card')@empty<div class="discovery-empty"><h2>最初の体験記を待っています。</h2><p>訪問した施設のページから、実際の感想を投稿できます。</p><a class="discovery-button" href="{{ route('spots.index') }}">施設を探して書く ↗</a></div>@endforelse</div>@include('spots.pagination',['pages'=>$reviews])</div>
@endsection
