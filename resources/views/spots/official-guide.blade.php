<section class="metro-note my-4" id="official-guide" aria-labelledby="official-guide-heading">
  <p class="metro-eyebrow">公式情報から調べた利用案内</p>
  <h2 id="official-guide-heading">料金・予約・利用条件</h2>
  <p class="small">編集：{{ config('app.name') }}編集部 · 公式情報確認日：<time datetime="{{ $guide['checked_at'] }}">{{ $guide['checked_at'] }}</time>。現地訪問の体験記とは区別して掲載しています。</p>
  <p>{{ $guide['summary'] }}</p>
  <p class="metro-price">{{ $guide['price'] }}</p><p>{{ $guide['price_condition'] }}</p>
  <dl class="metro-facts"><div><dt>所在地・集合先</dt><dd>{{ $guide['address'] }}</dd></div>@foreach($guide['facts'] as $label=>$value)<div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>@endforeach</dl>
  <h3 class="h5">利用前によくある質問</h3>
  @foreach($guide['questions'] as [$question,$answer])<details class="metro-faq"><summary>{{ $question }}</summary><p>{{ $answer }}</p></details>@endforeach
  <h3 class="h5 mt-4">この利用案内の出典</h3>
  <ul>@foreach($guide['sources'] as $source)<li><a href="{{ $source['url'] }}" target="_blank" rel="noopener noreferrer">{{ $source['label'] }} ↗</a></li>@endforeach</ul>
  <p class="small">料金・開催状況は変更される場合があります。日付と人数を指定した最終条件は公式サイトで確認してください。</p>
  <a href="{{ route('guides.metropolitan') }}">首都圏の6ジャンルを比較する →</a>
</section>
