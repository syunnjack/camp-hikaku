@extends('layouts.plain')
@section('title', '全国20の政令指定都市から探す｜アウトドア・温浴・癒やしの施設 | '.config('app.name'))
@section('description', '札幌から熊本まで全20政令指定都市の施設ガイド。6ジャンルの40施設について料金・予約・利用条件を公式情報で比較。市内と近郊を区別して掲載しています。')
@push('structured-data')
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@context'=>'https://schema.org','@type'=>'CollectionPage','name'=>'全国20政令指定都市の施設ガイド','url'=>route('cities.index'),'inLanguage'=>'ja','mainEntity'=>['@type'=>'ItemList','itemListElement'=>collect($cities)->map(fn($v,$k)=>['@type'=>'ListItem','name'=>$v['label'],'url'=>route('cities.show',$k)])->values()->map(fn($v,$i)=>$v+['position'=>$i+1])->all()]]) !!}</script>
@endpush
@section('content')
<div class="discovery-wrap metro-guide">
  <nav aria-label="パンくず"><a href="{{ route('spots.index') }}">施設を探す</a> / 都市ガイド</nav>
  <header class="metro-intro"><p class="metro-eyebrow">20 CITIES · OUTDOOR & WELLNESS</p><h1>街から広がる、<br>次の休日。</h1><p>泊まる、遊ぶ、お湯でひと息。<br>全国20の政令指定都市から、過ごし方を探せます。</p><p>40施設の詳しい利用案内を掲載。市内の施設と市外の近郊候補を分け、料金の条件と公式の出典を添えています。</p></header>
  <section class="metro-note mb-5" aria-labelledby="coverage"><h2 id="coverage">6ジャンルの掲載状況</h2><div class="metro-jumps">@foreach($counts as $category=>$count)<span>{{ \App\Support\Discovery::label($category) }} {{ $count }}施設</span>@endforeach</div><p class="small mb-0">全国の都市ガイド合計です。各都市はまず2施設から掲載しており、すべての都市で6ジャンルが揃っているわけではありません。ヒーリングには植物園・庭園での散策も含みます。</p></section>
  <h2>どの街から出かける？</h2>
  <div class="metro-grid city-grid">@foreach($cities as $slug=>$metadata)<article class="metro-card"><p class="metro-eyebrow">{{ $metadata['area'] }}</p><h3><a href="{{ route('cities.show',$slug) }}">{{ $metadata['label'] }}</a></h3><p>{{ $metadata['intro'] }}</p><p class="small">詳しい利用案内 {{ count($metadata['facilities']) }}施設 · 市内 {{ collect($metadata['facilities'])->where('scope','city')->count() }} / 近郊 {{ collect($metadata['facilities'])->where('scope','nearby')->count() }}</p><a href="{{ route('cities.show',$slug) }}">施設・料金を比較する →</a></article>@endforeach</div>
  <aside class="metro-note mt-5"><h2>訪問したら、体験記を。</h2><p>実際に払った金額、訪問した日時、混雑、休憩場所の使いやすさ。各施設ページから記録を共有できます。公式情報の利用案内と、訪問者の体験記は分けて掲載します。</p><a href="{{ route('journals.index') }}">体験記を見る →</a><p class="small mt-3">対象都市の出典：<a href="https://www.siteitosi.jp/about/designated.html" target="_blank" rel="noopener noreferrer">指定都市市長会・指定都市一覧</a>（2026年9月10日確認）</p></aside>
</div>
@endsection
