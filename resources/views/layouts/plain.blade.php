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

  <title>@yield('title', config('app.name') . ' | アウトドア・癒やしの施設と体験記')</title>
  <meta name="description" content="@yield('description', 'アウトドアと癒やしの施設をジャンル・エリア・体験記から比較できます。訪問記録と利用者の混雑報告を共有するコミュニティです。')">
  <link rel="canonical" href="{{ request()->filled('page') ? url()->current().'?page='.(int)request('page') : url()->current() }}">

  <meta property="og:site_name" content="{{ config('app.name') }}">
  <meta property="og:type" content="website">
  <meta property="og:title" content="@yield('title', config('app.name') . ' | アウトドア・癒やしの施設と体験記')">
  <meta property="og:description" content="@yield('description', 'アウトドアと癒やしの施設をジャンル・エリア・体験記から比較できます。訪問記録と利用者の混雑報告を共有するコミュニティです。')">
  <meta property="og:url" content="{{ request()->filled('page') ? url()->current().'?page='.(int)request('page') : url()->current() }}">
  <meta property="og:locale" content="ja_JP">

  <meta name="twitter:card" content="summary">
  <meta name="twitter:title" content="@yield('title', config('app.name') . ' | アウトドア・癒やしの施設と体験記')">
  <meta name="twitter:description" content="@yield('description', 'アウトドアと癒やしの施設をジャンル・エリア・体験記から比較できます。訪問記録と利用者の混雑報告を共有するコミュニティです。')">

  <link rel="icon" href="/favicon.ico" sizes="any">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body { background-color: #f8f9fa; font-family: system-ui, -apple-system, sans-serif; }
    .btn { min-height: 44px; }
    .btn-line { background: #06c755; color: #fff; border: none; }
    .btn-line:hover { background: #05a848; color: #fff; }
  </style>
  @yield('styles')
  <link rel="stylesheet" href="{{ asset('discovery.css') }}">
  @if(request()->hasAny(['q','area','tag','sort','ids','verified']) || request()->routeIs('spots.compare','spots.create','spots.shortlist'))
  <meta name="robots" content="noindex,follow">
  @endif

  @stack('structured-data')
  <script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'WebSite','name'=>config('app.name'),'url'=>url('/'),'inLanguage'=>'ja']) !!}</script>

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
  <a class="skip-link" href="#main-content">本文へ移動</a>
  <header class="site-header"><div class="header-inner"><a href="{{ route('spots.index') }}" class="site-brand">{{ config('app.name') }}<small>OUTDOOR & WELLNESS</small></a><nav class="site-nav" aria-label="メインメニュー"><a href="/cities">県庁所在地・都市</a><a href="{{ route('spots.index') }}">施設を探す</a><a href="{{ route('guides.metropolitan') }}">首都圏ガイド</a><a href="{{ route('guides.kansai') }}">関西ガイド</a><a href="{{ route('areas.index') }}">エリア</a><a href="{{ route('journals.index') }}">体験記</a><a href="{{ route('spots.shortlist') }}" data-my-list>♡ 行きたい <span data-saved-count></span></a><a href="{{ route('spots.create') }}" class="discovery-button">＋ 施設を登録</a></nav></div></header>

  <main id="main-content">
  @yield('content')
  </main>
  <footer class="site-footer"><div class="discovery-wrap"><p><strong>{{ config('app.name') }}</strong><br>自然と休息を、みんなの体験から。</p><nav aria-label="サイト情報"><a href="{{ route('about') }}">サイトについて</a><a href="{{ route('guidelines') }}">投稿ガイドライン</a><a href="{{ route('areas.index') }}">エリア一覧</a></nav><p class="photo-credit">風景写真：<a href="https://commons.wikimedia.org/wiki/File:Mount_Fuji_from_Lake_Motosu_20241026.jpg">Supanut Arunoprayote / Wikimedia Commons</a>（<a href="https://creativecommons.org/licenses/by/4.0/">CC BY 4.0</a>・トリミング）。施設の写真ではありません。</p></div></footer>

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
<p class="save-status" role="status" id="save-status"></p><script src="{{ asset('discovery-list.js') }}" defer></script>
</body>
</html>
