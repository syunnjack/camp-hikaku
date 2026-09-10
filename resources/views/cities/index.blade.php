@extends('layouts.plain')
@section('title', '全国47都道府県の県庁所在地から探す｜アウトドア・温浴・癒やしの施設 | '.config('app.name'))
@section('description', '全国47都道府県の県庁所在地と20政令指定都市、重複を除く52エリアの施設ガイド。グランピング・ソロキャンプ・アクティビティ・岩盤浴・ヒーリング・スパを探せます。市内と近郊を区別して掲載しています。')
@push('structured-data')
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'CollectionPage','name'=>'全国の県庁所在地・政令指定都市ガイド','url'=>route('cities.index'),'inLanguage'=>'ja','mainEntity'=>['@type'=>'ItemList','itemListElement'=>collect($cities)->map(fn($v,$k)=>['@type'=>'ListItem','name'=>$v['label'],'url'=>route('cities.show',$k)])->values()->map(fn($v,$i)=>$v+['position'=>$i+1])->all()]]) !!}</script>
@endpush
@section('content')
<div class="discovery-wrap metro-guide">
  <nav aria-label="パンくず"><a href="{{ route('spots.index') }}">施設を探す</a> / 都市ガイド</nav>
  <header class="metro-intro"><p class="metro-eyebrow">52 AREAS · OUTDOOR & WELLNESS</p><h1>街から広がる、<br>次の休日。</h1><p>泊まる、遊ぶ、お湯でひと息。<br>全国47都道府県の県庁所在地から、過ごし方を探せます。</p><p>県庁所在地と政令指定都市を合わせた52エリアに対応。東京都は都庁所在地の新宿区を掲載しています。市区内と近郊を分け、公式の出典を添えています。</p></header>
  <section class="metro-note mb-5" aria-labelledby="coverage"><h2 id="coverage">6ジャンルの掲載状況</h2><div class="metro-jumps">@foreach($counts as $category=>$count)<span>{{ \App\Support\Discovery::label($category) }} {{ $count }}施設</span>@endforeach</div><p class="small mb-0">この都市ガイドに掲載している施設の合計です。すべての都市で6ジャンルが揃っているわけではありません。ヒーリングには植物園・庭園での散策も含みます。</p></section>
  <p>都市ガイドの掲載施設 <strong>{{ array_sum($counts) }}施設</strong>。各カードに市区内と近郊の件数を表示しています。</p>
  <section class="metro-note mb-5"><h2>全国の政令指定都市・東京23区を、区から探す。</h2><div class="metro-jumps">@foreach(\App\Support\WardGuide::METROS as $slug=>$info)<a href="{{ route('wards.index',$slug) }}">{{ $info['label'] }}・{{ count(\App\Support\WardGuide::wards($slug)) }}区 →</a>@endforeach</div></section>
  <h2>どの街から出かける？</h2>
  <div class="metro-grid city-grid">@foreach($cities as $slug=>$metadata)<article class="metro-card"><p class="metro-eyebrow">{{ $metadata['area'] }}</p><h3><a href="{{ route('cities.show',$slug) }}">{{ $metadata['label'] }}</a></h3><p>{{ $metadata['intro'] }}</p><p class="small">市区内 {{ $cityCounts[$slug]['city'] }}施設 · 近郊 {{ $cityCounts[$slug]['nearby'] }}施設</p><a href="{{ route('cities.show',$slug) }}">施設・料金を比較する →</a></article>@endforeach</div>
  <aside class="metro-note mt-5"><h2>訪問したら、体験記を。</h2><p>実際に払った金額、訪問した日時、混雑、休憩場所の使いやすさ。各施設ページから記録を共有できます。公式情報の利用案内と、訪問者の体験記は分けて掲載します。</p><a href="{{ route('journals.index') }}">体験記を見る →</a><p class="small mt-3">対象エリアの出典：<a href="https://www.gsi.go.jp/CHIRIKYOUIKU/todofuken.html" target="_blank" rel="noopener noreferrer">国土地理院・都道府県の位置</a> / <a href="https://www.siteitosi.jp/about/designated.html" target="_blank" rel="noopener noreferrer">指定都市市長会・指定都市一覧</a>（2026年9月10日確認）</p></aside>
</div>
@endsection
