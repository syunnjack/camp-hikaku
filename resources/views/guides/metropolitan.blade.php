@extends('layouts.plain')
@section('title', '首都圏で過ごす休日｜6ジャンルの料金・予約・利用条件 | '.config('app.name'))
@section('description', '東京・神奈川・千葉・埼玉のグランピング、ソロキャンプ、アクティビティ、岩盤浴、森林セラピー、スパを公式情報で比較。料金の条件、追加費用、予約、アクセスと出典を掲載。')
@push('structured-data')
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@context'=>'https://schema.org','@type'=>'CollectionPage','name'=>'首都圏で過ごす休日','url'=>route('guides.metropolitan'),'inLanguage'=>'ja','dateModified'=>'2026-09-09','mainEntity'=>['@type'=>'ItemList','itemListElement'=>$spots->values()->map(fn($spot,$i)=>['@type'=>'ListItem','position'=>$i+1,'url'=>route('spots.show',$spot),'name'=>$spot->name])->all()]]) !!}</script>
@endpush
@section('content')
<div class="discovery-wrap metro-guide">
  <nav aria-label="パンくず"><a href="{{ route('spots.index') }}">施設を探す</a> / 首都圏ガイド</nav>
  <header class="metro-intro">
    <p class="metro-eyebrow">TOKYO · KANAGAWA · CHIBA · SAITAMA</p>
    <h1>今度の休日、<br>どんなふうに過ごす？</h1>
    <p>森に泊まる。体を動かす。お湯でひと息。<br>首都圏の6ジャンルを、料金と利用条件から選べるガイドです。</p>
    <p class="small">初回掲載：各ジャンル1施設・計6施設。公式情報の調査日：2026年9月8日。現地訪問による評価・ランキングではありません。</p>
  </header>
  <nav class="metro-jumps" aria-label="ジャンルを選ぶ">
    @foreach($guides as $key=>$guide)<a href="#{{ $key }}">{{ \App\Support\Discovery::label($guide['category']) }}</a>@endforeach
  </nav>
  <section aria-labelledby="price-heading" class="mb-5">
    <h2 id="price-heading">まずは、料金の条件を見比べる</h2>
    <p>宿泊・時間制の体験・日帰り入館では含まれるものが違います。金額と利用条件を一緒に確認してください。</p>
    <div class="metro-table-wrap" tabindex="0" role="region" aria-label="6施設の料金比較表（横にスクロールできます）"><table class="table metro-table"><thead><tr><th scope="col">施設・ジャンル</th><th scope="col">料金の目安</th><th scope="col">対象・追加費用</th></tr></thead><tbody>
    @foreach($guides as $key=>$guide)<tr><th scope="row"><a href="#{{ $key }}">{{ $guide['name'] }}</a><small class="d-block">{{ \App\Support\Discovery::label($guide['category']) }} · {{ $guide['area'] }}</small></th><td>{{ $guide['price'] }}</td><td>{{ $guide['price_condition'] }}</td></tr>@endforeach
    </tbody></table></div>
  </section>
  <div class="metro-grid">
  @foreach($guides as $key=>$guide)
    <article class="metro-card" id="{{ $key }}">
      <p class="metro-eyebrow">{{ \App\Support\Discovery::label($guide['category']) }} / {{ $guide['area'] }}</p>
      <h2>{{ $guide['name'] }}</h2><p>{{ $guide['summary'] }}</p>
      <p class="metro-price">{{ $guide['price'] }}</p><p class="small">{{ $guide['price_condition'] }}</p>
      <p><strong>所在地・集合先：</strong>{{ $guide['address'] }}</p>
      @if($spots->has($key))
        <a class="discovery-button" href="{{ route('spots.show',$spots[$key]) }}#official-guide">利用条件・出典・体験記を見る →</a>
      @else
        <a href="{{ $guide['official_url'] }}" target="_blank" rel="noopener noreferrer">公式の利用案内を見る ↗</a>
      @endif
      <p class="small mt-3">出典：@foreach($guide['sources'] as $source)<a href="{{ $source['url'] }}" target="_blank" rel="noopener noreferrer">{{ $source['label'] }}</a>{{ $loop->last ? '' : ' / ' }}@endforeach</p>
    </article>
  @endforeach
  </div>
  <aside class="metro-note"><h2>行った人にしか分からないことも。</h2><p>音、混雑、休憩席の使いやすさ、実際に払った金額。訪問した施設のページから、日時を添えて体験記を共有できます。</p><a href="{{ route('journals.index') }}">みんなの体験記を見る →</a></aside>
</div>
@endsection
