@extends('layouts.plain')
@section('title', $metadata['label'].'・'.$label.'の施設｜アウトドア・温浴・癒やし | '.config('app.name'))
@section('description', $metadata['label'].'・'.$label.'で過ごす休日。掲載施設の所在地・ジャンル・公式案内と体験記へのリンクを確認できます。')
@push('structured-data')
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'CollectionPage','name'=>$metadata['label'].'・'.$label.'の施設','url'=>route('wards.show',[$metro,$ward]),'mainEntity'=>['@type'=>'ItemList','itemListElement'=>$spots->values()->map(fn($spot,$i)=>['@type'=>'ListItem','position'=>$i+1,'name'=>$spot->name,'url'=>route('spots.show',$spot)])->all()]]) !!}</script>
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>[['@type'=>'ListItem','position'=>1,'name'=>'都市ガイド','item'=>route('cities.index')],['@type'=>'ListItem','position'=>2,'name'=>$metadata['label'].'の区','item'=>route('wards.index',$metro)],['@type'=>'ListItem','position'=>3,'name'=>$label,'item'=>route('wards.show',[$metro,$ward])]]]) !!}</script>
@endpush
@section('content')
<div class="discovery-wrap metro-guide">
  <nav aria-label="パンくず"><a href="{{ route('wards.national') }}">全国の区</a> / <a href="{{ route('wards.index',$metro) }}">{{ $metadata['label'] }}の区</a> / {{ $label }}</nav>
  <header class="metro-intro"><p class="metro-eyebrow">{{ $metadata['label'] }} · NEIGHBORHOOD</p><h1>{{ $label }}で、<br>次の休日を。</h1><p>{{ $metadata['label'] }}・{{ $label }}の掲載施設 {{ $spots->count() }}件。施設ごとの利用条件や公式情報の確認状況は詳細ページでご覧いただけます。</p></header>
  <nav class="metro-jumps" aria-label="掲載ジャンル">@foreach($categories as $category=>$info)@php($count=$spots->filter(fn($spot)=>($spot->category ?: 'campground')===$category)->count())@if($count)<a href="#genre-{{ $category }}">{{ $info['label'] }} {{ $count }}件</a>@else<span>{{ $info['label'] }} 0件</span>@endif @endforeach</nav>
  @forelse($spots->groupBy(fn($spot)=>$spot->category ?: 'campground') as $category=>$genreSpots)
  <section class="mb-5" aria-labelledby="genre-{{ $category }}"><h2 id="genre-{{ $category }}">{{ \App\Support\Discovery::label($category) }}（{{ $genreSpots->count() }}件）</h2><div class="metro-grid">@foreach($genreSpots as $spot)<article class="metro-card"><h3><a href="{{ route('spots.show',$spot) }}">{{ $spot->name }}</a></h3><p>{{ $spot->description }}</p><p><strong>所在地：</strong>{{ $spot->ward_address }}</p>@if($spot->source_checked_at)<p class="small">公式情報参照：{{ $spot->source_checked_at->format('Y-m-d') }}</p>@endif<a class="discovery-button" href="{{ route('spots.show',$spot) }}">施設情報・体験記を見る →</a></article>@endforeach</div></section>
  @empty
  <section class="metro-note"><h2>{{ $label }}の施設は、まだ掲載されていません。</h2><p>お気に入りの施設をご存じでしたら、所在地を添えて登録できます。ほかの区の掲載施設も探せます。</p><a href="{{ route('spots.create') }}">施設を登録する →</a></section>
  @endforelse
  <aside class="metro-note mt-5"><a href="{{ route('wards.index',$metro) }}">{{ $metadata['label'] }}のほかの区を探す →</a><p class="mt-3"><a href="{{ route('areas.show',$metadata['area']) }}">{{ $metadata['area'] }}全体の施設を見る →</a></p></aside>
</div>
@endsection
