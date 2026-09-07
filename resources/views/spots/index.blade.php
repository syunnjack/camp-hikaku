@extends('layouts.plain')
@php
  $heading = $category ? \App\Support\Discovery::label($category).'を探す' : '今日は、どんな余白に出かけよう。';
  $description = $category ? \App\Support\Discovery::CATEGORIES[$category]['description'] : 'グランピング、ソロキャンプ、アクティビティ、岩盤浴、ヒーリング、スパ。エリアと体験記から、自分に合う過ごし方を探せます。';
@endphp
@section('title', ($category ? \App\Support\Discovery::label($category).'の施設・体験記' : 'アウトドアと癒やしの施設・体験記').' | '.config('app.name'))
@section('description', $description)
@push('structured-data')
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'ItemList','itemListElement'=>collect($spots->items())->values()->map(fn($spot,$i)=>['@type'=>'ListItem','position'=>$spots->firstItem()+$i,'name'=>$spot->name,'url'=>route('spots.show',$spot)])->all()]) !!}</script>
@endpush
@section('content')
<section class="discovery-hero"><div class="discovery-wrap"><p class="eyebrow">OUTDOOR & WELLNESS / 自然と、休息。</p><h1>{{ $heading }}</h1><p class="hero-copy">{{ $description }}</p>
<form method="GET" class="discovery-search" action="{{ $category ? route('categories.show',$category) : route('spots.index') }}">
<label class="search-key">キーワード<input name="q" value="{{ request('q') }}" maxlength="100" placeholder="施設名・地域・気になる体験"></label>
<label>エリア<select name="area"><option value="">全国から探す</option>@foreach($areas as $area)<option @selected(request('area') === $area)>{{ $area }}</option>@endforeach</select></label>
<label>誰と行く？<select name="tag"><option value="">すべて</option>@foreach(\App\Support\Discovery::TAGS as $key=>$label)<option value="{{ $key }}" @selected(request('tag')===$key)>{{ $label }}</option>@endforeach</select></label>
<button class="discovery-button" type="submit">施設を探す ↗</button></form><p class="hero-note">小さな休日も、特別な旅も。みんなの体験をヒントに。</p></div></section>
<div class="discovery-wrap"><nav class="category-strip" aria-label="体験ジャンル">@foreach(\App\Support\Discovery::CATEGORIES as $key=>$item)<a href="{{ route('categories.show',$key) }}" @if($category === $key) aria-current="page" @endif><span>{{ $item['symbol'] }}</span>{{ $item['label'] }} ↗</a>@endforeach</nav>
<section class="results-section" aria-labelledby="results-title"><div class="section-top"><div><p class="eyebrow">FIND YOUR NEXT PLACE</p><h2 id="results-title">{{ $category ? \App\Support\Discovery::label($category) : '気になる場所を見つける' }} <small>{{ number_format($spots->total()) }}件</small></h2></div>
<form method="GET">@foreach(request()->only('q','area','tag') as $key=>$value)<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endforeach<label for="sort">並び順</label><select id="sort" name="sort"><option value="newest">新着順</option><option value="reviews" @selected(request('sort')==='reviews')>体験記が多い順</option><option value="rating" @selected(request('sort')==='rating')>評価順</option></select><button class="quiet-button">適用</button></form></div>
@if(request()->hasAny(['q','area','tag']))<p>絞り込み：{{ request('q') }} {{ request('area') }} {{ \App\Support\Discovery::TAGS[request('tag')] ?? '' }}　<a href="{{ $category ? route('categories.show',$category) : route('spots.index') }}">解除する</a></p>@endif
<form action="{{ route('spots.compare') }}" method="GET" id="compare-form"><div class="spot-grid">@forelse($spots as $spot)
<article class="spot-card"><div class="spot-card-top"><span class="category-label">{{ \App\Support\Discovery::label($spot->category) }}</span><span>{{ $spot->area ?: 'エリア未登録' }}</span></div><h3><a href="{{ route('spots.show',$spot) }}">{{ $spot->name }} ↗</a></h3><p>{{ \Illuminate\Support\Str::limit($spot->description ?: '施設の紹介はまだ登録されていません。',100) }}</p><div class="spot-tags">@foreach($spot->tags ?? [] as $tag)<span>#{{ \App\Support\Discovery::TAGS[$tag] ?? $tag }}</span>@endforeach</div><div class="spot-card-bottom"><span>@if($spot->reviews_count)<b class="rating">★ {{ number_format($spot->reviews_avg_rating,1) }}</b> <small>体験記 {{ $spot->reviews_count }}件</small>@else<small>体験記を募集中</small>@endif</span><label><input type="checkbox" name="ids[]" value="{{ $spot->id }}"> 比較</label></div></article>
@empty<div class="discovery-empty"><h3>この条件の施設は、まだありません。</h3><p>エリアやキーワードを変えるか、知っている施設を登録してください。</p><a class="discovery-button" href="{{ route('spots.create') }}">施設を登録する ↗</a></div>@endforelse</div>
@if($spots->count())<div class="compare-bar"><span>気になる施設を選んで、横並びで比較。<small> 最大3件</small></span><button class="discovery-button">選んだ施設を比較する ↗</button><span id="compare-feedback" role="status"></span></div>@endif</form>@include('spots.pagination',['pages'=>$spots])</section>
<section class="journal-section"><div class="section-top"><div><p class="eyebrow">REAL DAYS, REAL STORIES</p><h2>みんなの体験記</h2></div><a href="{{ route('journals.index') }}">体験記を読む ↗</a></div><div class="journal-grid">@forelse($latestReviews as $review) @include('spots.review-card') @empty<div class="discovery-empty"><h3>あなたの一日が、誰かのきっかけに。</h3><p>訪問した施設のページから、過ごし方や気づいたことを残せます。</p><a href="#results-title">施設を探して体験記を書く ↗</a></div>@endforelse</div></section>
<section class="discovery-faq"><p class="eyebrow">BEFORE YOU GO</p><h2>出かける前に</h2><details><summary>予約や料金はどこで確認できますか？</summary><p>施設ページの公式サイト、または広告と明記した予約サイトで確認できます。体験記の金額は訪問時の個人の支出で、現在の料金ではありません。</p></details><details><summary>混雑報告は予約の空き情報ですか？</summary><p>混雑報告は利用者が感じた混み具合です。過去の報告を含む参考情報で、当日の予約枠や営業状況を保証しません。</p></details><details><summary>どんな体験記を投稿できますか？</summary><p>実際に訪問した感想、訪問日、同行者、使った金額を投稿できます。宣伝、個人情報、他者の文章の転載はお控えください。</p><a href="{{ route('guidelines') }}">投稿ガイドライン</a></details></section></div>
@endsection
@section('scripts')
<script>document.querySelector('#compare-form')?.addEventListener('submit',e=>{const n=e.currentTarget.querySelectorAll('input:checked').length;if(n<2||n>3){e.preventDefault();document.querySelector('#compare-feedback').textContent='比較する施設を2〜3件選んでください。';}});</script>
@endsection
