@extends('layouts.plain')

@section('title', 'このサイトについて | ' . config('app.name'))
@section('description', config('app.name') . 'の運営方針、データの取り扱い、口コミ・LINE通知の仕組みについて説明しています。')

@section('content')
<div class="container my-4" style="max-width: 720px;">
  <h1 class="h4 fw-bold mb-4">このサイトについて</h1>

  <section class="mb-4">
    <h2 class="h6">サイトの目的</h2>
    <p class="text-muted small">
      「{{ config('app.name') }}」は、キャンプ場の場所を地図から探せる投稿型マップです。新しいキャンプ場は誰でもログイン不要・匿名で投稿でき、
      実際に利用した人が空き状況の報告や口コミ、いいねを行うことで情報が更新されていきます。
      予約サイトでは分からない「今の空き状況」が分かることが特徴です。
    </p>
  </section>

  <section class="mb-4">
    <h2 class="h6">空き状況について</h2>
    <p class="text-muted small">
      空き状況は、その場を訪れた利用者が「空いている」「やや混雑」「混雑・満員」のいずれかを匿名で報告した値を平均して表示しています。
      リアルタイムの正確な状況を保証するものではなく、あくまで参考情報としてご利用ください。
    </p>
  </section>

  <section class="mb-4">
    <h2 class="h6">LINE通知について</h2>
    <p class="text-muted small">
      各キャンプ場ページから「🔔 空き状況が変わったらLINEで通知を受け取る」を選ぶと、LINEログインのうえそのキャンプ場を通知対象として登録できます。
      登録したキャンプ場の空き状況（空いている/やや混雑/混雑・満員）が変化すると、LINE公式アカウントからお知らせします。
    </p>
  </section>

  <section class="mb-4">
    <h2 class="h6">口コミ・投稿について</h2>
    <p class="text-muted small">
      口コミや新規スポットの投稿は、どなたでもログイン不要で行えます。投稿内容は運営による事前確認を行わず即時反映されますが、
      不適切な投稿を発見した場合は内容を精査のうえ削除などの対応を行います。
    </p>
  </section>

  <a href="{{ route('spots.index') }}" class="d-block text-center text-muted mt-4">トップページに戻る</a>
</div>
@endsection
