@extends('layouts.plain')

@section('title', $area . 'のキャンプ場・グランピング' . $spots->count() . '件 | ' . config('app.name'))
@section('description', $area . 'のキャンプ場・グランピング施設を' . $spots->count() . '件掲載。空き状況の報告と口コミを確認できます。新しい施設は誰でも投稿できます。')

@push('structured-data')
<script type="application/ld+json">
{!! json_encode([
  '@@context' => 'https://schema.org',
  '@type' => 'CollectionPage',
  'name' => $area . 'のキャンプ場・グランピング',
  'url' => url('/areas/' . rawurlencode($area)),
  'description' => $area . 'のキャンプ場・グランピング施設の一覧。',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
  '@@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => config('app.name'), 'item' => url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => '都道府県から探す', 'item' => url('/areas')],
      ['@type' => 'ListItem', 'position' => 3, 'name' => $area, 'item' => url('/areas/' . rawurlencode($area))],
  ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')
@php
  $tagLabels = ['family' => 'ファミリー', 'couple' => 'カップル', 'friends' => 'お友達', 'solo' => 'ソロキャンプ'];
  $categoryLabels = ['campground' => 'キャンプ場', 'glamping' => 'グランピング'];
  $providerLabels = ['rakuten' => '楽天トラベルで予約', 'ikyu' => '一休.comで見る'];
  $glampingCount = $spots->where('category', 'glamping')->count();
  $withBooking = $spots->whereNotNull('booking_url')->count();
@endphp
<div class="container my-4">
  <div class="card shadow-sm mb-3">
    <div class="card-body p-4">
      <h1 class="h3 fw-bold mb-3">{{ $area }}のキャンプ場・グランピング</h1>
      <p class="text-muted mb-2">
        {{ $area }}の施設を{{ $spots->count() }}件掲載しています。
        @if($glampingCount > 0)
          このうち{{ $glampingCount }}件はグランピング施設です。
        @endif
        空き状況は利用者からの報告で更新されます。
      </p>
      <p class="text-muted small mb-3">
        空き状況と口コミは利用者の投稿によるもので、施設の公式発表ではありません。
        出かける前に、各施設の公式サイトや予約サイトで最新の情報をご確認ください。
      </p>
      @if($withBooking > 0)
        <p class="text-muted small mb-3">このページには広告（予約サイトへのアフィリエイトリンク）が含まれます。</p>
      @endif
      <a href="{{ route('areas.index') }}" class="btn btn-outline-secondary btn-sm">ほかの都道府県を見る</a>
      <a href="{{ route('spots.index') }}" class="btn btn-outline-secondary btn-sm">地図から探す</a>
    </div>
  </div>

  <div class="row g-3">
    @foreach($spots as $spot)
      <div class="col-12 col-md-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h2 class="h6 fw-bold mb-1">
              <a href="{{ route('spots.show', $spot) }}" class="text-decoration-none">{{ $spot->name }}</a>
            </h2>
            <div class="mb-2">
              <span class="badge bg-light text-dark border">{{ $categoryLabels[$spot->category] ?? 'キャンプ場' }}</span>
              @foreach(($spot->tags ?? []) as $tag)
                <span class="badge bg-light text-dark border">{{ $tagLabels[$tag] ?? $tag }}</span>
              @endforeach
            </div>
            @if($spot->description)
              <p class="small text-muted mb-2">{{ \Illuminate\Support\Str::limit($spot->description, 90) }}</p>
            @endif
            <small class="text-muted d-block mb-1">空き状況：{{ \App\Helpers\CongestionHelper::getText($spot->average_congestion) }}</small>
            @if($spot->booking_url)
              <span class="badge bg-secondary-subtle text-secondary-emphasis border">広告</span>
              <a href="{{ $spot->booking_url }}" target="_blank" rel="nofollow noopener noreferrer sponsored" class="small">
                {{ $providerLabels[$spot->booking_provider] ?? '予約サイトで見る' }} &raquo;
              </a>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>

  @if($otherAreas->isNotEmpty())
    <div class="card shadow-sm mt-4">
      <div class="card-body p-4">
        <h2 class="h5 mb-3">ほかの都道府県で探す</h2>
        <div class="d-flex flex-wrap gap-2">
          @foreach($otherAreas as $other)
            <a href="{{ route('areas.show', ['area' => $other->area]) }}" class="btn btn-outline-secondary btn-sm">
              {{ $other->area }}<span class="text-muted small">（{{ $other->spots_count }}）</span>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  @endif
</div>
@endsection
