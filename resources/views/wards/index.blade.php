@extends('layouts.plain')
@section('title', $metadata['label'].'を区から探す｜アウトドア・温浴・癒やし | '.config('app.name'))
@section('description', $metadata['label'].'の'.count($wards).'区からグランピング・ソロキャンプ・アクティビティ・岩盤浴・ヒーリング・スパを探せます。区ごとの掲載件数と施設情報、体験記へのリンクを掲載。')
@push('structured-data')
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'CollectionPage','name'=>$metadata['label'].'の区別施設ガイド','url'=>route('wards.index',$metro),'mainEntity'=>['@type'=>'ItemList','itemListElement'=>collect($wards)->map(fn($label,$slug)=>['@type'=>'ListItem','name'=>$label,'url'=>route('wards.show',[$metro,$slug])])->values()->map(fn($item,$i)=>$item+['position'=>$i+1])->all()]]) !!}</script>
@endpush
@section('content')
<div class="discovery-wrap metro-guide">
  <nav aria-label="パンくず"><a href="{{ route('cities.index') }}">都市ガイド</a> / {{ $metadata['label'] }}の区</nav>
  <header class="metro-intro"><p class="metro-eyebrow">NEIGHBORHOOD GUIDE</p><h1>{{ $metadata['label'] }}を、<br>区から探す。</h1><p>近くで遊ぶ、ひと息つく。{{ count($wards) }}区から、休日の候補を選べます。</p><p>区が分かる所在地を持つ施設を{{ $counts->sum() }}件掲載しています。件数は現在の登録状況で、地域にある全施設の数ではありません。</p></header>
  <div class="metro-grid city-grid">@foreach($wards as $slug=>$label)<article class="metro-card"><p class="metro-eyebrow">{{ $metadata['label'] }}</p><h2><a href="{{ route('wards.show',[$metro,$slug]) }}">{{ $label }}</a></h2><p>{{ $counts[$slug] }}施設 @if(!$counts[$slug])· 掲載施設を募集中@endif</p><a href="{{ route('wards.show',[$metro,$slug]) }}">{{ $label }}の施設を見る →</a></article>@endforeach</div>
  <aside class="metro-note mt-5"><h2>ほかの街も探す</h2><div class="metro-jumps">@foreach(\App\Support\WardGuide::METROS as $slug=>$info)@if($slug!==$metro)<a href="{{ route('wards.index',$slug) }}">{{ $info['label'] }}の区一覧</a>@endif @endforeach<a href="{{ route('areas.show',$metadata['area']) }}">{{ $metadata['area'] }}全体</a></div><p class="small">区一覧の出典：<a href="{{ $metadata['source'] }}" target="_blank" rel="noopener noreferrer">自治体の公式案内</a>（2026年9月10日確認）</p></aside>
</div>
@endsection
