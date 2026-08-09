<!DOCTYPE html>
<html lang="ja">
<head>
  <meta name="google-site-verification" content="GKA7DdAYgnN8_LI3J1WrSaFwLRbZUfSknD3Ax1ty1DM" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="theme-color" content="#166534">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', config('app.name') . ' | みんなで探す・投稿するキャンプ場マップ')</title>
  <meta name="description" content="@yield('description', '全国のキャンプ場を地図から探せる投稿型マップです。空き状況・口コミをリアルタイムで確認でき、新しいキャンプ場は誰でも匿名で投稿できます。')">
  <link rel="canonical" href="{{ url()->current() }}">

  <meta property="og:site_name" content="{{ config('app.name') }}">
  <meta property="og:type" content="website">
  <meta property="og:title" content="@yield('title', config('app.name') . ' | みんなで探す・投稿するキャンプ場マップ')">
  <meta property="og:description" content="@yield('description', '全国のキャンプ場を地図から探せる投稿型マップです。空き状況・口コミをリアルタイムで確認でき、新しいキャンプ場は誰でも匿名で投稿できます。')">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:locale" content="ja_JP">

  <meta name="twitter:card" content="summary">
  <meta name="twitter:title" content="@yield('title', config('app.name') . ' | みんなで探す・投稿するキャンプ場マップ')">
  <meta name="twitter:description" content="@yield('description', '全国のキャンプ場を地図から探せる投稿型マップです。空き状況・口コミをリアルタイムで確認でき、新しいキャンプ場は誰でも匿名で投稿できます。')">

  <link rel="icon" href="/favicon.ico" sizes="any">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body { background-color: #f8f9fa; font-family: system-ui, -apple-system, sans-serif; }
    .btn { min-height: 44px; }
    .btn-line { background: #06c755; color: #fff; border: none; }
    .btn-line:hover { background: #05a848; color: #fff; }
  </style>
  @yield('styles')

  @stack('structured-data')

  @if(config('services.ga4.id'))
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.ga4.id') }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ config('services.ga4.id') }}');
  </script>
  @endif
</head>
<body>
  <nav class="navbar navbar-dark bg-dark p-2">
    <div class="container-fluid">
      <a href="{{ route('spots.index') }}" class="navbar-brand text-white text-decoration-none">⛺ {{ config('app.name') }}</a>
      <a href="{{ route('about') }}" class="text-white small text-decoration-none">サイトについて</a>
    </div>
  </nav>

  @yield('content')

  @if(config('services.valuecommerce.ikyu_sid') && config('services.valuecommerce.ikyu_pid'))
  <footer class="container my-4 py-3 border-top text-center">
    <a href="https://ck.jp.ap.valuecommerce.com/servlet/referral?sid={{ config('services.valuecommerce.ikyu_sid') }}&pid={{ config('services.valuecommerce.ikyu_pid') }}"
       target="_blank" rel="nofollow noopener noreferrer" class="text-decoration-none small text-muted">
      高級宿・温泉旅館の予約は「一休.com」で探す &raquo;
    </a>
    <img src="https://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid={{ config('services.valuecommerce.ikyu_sid') }}&pid={{ config('services.valuecommerce.ikyu_pid') }}"
         width="1" height="1" border="0" alt="" style="position:absolute;">
  </footer>
  @endif

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
</body>
</html>
