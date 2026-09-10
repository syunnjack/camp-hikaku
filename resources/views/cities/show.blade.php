@extends('layouts.plain')
@section('title', $metadata['label'].'の休日ガイド｜施設・料金・予約を比較 | '.config('app.name'))
@section('description', $metadata['intro'].' 公式情報に基づく所在地、料金の条件、利用案内、訪問者の体験記へのリンクを掲載。')
@push('structured-data')
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'CollectionPage','name'=>$metadata['label'].'の休日ガイド','url'=>route('cities.show',$city),'inLanguage'=>'ja','dateModified'=>'2026-09-10','mainEntity'=>['@type'=>'ItemList','itemListElement'=>collect($guides)->map(fn($guide,$key)=>['@type'=>'ListItem','name'=>$guide['name'],'url'=>$spots->has($key)?route('spots.show',$spots[$key]):$guide['official_url']])->values()->concat($additionalSpots->map(fn($spot)=>['@type'=>'ListItem','name'=>$spot->name,'url'=>route('spots.show',$spot)])->values())->map(fn($v,$i)=>$v+['position'=>$i+1])->all()]]) !!}</script>
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>[['@type'=>'ListItem','position'=>1,'name'=>'施設を探す','item'=>route('spots.index')],['@type'=>'ListItem','position'=>2,'name'=>'都市ガイド','item'=>route('cities.index')],['@type'=>'ListItem','position'=>3,'name'=>$metadata['label'],'item'=>route('cities.show',$city)]]]) !!}</script>
@endpush
@section('content')
<div class="discovery-wrap metro-guide">
  <nav aria-label="パンくず"><a href="{{ route('spots.index') }}">施設を探す</a> / <a href="{{ route('cities.index') }}">都市ガイド</a> / {{ $metadata['label'] }}</nav>
  <header class="metro-intro"><p class="metro-eyebrow">{{ $metadata['area'] }} · CITY GUIDE</p><h1>{{ $metadata['label'] }}から、<br>休日を選ぶ。</h1><p>{{ $metadata['intro'] }}</p><p class="small">掲載施設 {{ count($guides) + $additionalSpots->count() }}施設。公式確認日は各施設に表示しています。現地訪問による評価・ランキングではありません。</p></header>
  <nav class="metro-jumps" aria-label="掲載ジャンル">@foreach(\App\Support\CityGuide::CATEGORIES as $category)@php($genreGuides=collect($guides)->where('category',$category))@php($count=$genreGuides->count()+$additionalSpots->where('category',$category)->count())@if($count)<a href="#{{ $genreGuides->isNotEmpty() ? $genreGuides->keys()->first() : 'more-genre-'.$category }}">{{ \App\Support\Discovery::label($category) }}（{{ $count }}）</a>@else<span>{{ \App\Support\Discovery::label($category) }}（市区内の掲載なし）</span>@endif @endforeach</nav>
  @foreach(['city'=>'市内の施設','nearby'=>'市外の近郊候補'] as $scope=>$scopeLabel)
  @php($selections=collect($guides)->where('scope',$scope))
  @if($selections->isNotEmpty())
  <section class="mb-5" aria-labelledby="scope-{{ $scope }}"><h2 id="scope-{{ $scope }}">{{ $scopeLabel }} <small>（{{ $selections->count() }}施設）</small></h2>@if($scope==='nearby')<p>{{ $metadata['label'] }}の市内施設には含めていません。記載の市町村までの移動を含めて計画してください。</p>@endif
  <div class="metro-grid">
  @foreach($selections as $key=>$guide)<article class="metro-card" id="{{ $key }}" data-city-scope="{{ $scope }}"><p class="metro-eyebrow">{{ \App\Support\Discovery::label($guide['category']) }} · {{ $guide['municipality'] }} · {{ $scope==='city'?'市内':'近郊（市外）' }}</p><h3>{{ $guide['name'] }}</h3><p>{{ $guide['summary'] }}</p><p class="metro-price">{{ $guide['price'] }}</p><p class="small">{{ $guide['price_condition'] }}</p><p><strong>所在地：</strong>{{ $guide['address'] }}</p><dl class="metro-facts">@foreach($guide['facts'] as $label=>$value)<div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>@endforeach</dl>
  @if($spots->has($key))<a class="discovery-button" href="{{ route('spots.show',$spots[$key]) }}#official-guide">利用案内・体験記を見る →</a><p class="mt-3"><a href="{{ route('spots.show',$spots[$key]) }}#write-review">訪問した体験を投稿する</a></p>@else<a href="{{ $guide['official_url'] }}" target="_blank" rel="noopener noreferrer">公式の利用案内を見る ↗</a>@endif
  <p class="small">公式確認：<time datetime="{{ $guide['checked_at'] }}">{{ $guide['checked_at'] }}</time></p><p class="small">出典：@foreach($guide['sources'] as $source)<a href="{{ $source['url'] }}" target="_blank" rel="noopener noreferrer">{{ $source['label'] }}</a>{{ $loop->last?'':' / ' }}@endforeach</p></article>@endforeach
  </div></section>
  @endif
  @endforeach
  @if($additionalSpots->isNotEmpty())
  <section class="mb-5" aria-labelledby="more-city-facilities"><h2 id="more-city-facilities">このエリアで見つかる施設 <small>（{{ $additionalSpots->count() }}施設）</small></h2><p>所在地と紹介内容を公式サイトで照合した施設です。詳しい営業条件は各施設の公式案内をご確認ください。</p>
  @foreach($additionalSpots->groupBy('category') as $category=>$genreSpots)<h3 id="more-genre-{{ $category }}">{{ \App\Support\Discovery::label($category) }}（{{ $genreSpots->count() }}）</h3><div class="metro-grid mb-4">@foreach($genreSpots as $spot)@php($catalogRecord=\App\Support\CapitalFacilities::forSpot($spot))<article class="metro-card" data-additional-city="{{ $city }}"><p class="metro-eyebrow">{{ \App\Support\Discovery::label($spot->category) }} · {{ $metadata['label'] }}</p><h3><a href="{{ route('spots.show',$spot) }}">{{ $spot->name }}</a></h3><p>{{ $catalogRecord['description'] ?? $spot->description }}</p><p><strong>所在地：</strong>{{ $catalogRecord['address'] ?? $spot->address }}</p>@if($spot->source_checked_at)<p class="small">公式確認：{{ $spot->source_checked_at->format('Y-m-d') }}</p>@endif<a class="discovery-button" href="{{ route('spots.show',$spot) }}">施設情報・体験記を見る →</a></article>@endforeach</div>@endforeach</section>
  @endif
  <aside class="metro-note"><h2>ほかの候補も探す</h2><p>このページは公式情報を詳しく確認した施設のガイドです。県内の施設一覧や、ほかの都市にも検索を広げられます。</p><a href="{{ route('areas.show',$metadata['area']) }}">{{ $metadata['area'] }}全体の施設一覧 →</a><p class="mt-3"><a href="{{ route('cities.index') }}">全国の県庁所在地・都市から選び直す →</a></p></aside>
</div>
@endsection
