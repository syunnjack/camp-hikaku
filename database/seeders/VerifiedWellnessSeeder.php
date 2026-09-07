<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerifiedWellnessSeeder extends Seeder
{
    public function run(): void
    {
        $records = json_decode(<<<'JSON'
[
  {
    "name": "フォレストアドベンチャー・箱根",
    "area": "神奈川県",
    "category": "activity",
    "address": "神奈川県足柄下郡箱根町湯本字茶の花749-1",
    "lat": 35.23409,
    "lng": 139.09724,
    "official_url": "https://foret-aventure.jp/park/fa-hakone/",
    "description": "箱根の森で樹上のコースを巡るアウトドア施設。コースごとに参加条件があるため、年齢・身長・同伴条件を公式サイトで確認してください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-hakone/"
    ]
  },
  {
    "name": "フォレストアドベンチャー・フジ",
    "area": "山梨県",
    "category": "activity",
    "address": "山梨県南都留郡富士河口湖町船津6662-1",
    "lat": 35.452488,
    "lng": 138.748657,
    "official_url": "https://foret-aventure.jp/park/fa-fuji/",
    "description": "富士河口湖町の森で樹上のコースを体験できるアウトドア施設。周辺には同じ住所が広がるため、来場時は公式サイトのアクセス案内と施設名で場所を確認してください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-fuji/"
    ]
  },
  {
    "name": "横浜みなとみらい 万葉倶楽部",
    "area": "神奈川県",
    "category": "ganbanyoku",
    "address": "神奈川県横浜市中区新港2-7-1",
    "lat": 35.4559439,
    "lng": 139.6382009,
    "official_url": "https://manyo.co.jp/mm21/",
    "description": "みなとみらいの温浴施設。岩盤浴のほか、大浴場や展望足湯庭園を備えています。岩盤浴を含む利用条件や追加料金は公式サイトで確認してください。",
    "source_urls": [
      "https://manyo.co.jp/mm21/access/",
      "https://manyo.co.jp/mm21/jyoshitabi/",
      "https://www.manyo.co.jp/goto-ichiran/"
    ]
  },
  {
    "name": "スパジアム ジャポン",
    "area": "東京都",
    "category": "ganbanyoku",
    "address": "東京都東久留米市上の原2-7-7",
    "lat": 35.7730869,
    "lng": 139.5424397,
    "official_url": "https://www.spajapo.com/",
    "description": "東久留米市の温浴施設。岩盤浴室、専用ラウンジ、屋外の岩盤浴テラスを備えています。岩盤浴エリアの利用条件や入館状況は公式案内をご確認ください。",
    "source_urls": [
      "https://www.spajapo.com/access/",
      "https://www.spajapo.com/bedrockbath/"
    ]
  },
  {
    "name": "BIOTOPIA（ビオトピア）森林セラピー",
    "area": "神奈川県",
    "category": "healing",
    "address": "神奈川県足柄上郡大井町山田300（ビオトピア）",
    "lat": 35.337979,
    "lng": 139.158594,
    "official_url": "https://www.biotopia.jp/foresttherapy/",
    "description": "大井町のBIOTOPIAにある森のみちで、自然に触れながら過ごす森林散策。森林セラピーのプログラムは公式案内から確認できます。集合場所や予約の要否は参加するプログラムで確認してください。",
    "source_urls": [
      "https://www.biotopia.jp/foresttherapy/",
      "https://www.biotopia.jp/access/"
    ]
  },
  {
    "name": "赤沢自然休養林",
    "area": "長野県",
    "category": "healing",
    "address": "長野県木曽郡上松町 赤沢自然休養林",
    "lat": 35.7315065,
    "lng": 137.6242954,
    "official_url": "https://kiso-hinoki.jp/colibri-wp/tourist/akasawa/",
    "description": "木曽ヒノキの天然林を散策できる自然休養林。森林浴やガイド付きの体験が案内されています。開園期間やコースの通行状況、ガイドの予約条件は公式サイトで確認してください。",
    "source_urls": [
      "https://kiso-hinoki.jp/colibri-wp/tourist/akasawa/",
      "https://www.rinya.maff.go.jp/chubu/kiso/google_street_view/akasawa.html",
      "https://shinrinyoku.kiso-hinoki.jp/menu/"
    ]
  },
  {
    "name": "スパ ラクーア",
    "area": "東京都",
    "category": "spa",
    "address": "東京都文京区春日1丁目1-1 ラクーアビル（フロント6F）",
    "lat": 35.7068176,
    "lng": 139.7511468,
    "official_url": "https://www.laqua.jp/spa/",
    "description": "東京ドームシティのラクーアビルにある温浴施設。天然温泉やサウナ、休憩スペースを備えています。入館条件と営業時間、各エリアの利用料金は公式サイトをご確認ください。",
    "source_urls": [
      "https://www.laqua.jp/spa/",
      "https://www.laqua.jp/access/"
    ]
  },
  {
    "name": "SPAWORLD HOTEL&RESORT（スパワールド）",
    "area": "大阪府",
    "category": "spa",
    "address": "大阪府大阪市浪速区恵美須東3-4-24",
    "lat": 34.650193,
    "lng": 135.505705,
    "official_url": "https://www.spaworld.co.jp/",
    "description": "大阪・新世界エリアの温浴リゾート。世界各地をテーマにした浴場やサウナを備えています。浴場の利用区分、料金や営業時間は公式サイトで確認してください。",
    "source_urls": [
      "https://www.spaworld.co.jp/onsen/",
      "https://www.spaworld.co.jp/about/access.html"
    ]
  }
]
JSON, true, 512, JSON_THROW_ON_ERROR);
        $added = 0;
        DB::transaction(function () use ($records, &$added) {
            foreach ($records as $record) {
                // Never rewrite an existing facility, its reviews or its booking links.
                $existing = DB::table('spots')->where('official_url', $record['official_url'])
                    ->orWhere(fn ($q) => $q->where('name', $record['name'])->where('area', $record['area']))->exists();
                if ($existing) { continue; }
                DB::table('spots')->insert(array_merge($record, [
                    'source_urls' => json_encode($record['source_urls'], JSON_UNESCAPED_SLASHES),
                    'source_checked_at' => '2026-09-08',
                    'location_note' => '地図の位置は公式案内に掲載された地図・現地写真の代表地点です。入口や集合場所は公式アクセス案内でご確認ください。',
                    'tags' => '[]', 'created_at' => now(), 'updated_at' => now(),
                ]));
                $added++;
            }
        });
        $this->command?->info("公式情報を確認した施設を{$added}件追加しました。");
    }
}
