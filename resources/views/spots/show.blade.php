@extends('layouts.plain')

@section('title', $spot->name . ' の空き状況・口コミ | ' . config('app.name'))
@section('description', $spot->name . '（' . ($spot->area ?? 'キャンプ場') . '）の場所・空き状況・利用者の口コミを確認できます。')

@push('structured-data')
<script type="application/ld+json">
{!! json_encode([
  '@@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => config('app.name'), 'item' => url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => $spot->name, 'item' => url("/spots/{$spot->id}")],
  ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script type="application/ld+json">
{!! json_encode(array_filter([
  '@@context' => 'https://schema.org',
  '@type' => 'CampingPitch',
  'name' => $spot->name,
  'description' => $spot->description,
  'geo' => [
      '@type' => 'GeoCoordinates',
      'latitude' => $spot->lat,
      'longitude' => $spot->lng,
  ],
  'address' => $spot->area,
]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')
<div class="container my-4">
  <div class="card shadow-sm">
    <div class="card-body p-4">
      <h1 class="h3 fw-bold mb-3">{{ $spot->name }}</h1>
      @php
        $tagLabels = ['family' => 'ファミリー', 'couple' => 'カップル', 'friends' => 'お友達', 'solo' => 'ソロキャンプ'];
        $categoryLabels = ['campground' => 'キャンプ場', 'glamping' => 'グランピング'];
      @endphp
      @if($spot->category && isset($categoryLabels[$spot->category]))
        <span class="badge bg-info text-dark mb-2">{{ $categoryLabels[$spot->category] }}</span>
      @endif
      <p class="text-muted mb-2">{{ $spot->description }}</p>
      @if($spot->area)
        <p class="text-secondary small mb-2">エリア: {{ $spot->area }}</p>
      @endif
      @if(!empty($spot->tags))
        <div class="mb-3">
          @foreach($spot->tags as $tag)
            <span class="badge bg-light text-dark border">{{ $tagLabels[$tag] ?? $tag }}</span>
          @endforeach
        </div>
      @endif

      @if($spot->booking_url)
        @php
          $providerLabels = ['rakuten' => '楽天トラベルで予約', 'ikyu' => '一休.comで詳細を見る'];
        @endphp
        <div class="mb-3">
          <a href="{{ $spot->booking_url }}" target="_blank" rel="nofollow noopener noreferrer" class="btn btn-outline-danger btn-sm">
            {{ $providerLabels[$spot->booking_provider] ?? '予約サイトで見る' }}
          </a>
        </div>
      @endif

      <div class="mb-3">
        <a href="{{ route('spots.index') }}" class="btn btn-secondary">トップページに戻る</a>
      </div>

      <h2 class="h5 mb-2">
        現在の空き状況: <span id="currentAverageCongestion" class="text-primary fw-bold">
          {{ \App\Helpers\CongestionHelper::getText($spot->average_congestion) }}
        </span>
      </h2>

      <h3 class="h6 mt-4 mb-2">空き状況を報告する</h3>
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
          <button type="submit" class="btn btn-line">🔔 空き状況が変わったらLINEで通知を受け取る</button>
        @endif
      </form>

      <div class="d-flex align-items-center mt-4 mb-4">
        <button id="likeButton" data-spot-id="{{ $spot->id }}" class="btn btn-primary me-2">いいね！</button>
        <span id="likesCount" class="h4 fw-bold mb-0">{{ $spot->likes_count }}</span> <span class="text-muted ms-1">件のいいね！</span>
      </div>

      <h3 class="h6 mt-4 mb-2">口コミを投稿する</h3>
      <form action="{{ route('spots.reviews.store', $spot) }}" method="POST" class="bg-light p-3 rounded shadow-sm">
        @csrf
        <div style="position:absolute; left:-9999px;" aria-hidden="true">
          <label>ウェブサイト<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        </div>
        <div class="mb-2">
          <label class="form-label small">ニックネーム（任意）</label>
          <input type="text" name="nickname" class="form-control form-control-sm" maxlength="30">
        </div>
        <div class="mb-2">
          <label class="form-label small">評価</label>
          <select name="rating" class="form-select form-select-sm" required>
            <option value="">選択してください</option>
            <option value="5">★★★★★</option>
            <option value="4">★★★★☆</option>
            <option value="3">★★★☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="1">★☆☆☆☆</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label small">口コミ</label>
          <textarea name="comment" class="form-control form-control-sm" rows="3" minlength="5" maxlength="1000" required></textarea>
        </div>
        <button type="submit" class="btn btn-dark">投稿する</button>
      </form>

      <h3 class="h6 mt-5 mb-3">口コミ</h3>
      <div id="reviewList">
        @forelse($spot->reviews as $review)
          <div class="card mb-3 bg-light">
            <div class="card-body">
              <div>{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }} <strong>{{ $review->nickname }}</strong></div>
              <p class="mb-1">{{ $review->comment }}</p>
              <small class="text-muted">投稿日: {{ $review->created_at->format('Y/m/d H:i') }}</small>
            </div>
          </div>
        @empty
          <p class="text-muted">まだ口コミはありません。</p>
        @endforelse
      </div>
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
            congestionMessage.textContent = '空き状況を報告しました！';
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
