@extends('layouts.plain')
@section('title', '行きたい場所 | '.config('app.name'))
@section('description', '気になる場所を集めて、次の休日の行き先を比較できます。')
@section('content')
<div class="discovery-wrap shortlist-page" data-shortlist-page>
  <p class="eyebrow">YOUR NEXT DAY OFF</p>
  <h1>{{ request()->has('ids') ? '行きたい場所リスト' : 'あなたの、行きたい場所。' }}</h1>
  <p>森で遊んで、温泉に寄る。気になる場所を集めて、自分だけの休日を考えよう。</p>
  <p class="small">♡で保存した場所は、このブラウザーに最大50件保存します。共有リンクを開いた場合は、リンクに含まれる施設を表示します。</p>
  <div class="detail-actions"><a class="discovery-button" href="{{ route('spots.index') }}">＋ 施設を探す</a><button type="button" class="quiet-button" data-share-list>このリストのリンクをコピー</button><a href="{{ route('spots.shortlist') }}">自分の保存リストを開く</a></div>
  <form action="{{ route('spots.compare') }}" method="GET" id="compare-form">
    <div class="spot-grid">@forelse($spots as $spot)
      @include('spots.facility-card')
    @empty
      <div class="discovery-empty"><h2>気になる場所を、ひとつずつ。</h2><p>施設の「♡ 行きたい」を押すと、ここから見返せます。</p><a href="{{ route('spots.index') }}">行き先を探す ↗</a></div>
    @endforelse</div>
    <div class="compare-bar"><span>ジャンルをまたいで2〜3件を比較</span><button class="discovery-button">選んだ施設を比較する ↗</button><span id="compare-feedback" role="status"></span><button type="button" class="quiet-button" data-clear-comparison>選択を解除</button></div>
  </form>
  <noscript><p>このブラウザーへの保存機能にはJavaScriptが必要です。施設の閲覧とチェックボックスによる比較は、そのまま利用できます。</p></noscript>
</div>
@endsection
