@extends('layouts.plain')

@section('title', '都道府県からキャンプ場を探す | ' . config('app.name'))
@section('description', '全国' . $total . '件のキャンプ場・グランピング施設を都道府県別にまとめています。行き先の地域を選ぶと、空き状況の報告と口コミを確認できます。')

@push('structured-data')
<script type="application/ld+json">
{!! json_encode([
  '@@context' => 'https://schema.org',
  '@type' => 'CollectionPage',
  'name' => '都道府県からキャンプ場を探す',
  'url' => url('/areas'),
  'description' => '全国のキャンプ場・グランピング施設を都道府県別にまとめたページ。',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
  '@@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => config('app.name'), 'item' => url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => '都道府県から探す', 'item' => url('/areas')],
  ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')
<div class="container my-4">
  <div class="card shadow-sm">
    <div class="card-body p-4">
      <h1 class="h3 fw-bold mb-3">都道府県からキャンプ場を探す</h1>
      <p class="text-muted">
        全国{{ $total }}件のキャンプ場・グランピング施設を都道府県別にまとめています。
        行き先の地域を選ぶと、その地域の施設と、利用者から寄せられた空き状況の報告・口コミを確認できます。
      </p>

      <div class="row g-2 mt-3">
        @foreach($areas as $area)
          <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('areas.show', ['area' => $area->area]) }}" class="btn btn-outline-secondary w-100 text-start">
              {{ $area->area }}
              <span class="text-muted small">（{{ $area->spots_count }}件）</span>
            </a>
          </div>
        @endforeach
      </div>

      <div class="mt-4">
        <a href="{{ route('spots.index') }}" class="btn btn-secondary">地図から探す</a>
      </div>
    </div>
  </div>
</div>
@endsection
