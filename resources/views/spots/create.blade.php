@extends('layouts.plain')

@section('title', '施設を投稿する - ' . config('app.name'))
@section('description', '地図をタップして場所を選び、施設の名称とひとことコメントを投稿できます。ログイン不要・匿名で投稿可能です。')

@section('content')
<div class="container my-4">
  <h1 class="h4 mb-3">➕ 施設を投稿する</h1>
  <p class="text-muted small mb-3">地図で場所を選ぶか、緯度・経度を入力してください。ログイン不要で投稿できます。</p>

  <div id="map" style="height: 360px;" class="rounded shadow-sm border mb-3"></div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('spots.store') }}" class="bg-light p-3 rounded shadow-sm">
    @csrf
    <div class="mb-3"><label for="category" class="form-label">ジャンル *</label><select name="category" id="category" class="form-select" required><option value="">選択してください</option>@foreach(\App\Support\Discovery::CATEGORIES as $key=>$item)<option value="{{ $key }}" @selected(old('category')===$key)>{{ $item['label'] }}</option>@endforeach</select></div>
    <fieldset class="mb-3"><legend class="fs-6">利用シーン（任意）</legend>@foreach(\App\Support\Discovery::TAGS as $key=>$label)<label class="me-3"><input type="checkbox" name="tags[]" value="{{ $key }}" @checked(in_array($key,old('tags',[])))> {{ $label }}</label>@endforeach</fieldset>
    <div class="mb-3"><label for="official_url" class="form-label">公式サイトURL（任意）</label><input type="url" id="official_url" name="official_url" value="{{ old('official_url') }}" class="form-control" maxlength="1000" placeholder="https://"><p class="small text-muted">利用者が登録した情報として表示されます。</p></div>
    <div style="position:absolute; left:-9999px;" aria-hidden="true">
      <label>ウェブサイト<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
    </div>

    <div class="mb-3">
      <label class="form-label">名称 <span class="text-danger">*</span></label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">ひとことコメント</label>
      <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">エリア</label>
      <input type="text" name="area" value="{{ old('area') }}" class="form-control" placeholder="例：山梨県、長野県">
    </div>

    <div class="row mb-3">
      <div class="col-6">
        <label class="form-label">緯度 <span class="text-danger">*</span></label>
        <input type="number" step="any" min="-90" max="90" id="lat" name="lat" value="{{ old('lat') }}" class="form-control" required>
      </div>
      <div class="col-6">
        <label class="form-label">経度 <span class="text-danger">*</span></label>
        <input type="number" step="any" min="-180" max="180" id="lng" name="lng" value="{{ old('lng') }}" class="form-control" required>
      </div>
    </div>

    <button type="submit" class="btn btn-danger w-100">登録する</button>
  </form>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('map').setView([35.6812, 138.5], 8);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let marker;
    map.on('click', function (e) {
      const lat = e.latlng.lat.toFixed(7);
      const lng = e.latlng.lng.toFixed(7);
      document.getElementById('lat').value = lat;
      document.getElementById('lng').value = lng;

      if (marker) {
        marker.setLatLng(e.latlng);
      } else {
        marker = L.marker(e.latlng).addTo(map);
      }
    });
  });
</script>
@endsection
