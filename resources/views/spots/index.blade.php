@extends('layouts.plain')

@section('title', config('app.name') . ' | 空き状況・口コミでキャンプ場を探す')
@section('description', '全国のキャンプ場を地図から検索できる投稿型マップです。空き状況・口コミをリアルタイムで確認でき、新しいキャンプ場は誰でも匿名で投稿できます。')

@push('structured-data')
<script type="application/ld+json">
{!! json_encode([
  '@@context' => 'https://schema.org',
  '@type' => 'WebSite',
  'name' => config('app.name'),
  'url' => url('/'),
  'description' => '全国のキャンプ場を地図から検索できる投稿型マップ。空き状況・口コミを確認できる。',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
  '@@context' => 'https://schema.org',
  '@type' => 'ItemList',
  'itemListElement' => $spots->take(50)->values()->map(function ($spot, $i) {
      return [
          '@type' => 'ListItem',
          'position' => $i + 1,
          'url' => url("/spots/{$spot->id}"),
          'name' => $spot->name,
      ];
  })->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')
<div class="container my-4">
  <div class="text-center mb-4">
    <h1 class="fw-bold h3">⛺ キャンプ場マップ</h1>
    <p class="text-muted">空いてるキャンプ場を見つける・誰でも投稿できる地図</p>
    <a href="{{ route('spots.create') }}" class="btn btn-danger shadow-sm px-4">➕ キャンプ場を投稿</a>
  </div>

  <form method="GET" action="{{ route('spots.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
      <label class="form-label">エリア</label>
      <select name="area" class="form-select">
        <option value="">すべて</option>
        @foreach($areas as $area)
          <option value="{{ $area }}" @selected(request('area') == $area)>{{ $area }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">おすすめの人</label>
      <select name="tag" class="form-select">
        <option value="">すべて</option>
        <option value="family" @selected(request('tag') == 'family')>ファミリー</option>
        <option value="couple" @selected(request('tag') == 'couple')>カップル</option>
        <option value="friends" @selected(request('tag') == 'friends')>お友達</option>
        <option value="solo" @selected(request('tag') == 'solo')>ソロキャンプ</option>
      </select>
    </div>
    <div class="col-md-2 align-self-end">
      <button type="submit" class="btn btn-outline-primary w-100">絞り込む</button>
    </div>
  </form>

  @php
    $tagLabels = ['family' => 'ファミリー', 'couple' => 'カップル', 'friends' => 'お友達', 'solo' => 'ソロキャンプ'];
    $categoryLabels = ['campground' => 'キャンプ場', 'glamping' => 'グランピング'];
  @endphp

  <div class="row">
    @forelse($spots as $spot)
      <div class="col-md-6 col-lg-4 mb-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h2 class="h6 card-title">
              <a href="{{ route('spots.show', $spot) }}" class="text-decoration-none">{{ $spot->name }}</a>
              <span class="badge bg-secondary float-end">{{ $spot->area ?? '未設定' }}</span>
            </h2>
            @if($spot->category && isset($categoryLabels[$spot->category]))
              <span class="badge bg-info text-dark mb-1">{{ $categoryLabels[$spot->category] }}</span>
            @endif
            <p class="card-text text-muted small">{{ $spot->description }}</p>
            @if(!empty($spot->tags))
              <div class="mb-2">
                @foreach($spot->tags as $tag)
                  <span class="badge bg-light text-dark border">{{ $tagLabels[$tag] ?? $tag }}</span>
                @endforeach
              </div>
            @endif
            <small class="text-muted">空き状況：{{ \App\Helpers\CongestionHelper::getText($spot->average_congestion) }}</small>
          </div>
        </div>
      </div>
    @empty
      <p class="text-muted">該当するキャンプ場がありません。</p>
    @endforelse
  </div>
</div>
@endsection
