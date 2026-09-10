@extends('layouts.plain')

@section('title', $spot->name . ($guide ? ' の料金・予約・利用条件・体験記 | ' : ' の混雑の参考情報・口コミ | ') . config('app.name'))
@section('description', $guide ? $guide['summary'].'料金条件・アクセス・公式出典・利用者の体験記を確認できます。' : $spot->name . '（' . ($spot->area ?? 'キャンプ場') . '）の場所・混雑の参考情報・利用者の口コミを確認できます。')

@push('structured-data')
@if($guide)
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'FAQPage','url'=>route('spots.show',$spot).'#official-guide','dateModified'=>$guide['checked_at'],'mainEntity'=>array_map(fn($item)=>['@type'=>'Question','name'=>$item[0],'acceptedAnswer'=>['@type'=>'Answer','text'=>$item[1]]],$guide['questions'])]) !!}</script>
@endif
<script type="application/ld+json">{!! \App\Support\Discovery::json(['@'.'context'=>'https://schema.org','@type'=>'WebPage','name'=>$spot->name,'url'=>route('spots.show',$spot),'dateModified'=>$spot->updated_at->toAtomString(),'inLanguage'=>'ja','mainEntity'=>['@type'=>'Place','name'=>$spot->name,'url'=>route('spots.show',$spot)]]) !!}</script>
<script type="application/ld+json">
{!! json_encode([
  '@'.'context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => config('app.name'), 'item' => url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => $spot->name, 'item' => url("/spots/{$spot->id}")],
  ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
<script type="application/ld+json">
{!! json_encode(array_filter([
  '@'.'context' => 'https://schema.org',
  '@type' => in_array($spot->category, ['campground','glamping','solo',null]) ? 'Campground' : ($spot->category === 'spa' ? 'DaySpa' : 'Place'),
  'name' => $spot->name,
  'description' => $spot->description,
  'geo' => ($spot->location_note || $spot->lat === null || $spot->lng === null) ? null : [
      '@type' => 'GeoCoordinates',
      'latitude' => $spot->lat,
      'longitude' => $spot->lng,
  ],
  'address' => $spot->address ?: $spot->area,
]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@section('content')
<div class="container my-4">
  <div class="card shadow-sm">
    <div class="card-body p-4">
      <h1 class="h3 fw-bold mb-3">{{ $spot->name }}</h1>
      <nav aria-label="パンくず"><a href="{{ route('spots.index') }}">施設を探す</a> / <a href="{{ route('categories.show',$spot->category ?: 'campground') }}">{{ \App\Support\Discovery::label($spot->category) }}</a> / {{ $spot->name }}</nav>
      <dl class="detail-facts"><div><dt>ジャンル</dt><dd>{{ \App\Support\Discovery::label($spot->category) }}</dd></div><div><dt>公開中の体験記</dt><dd>{{ $spot->reviews->count() }}件 @if($spot->reviews->count()) · ★ {{ number_format($spot->reviews->avg('rating'),1) }} / 5 @endif</dd></div><div><dt>ページ更新日（投稿などを含む）</dt><dd><time datetime="{{ $spot->updated_at->toAtomString() }}">{{ $spot->updated_at->format('Y年m月d日') }}</time></dd></div><div><dt>公式情報の参照先</dt><dd>@if($spot->official_url)<a href="{{ $spot->official_url }}" rel="ugc nofollow noopener noreferrer" target="_blank">公式サイト ↗</a><small class="d-block">@if($spot->source_checked_at)公式情報参照：{{ $spot->source_checked_at->format('Y年m月d日') }}@else 利用者登録・運営未確認 @endif</small>@else 未登録 @endif</dd></div></dl>
      @if($spot->address)<p><strong>所在地：</strong>{{ $spot->address }}</p>@endif
      @if($spot->source_urls)<details class="mb-3"><summary>施設情報の出典・確認日</summary><p class="small">{{ $spot->source_checked_at?->format('Y年m月d日') }}に公式・認定団体のページで名称・所在地・紹介内容を確認しました。営業日や料金は変更されるため、来場前に公式情報をご確認ください。</p><ul>@foreach($spot->source_urls as $sourceUrl)<li><a href="{{ $sourceUrl }}" target="_blank" rel="noopener noreferrer">{{ $sourceUrl }}</a></li>@endforeach</ul></details>@endif
      @php
        $catalogRecord = \App\Support\CapitalFacilities::forSpot($spot);
      @endphp
      @if($catalogRecord && !$spot->source_checked_at)
      <section class="metro-note mb-3" aria-labelledby="catalog-official"><h2 id="catalog-official">公式情報で確認した利用案内</h2><p>{{ $catalogRecord['description'] }}</p><p><strong>所在地：</strong>{{ $catalogRecord['address'] }}</p><p class="small">確認日：{{ $catalogRecord['checked_at'] }}。利用者が登録した紹介とは別に、以下の出典で確認しています。</p><ul>@foreach($catalogRecord['source_urls'] as $sourceUrl)<li><a href="{{ $sourceUrl }}" target="_blank" rel="noopener noreferrer">{{ $sourceUrl }}</a></li>@endforeach</ul><a href="{{ route('cities.show',$catalogRecord['city']) }}">この都市の施設を見る →</a></section>
      @endif
      @if($spot->location_note)<p class="small text-muted">{{ $spot->location_note }}</p>@endif
      <div class="detail-actions"><button type="button" class="quiet-button" data-save-spot="{{ $spot->id }}" aria-pressed="false">♡ 行きたい</button><a href="{{ route('spots.shortlist') }}">保存した場所を見る ↗</a></div><p>@if($spot->lat !== null && $spot->lng !== null)<a href="https://www.openstreetmap.org/?mlat={{ $spot->lat }}&mlon={{ $spot->lng }}#map=14/{{ $spot->lat }}/{{ $spot->lng }}" target="_blank" rel="noopener noreferrer">地図で場所を確認 ↗</a>@elseif($spot->official_url)<a href="{{ $spot->official_url }}" target="_blank" rel="noopener noreferrer">公式案内でアクセスを確認 ↗</a>@endif　<a href="#write-review">体験記を書く ↓</a></p>
      @php
        $tagLabels = ['family' => 'ファミリー', 'couple' => 'カップル', 'friends' => 'お友達', 'solo' => 'ソロキャンプ'];
        $categoryLabels = array_map(fn ($item) => $item['label'], \App\Support\Discovery::CATEGORIES);
      @endphp
      @if($spot->category && isset($categoryLabels[$spot->category]))
        <span class="badge bg-info text-dark mb-2">{{ $categoryLabels[$spot->category] }}</span>
      @endif
      <p class="text-muted mb-2">{{ $spot->description }}</p>
      @if($spot->area)
        <p class="text-secondary small mb-2">
          エリア:
          <a href="{{ route('areas.show', ['area' => $spot->area]) }}">{{ $spot->area }}の施設一覧</a>
        </p>
      @endif
      @if(!empty($spot->tags))
        <div class="mb-3">
          @foreach($spot->tags as $tag)
            <span class="badge bg-light text-dark border">{{ $tagLabels[$tag] ?? $tag }}</span>
          @endforeach
        </div>
      @endif

      @if($guide) @include('spots.official-guide') @endif

      @if($spot->booking_url)
        @php
          $providerLabels = ['rakuten' => '楽天トラベルで予約', 'ikyu' => '一休.comで詳細を見る'];
        @endphp
        {{-- 景品表示法の規定（2023年10月開始のいわゆるステマ規制）により、
             広告であることが分かる表示が必要。予約リンクはアフィリエイトのため明示する。 --}}
        <div class="mb-3">
          <span class="badge bg-secondary-subtle text-secondary-emphasis border me-1">広告</span>
          <a href="{{ $spot->booking_url }}" target="_blank" rel="nofollow noopener noreferrer sponsored" class="btn btn-outline-danger btn-sm">
            {{ $providerLabels[$spot->booking_provider] ?? '予約サイトで見る' }}
          </a>
          <p class="text-muted small mt-2 mb-0">予約サイトへのリンクは広告です。予約が成立すると当サイトが紹介料を受け取ることがあります。</p>
        </div>
      @endif

      <div class="mb-3">
        <a href="{{ route('spots.index') }}" class="btn btn-secondary">トップページに戻る</a>
        <a href="{{ route('areas.index') }}" class="btn btn-outline-secondary">都道府県から探す</a>
      </div>

      <h2 class="h5 mb-2">
        過去の報告による混雑の参考情報: <span id="currentAverageCongestion" class="text-primary fw-bold">
          {{ \App\Helpers\CongestionHelper::getText($spot->average_congestion) }}
        </span>
      </h2>

      <h3 class="h6 mt-4 mb-2">混雑の参考情報を報告する</h3>
      <div id="congestionButtons" data-spot-id="{{ $spot->id }}" class="d-flex gap-2 mb-4 flex-wrap">
        <button data-level="empty" class="btn btn-success">空いている</button>
        <button data-level="slightly_crowded" class="btn btn-warning">やや混雑</button>
        <button data-level="crowded" class="btn btn-danger">混雑・満員</button>
      </div>
      <p id="congestionMessage" class="text-success small"></p>

      @if (session('success'))
        <div class="alert alert-success py-2 small">{{ session('success') }}</div>
      @endif
      @if ($errors->any())
        <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
      @endif

      @php
        $isFavorited = session('line_user_local_id')
            ? \App\Models\Favorite::where('line_user_id', session('line_user_local_id'))->where('spot_id', $spot->id)->exists()
            : false;
      @endphp
      <form method="POST" action="{{ route('spots.favorite.toggle', $spot) }}" class="mb-4">
        @csrf
        @if ($isFavorited)
          <button type="submit" class="btn btn-outline-secondary">🔕 通知をやめる</button>
        @else
          {{-- LINEの認証情報が未設定のうちは、押すとLINE側でエラーになるので出さない --}}
          @if (config('services.line.login_channel_id'))
          <button type="submit" class="btn btn-line">🔔 混雑の参考情報が変わったらLINEで通知を受け取る</button>
          @else
            <button type="button" class="btn btn-secondary" disabled>🔔 混雑の参考情報が変わったらLINEで通知を受け取る（準備中）</button>
          @endif
        @endif
      </form>

      <div class="d-flex align-items-center mt-4 mb-4">
        <button id="likeButton" data-spot-id="{{ $spot->id }}" class="btn btn-primary me-2">いいね！</button>
        <span id="likesCount" class="h4 fw-bold mb-0">{{ $spot->likes_count }}</span> <span class="text-muted ms-1">件のいいね！</span>
      </div>

      <h2 id="write-review" class="h5 mt-4 mb-2">体験記を書く</h2>
      @if($guide)<p>{{ $guide['visit_prompt'] }}</p>@endif
      <p class="small">実際に訪問した感想を共有してください。<a href="{{ route('guidelines') }}">投稿ガイドライン</a></p>
      <form action="{{ route('spots.reviews.store', $spot) }}" method="POST" class="bg-light p-3 rounded shadow-sm">
        @csrf
        <div class="row g-3 mb-3"><div class="col-md-4"><label for="visited_on" class="form-label">訪問日（任意）</label><input id="visited_on" name="visited_on" type="date" max="{{ now()->format('Y-m-d') }}" value="{{ old('visited_on') }}" class="form-control"></div><div class="col-md-4"><label for="party" class="form-label">誰と（任意）</label><select id="party" name="party" class="form-select"><option value="">選択しない</option>@foreach(\App\Support\Discovery::TAGS as $key=>$label)<option value="{{ $key }}" @selected(old('party')===$key)>{{ $label }}</option>@endforeach</select></div><div class="col-md-4"><label for="cost" class="form-label">一人の支出・円（任意）</label><input type="number" id="cost" name="cost" min="0" max="1000000" value="{{ old('cost') }}" class="form-control"></div></div>
        <div style="position:absolute; left:-9999px;" aria-hidden="true">
          <label>ウェブサイト<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        </div>
        <div class="mb-2">
          <label for="nickname" class="form-label small">ニックネーム（任意）</label>
          <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}" class="form-control form-control-sm" maxlength="30">
        </div>
        <div class="mb-2">
          <label for="rating" class="form-label small">評価</label>
          <select id="rating" name="rating" class="form-select form-select-sm" required>
            <option value="">選択してください</option>
            <option value="5" @selected(old('rating') == 5)>★★★★★</option>
            <option value="4" @selected(old('rating') == 4)>★★★★☆</option>
            <option value="3" @selected(old('rating') == 3)>★★★☆☆</option>
            <option value="2" @selected(old('rating') == 2)>★★☆☆☆</option>
            <option value="1" @selected(old('rating') == 1)>★☆☆☆☆</option>
          </select>
        </div>
        <div class="mb-2">
          <label for="comment" class="form-label small">口コミ</label>
          <textarea id="comment" name="comment" class="form-control form-control-sm" rows="3" minlength="5" maxlength="1000" required>{{ old('comment') }}</textarea>
        </div>
        <button type="submit" class="btn btn-dark">投稿する</button>
      </form>

      <h3 class="h6 mt-5 mb-3">口コミ</h3>
      <div id="reviewList">
        @forelse($spot->reviews as $review)
          <div class="card mb-3 bg-light" id="review-{{ $review->id }}">
            <div class="card-body">
              <div>{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }} <strong>{{ $review->nickname }}</strong></div>
              <p class="mb-1 review-text">{{ $review->comment }}</p>
              <p class="small">{{ $review->visited_on ? $review->visited_on->format('Y/m/d').' 訪問' : '訪問日未記入' }} · {{ \App\Support\Discovery::TAGS[$review->party] ?? '同行者未記入' }} @if($review->cost !== null) · 一人 {{ number_format($review->cost) }}円（訪問時の支出） @endif</p>
              <small class="text-muted">投稿日: {{ $review->created_at->format('Y/m/d H:i') }}</small>
              <details class="mt-2"><summary class="small">この投稿を通報</summary><form action="{{ route('reviews.report',$review) }}" method="POST" class="mt-2">@csrf<label for="report-{{ $review->id }}">理由</label><select id="report-{{ $review->id }}" name="reason" required><option value="spam">宣伝・スパム</option><option value="personal">個人情報</option><option value="abuse">誹謗中傷</option><option value="inaccurate">事実と異なる</option></select><button class="quiet-button">通報を送信</button></form></details>
            </div>
          </div>
        @empty
          <p class="text-muted">まだ口コミはありません。</p>
        @endforelse
      </div>

      {{-- 個別ページ同士がつながっておらず、読んだあとに行く先が無かった。
           同じエリアの施設を並べて、次のページへ進めるようにする。 --}}
      @if(isset($nearbySpots) && $nearbySpots->isNotEmpty())
        <div class="mt-4 pt-3 border-top">
          <h2 class="h5 mb-3">{{ $spot->area }}のほかの施設</h2>
          <div class="d-flex flex-wrap gap-2">
            @foreach($nearbySpots as $nearby)
              <a href="{{ route('spots.show', $nearby) }}" class="btn btn-outline-secondary btn-sm">{{ $nearby->name }}</a>
            @endforeach
          </div>
          <div class="mt-3">
            <a href="{{ route('areas.show', ['area' => $spot->area]) }}">{{ $spot->area }}の施設をまとめて見る &raquo;</a>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function getCongestionText(avg) {
    if (avg === null || isNaN(avg)) return '報告なし';
    if (avg >= 2.5) return '混雑';
    if (avg >= 1.5) return 'やや混雑';
    return '空いている';
  }

  document.addEventListener('DOMContentLoaded', function() {
    const congestionButtonsDiv = document.getElementById('congestionButtons');
    const congestionMessage = document.getElementById('congestionMessage');
    const currentAverageCongestionSpan = document.getElementById('currentAverageCongestion');

    if (congestionButtonsDiv) {
      const spotId = congestionButtonsDiv.dataset.spotId;
      congestionButtonsDiv.addEventListener('click', async function(event) {
        if (event.target.tagName === 'BUTTON') {
          const level = event.target.dataset.level;
          try {
            const response = await fetch(`/spots/${spotId}/congestion`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({ level: level })
            });
            if (!response.ok) {
              const errorData = await response.json();
              throw new Error(errorData.error || '報告に失敗しました。');
            }
            const data = await response.json();
            currentAverageCongestionSpan.textContent = getCongestionText(data.average_congestion);
            congestionMessage.textContent = '混雑の参考情報を報告しました！';
            setTimeout(() => congestionMessage.textContent = '', 3000);
          } catch (error) {
            congestionMessage.textContent = 'エラー: ' + error.message;
            congestionMessage.classList.add('text-danger');
          }
        }
      });
    }

    const likeButton = document.getElementById('likeButton');
    const likesCountSpan = document.getElementById('likesCount');
    if (likeButton) {
      likeButton.addEventListener('click', async function() {
        const spotId = likeButton.dataset.spotId;
        try {
          const response = await fetch(`/spots/${spotId}/like`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          });
          if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.error || 'いいね！に失敗しました。');
          }
          const data = await response.json();
          likesCountSpan.textContent = data.likes_count;
        } catch (error) {
          alert('エラー: ' + error.message);
        }
      });
    }
  });
</script>
@endsection
