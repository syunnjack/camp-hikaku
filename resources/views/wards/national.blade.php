@extends('layouts.plain')
@section('title', '全国194区から施設を探す｜東京23区・全20政令指定都市 | '.config('app.name'))
@section('description', '東京23区と全20政令指定都市の171行政区、計194区からアウトドア・温浴・癒やしの施設を探せます。都市別・区別の掲載件数と施設情報を確認できます。')
@push('structured-data')
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'CollectionPage','name'=>'全国の区別施設ガイド','url'=>route('wards.national'),'mainEntity'=>['@type'=>'ItemList','itemListElement'=>collect($metros)->map(fn($info,$metro)=>['@type'=>'ListItem','name'=>$info['label'],'url'=>route('wards.index',$metro)])->values()->map(fn($item,$i)=>$item+['position'=>$i+1])->all()]]) !!}</script>
@endpush
@section('content')
<div class="discovery-wrap metro-guide">
  <nav aria-label="パンくず"><a href="{{ route('cities.index') }}">都市ガイド</a> / 全国の区</nav>
  <header class="metro-intro"><p class="metro-eyebrow">194 WARDS · OUTDOOR & WELLNESS</p><h1>街の中の、<br>小さな休日を。</h1><p>東京23区と全20政令指定都市。全国194区から、近くの施設を探せます。</p><p>所在地から区が分かる施設を{{ $counts->sum() }}件掲載。各区の件数は現在の登録状況です。</p></header>
  <div class="metro-grid city-grid">@foreach($metros as $metro=>$info)<article class="metro-card"><p class="metro-eyebrow">{{ $info['area'] }}</p><h2><a href="{{ route('wards.index',$metro) }}">{{ $info['label'] }}</a></h2><p>{{ count(\App\Support\WardGuide::wards($metro)) }}区 · {{ $counts[$metro] }}施設</p><a href="{{ route('wards.index',$metro) }}">区を選んで探す →</a></article>@endforeach</div>
  <aside class="metro-note mt-5"><h2>掲載エリアについて</h2><p>浜松市は再編後の中央区・浜名区・天竜区の3区に対応しています。掲載施設がない区は0件と表示しています。区のある都市以外も、全国の都市ガイドから探せます。</p><a href="{{ route('cities.index') }}">県庁所在地・都市ガイドを見る →</a></aside>
</div>
@endsection
