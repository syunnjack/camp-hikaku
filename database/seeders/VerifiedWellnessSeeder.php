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
  },
  {
    "name": "フォレストアドベンチャー・恵庭",
    "area": "北海道",
    "category": "activity",
    "address": "北海道恵庭市西島松275番地 ルルマップ自然公園ふれらんど内",
    "lat": 42.91677,
    "lng": 141.552921,
    "official_url": "https://foret-aventure.jp/park/fa-eniwa/",
    "description": "北海道恵庭市西島松275番地 ルルマップ自然公園ふれらんど内にある樹上アクティビティ施設。トレックコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-eniwa/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・塩竈",
    "area": "宮城県",
    "category": "activity",
    "address": "宮城県塩竈市伊保石95-1　伊保石公園内",
    "lat": 38.34166287184805,
    "lng": 141.01157427613927,
    "official_url": "https://foret-aventure.jp/park/fa-shiogama/",
    "description": "宮城県塩竈市伊保石95-1　伊保石公園内にある樹上アクティビティ施設。森の地形を活かしたコースで体を動かす体験ができます。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-shiogama/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・龍ケ崎",
    "area": "茨城県",
    "category": "activity",
    "address": "茨城県龍ケ崎市泉町1966番地　龍ケ崎市森林公園内",
    "lat": 35.9453754,
    "lng": 140.216704,
    "official_url": "https://foret-aventure.jp/park/fa-ryugasaki/",
    "description": "茨城県龍ケ崎市泉町1966番地　龍ケ崎市森林公園内にある樹上アクティビティ施設。森の地形を活かしたコースで体を動かす体験ができます。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-ryugasaki/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・とちぎ（旧おおひら）",
    "area": "栃木県",
    "category": "activity",
    "address": "栃木県栃木市大平町西山田857",
    "lat": 36.352336,
    "lng": 139.681629,
    "official_url": "https://foret-aventure.jp/park/fa-tochigi/",
    "description": "栃木県栃木市大平町西山田857にある樹上アクティビティ施設。トレックコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-tochigi/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・上野",
    "area": "群馬県",
    "category": "activity",
    "address": "群馬県多野郡上野村勝山1169",
    "lat": 36.0732144,
    "lng": 138.77449325913085,
    "official_url": "https://foret-aventure.jp/park/fa-ueno/",
    "description": "群馬県多野郡上野村勝山1169にある樹上アクティビティ施設。キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-ueno/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・秩父",
    "area": "埼玉県",
    "category": "activity",
    "address": "埼玉県秩父市久那637-2 埼玉トヨペット秩父グリーンミューズパーク・スポーツの森",
    "lat": 35.98819,
    "lng": 139.049459,
    "official_url": "https://foret-aventure.jp/park/fa-chichibu/",
    "description": "埼玉県秩父市久那637-2 埼玉トヨペット秩父グリーンミューズパーク・スポーツの森にある樹上アクティビティ施設。トレックコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-chichibu/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・千葉",
    "area": "千葉県",
    "category": "activity",
    "address": "千葉県千葉市若葉区野呂町108番地 泉自然公園内",
    "lat": 35.5772748,
    "lng": 140.2272417,
    "official_url": "https://foret-aventure.jp/park/fa-chiba/",
    "description": "千葉県千葉市若葉区野呂町108番地 泉自然公園内にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-chiba/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・よこはま",
    "area": "神奈川県",
    "category": "activity",
    "address": "神奈川県横浜市旭区上白根町1425-4",
    "lat": 35.5013829,
    "lng": 139.5255613,
    "official_url": "https://foret-aventure.jp/park/fa-yokohama/",
    "description": "神奈川県横浜市旭区上白根町1425-4にある樹上アクティビティ施設。トレックコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-yokohama/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・湯沢中里",
    "area": "新潟県",
    "category": "activity",
    "address": "新潟県南魚沼郡湯沢町土樽5044-1 湯沢中里スノーリゾート内",
    "lat": 36.916331,
    "lng": 138.849944,
    "official_url": "https://foret-aventure.jp/park/fa-nakazato/",
    "description": "新潟県南魚沼郡湯沢町土樽5044-1 湯沢中里スノーリゾート内にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-nakazato/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・長野",
    "area": "長野県",
    "category": "activity",
    "address": "長野県長野市大字上ヶ屋2471-608",
    "lat": 36.703175,
    "lng": 138.1431242,
    "official_url": "https://foret-aventure.jp/park/fa-nagano/",
    "description": "長野県長野市大字上ヶ屋2471-608にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-nagano/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・三島スカイウォーク",
    "area": "静岡県",
    "category": "activity",
    "address": "静岡県三島市笹原新田313",
    "lat": 35.151681,
    "lng": 138.980696,
    "official_url": "https://foret-aventure.jp/park/fa-mishima-skywalk/",
    "description": "静岡県三島市笹原新田313にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-mishima-skywalk/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・豊田鞍ヶ池",
    "area": "愛知県",
    "category": "activity",
    "address": "愛知県豊田市矢並町法沢713-2 鞍ケ池公園内",
    "lat": 35.096543499999996,
    "lng": 137.2157005,
    "official_url": "https://foret-aventure.jp/park/fa-toyotakuragaike/",
    "description": "愛知県豊田市矢並町法沢713-2 鞍ケ池公園内にある樹上アクティビティ施設。キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-toyotakuragaike/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・湯の山",
    "area": "三重県",
    "category": "activity",
    "address": "三重県三重郡菰野町菰野4958",
    "lat": 35.009993,
    "lng": 136.473178,
    "official_url": "https://foret-aventure.jp/park/fa-yunoyama/",
    "description": "三重県三重郡菰野町菰野4958にある樹上アクティビティ施設。アドベンチャーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-yunoyama/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・栗東",
    "area": "滋賀県",
    "category": "activity",
    "address": "滋賀県栗東市観音寺459",
    "lat": 34.964422,
    "lng": 136.043917,
    "official_url": "https://foret-aventure.jp/park/fa-ritto/",
    "description": "滋賀県栗東市観音寺459にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-ritto/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・神戸六甲山",
    "area": "兵庫県",
    "category": "activity",
    "address": "兵庫県神戸市灘区六甲山町北六甲4512-98",
    "lat": 34.766981,
    "lng": 135.24293800000004,
    "official_url": "https://foret-aventure.jp/park/fa-koberokkosan/",
    "description": "兵庫県神戸市灘区六甲山町北六甲4512-98にある樹上アクティビティ施設。キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-koberokkosan/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・たたらの里",
    "area": "島根県",
    "category": "activity",
    "address": "島根県雲南市吉田町吉田2330",
    "lat": 35.16602675810593,
    "lng": 132.8417472744236,
    "official_url": "https://foret-aventure.jp/park/fa-tataranosato/",
    "description": "島根県雲南市吉田町吉田2330にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-tataranosato/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・広島",
    "area": "広島県",
    "category": "activity",
    "address": "広島県廿日市市吉和1593-75",
    "lat": 34.481199,
    "lng": 132.174091,
    "official_url": "https://foret-aventure.jp/park/fa-hiroshima/",
    "description": "広島県廿日市市吉和1593-75にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-hiroshima/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・祖谷",
    "area": "徳島県",
    "category": "activity",
    "address": "徳島県三好市西祖谷山村尾井ノ内379　祖谷ふれあい公園内",
    "lat": 33.891265,
    "lng": 133.814218,
    "official_url": "https://foret-aventure.jp/park/fa-iya/",
    "description": "徳島県三好市西祖谷山村尾井ノ内379　祖谷ふれあい公園内にある樹上アクティビティ施設。アドベンチャーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-iya/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・西条",
    "area": "愛媛県",
    "category": "activity",
    "address": "愛媛県西条市河之内甲486-1 本谷公園内",
    "lat": 33.929515,
    "lng": 133.022877,
    "official_url": "https://foret-aventure.jp/park/fa-saijo/",
    "description": "愛媛県西条市河之内甲486-1 本谷公園内にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-saijo/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・高知",
    "area": "高知県",
    "category": "activity",
    "address": "高知県高岡郡津野町芳生野乙5422番地（長沢の滝）",
    "lat": 33.429518,
    "lng": 132.990692,
    "official_url": "https://foret-aventure.jp/park/fa-kochi/",
    "description": "高知県高岡郡津野町芳生野乙5422番地（長沢の滝）にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-kochi/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・油山福岡",
    "area": "福岡県",
    "category": "activity",
    "address": "福岡県福岡市南区柏原710-2 ABURAYAMA FUKUOKA内",
    "lat": 33.509014261077,
    "lng": 130.3766023571107,
    "official_url": "https://foret-aventure.jp/park/fa-abyfukuoka/",
    "description": "福岡県福岡市南区柏原710-2 ABURAYAMA FUKUOKA内にある樹上アクティビティ施設。森の地形を活かしたコースで体を動かす体験ができます。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-abyfukuoka/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・吉野ヶ里",
    "area": "佐賀県",
    "category": "activity",
    "address": "佐賀県神埼郡吉野ヶ里町三津2753 アドベンチャーバレーSAGA内",
    "lat": 33.366462,
    "lng": 130.390088,
    "official_url": "https://foret-aventure.jp/park/fa-yoshinogari/",
    "description": "佐賀県神埼郡吉野ヶ里町三津2753 アドベンチャーバレーSAGA内にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-yoshinogari/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・おおむら長崎",
    "area": "長崎県",
    "category": "activity",
    "address": "長崎県大村市東野岳町1596-1",
    "lat": 32.976249473581056,
    "lng": 129.9763798754687,
    "official_url": "https://foret-aventure.jp/park/fa-omuranagasaki/",
    "description": "長崎県大村市東野岳町1596-1にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-omuranagasaki/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・美里",
    "area": "熊本県",
    "category": "activity",
    "address": "熊本県下益城郡美里町畝野3083-1 美里の森キャンプ場　ガーデンプレイス隣接",
    "lat": 32.633464,
    "lng": 130.909775,
    "official_url": "https://foret-aventure.jp/park/fa-misato/",
    "description": "熊本県下益城郡美里町畝野3083-1 美里の森キャンプ場　ガーデンプレイス隣接にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-misato/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・別府",
    "area": "大分県",
    "category": "activity",
    "address": "大分県別府市志高4380-1",
    "lat": 33.2660448,
    "lng": 131.4527463,
    "official_url": "https://foret-aventure.jp/park/fa-beppu/",
    "description": "大分県別府市志高4380-1にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-beppu/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・吹上浜",
    "area": "鹿児島県",
    "category": "activity",
    "address": "鹿児島県日置市吹上町中原1352-34",
    "lat": 31.516886141406623,
    "lng": 130.33107756770664,
    "official_url": "https://foret-aventure.jp/park/fa-fukiagehama/",
    "description": "鹿児島県日置市吹上町中原1352-34にある樹上アクティビティ施設。トレックコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-fukiagehama/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャーin恩納",
    "area": "沖縄県",
    "category": "activity",
    "address": "沖縄県国頭郡恩納村字真栄田1525",
    "lat": 26.37906280912491,
    "lng": 127.86006368328854,
    "official_url": "https://foret-aventure.jp/park/fa-onna/",
    "description": "沖縄県国頭郡恩納村字真栄田1525にある樹上アクティビティ施設。アドベンチャーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-onna/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "信州・信濃町 癒しの森®",
    "area": "長野県",
    "category": "healing",
    "address": "長野県信濃町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/nagano-shinanomachi/",
    "description": "長野県信濃町の森林セラピー拠点。認定団体の案内には「御鹿池コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/nagano-shinanomachi/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "飯南町ふるさとの森",
    "area": "島根県",
    "category": "healing",
    "address": "島根県飯南町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/iinan/",
    "description": "島根県飯南町の森林セラピー拠点。認定団体の案内には「山野草園コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/iinan/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "津別町森林セラピー基地（ノンノの森）",
    "area": "北海道",
    "category": "healing",
    "address": "北海道網走郡津別町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/tsubetsu/",
    "description": "北海道網走郡津別町の森林セラピー拠点。認定団体の案内には「こもれびの道」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/tsubetsu/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "岩手町森林セラピー基地",
    "area": "岩手県",
    "category": "healing",
    "address": "岩手県岩手町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/iwate/",
    "description": "岩手県岩手町の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/iwate/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "森と水の癒し里かづの",
    "area": "秋田県",
    "category": "healing",
    "address": "秋田県鹿角市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/akita-kazuno/",
    "description": "秋田県鹿角市の森林セラピー拠点。認定団体の案内には「鹿角市の森林セラピー基地【森と水の癒し里かづの】」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/akita-kazuno/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "温身平森林セラピー®基地",
    "area": "山形県",
    "category": "healing",
    "address": "山形県小国町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/nukumidaira/",
    "description": "山形県小国町の森林セラピー拠点。認定団体の案内には「メインロード」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/nukumidaira/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "登米ふれあいの森",
    "area": "宮城県",
    "category": "healing",
    "address": "宮城県登米市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/miyagi-tome/",
    "description": "宮城県登米市の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/miyagi%EF%B8%8E%EF%B8%8E%EF%B8%8E%EF%B8%8E-tome/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "白神十二湖森林セラピー基地",
    "area": "青森県",
    "category": "healing",
    "address": "青森県深浦町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/aomori-fukaura/",
    "description": "青森県深浦町の森林セラピー拠点。認定団体の案内には「沸壺の池・青池コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/aomori-fukaura/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "奥久慈憩いの森",
    "area": "茨城県",
    "category": "healing",
    "address": "茨城県大子町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/okukuji/",
    "description": "茨城県大子町の森林セラピー拠点。認定団体の案内には「森林浴モデルコース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/okukuji/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "上野村森林セラピー基地",
    "area": "群馬県",
    "category": "healing",
    "address": "群馬県上野村",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/gunma-uenomura/",
    "description": "群馬県上野村の森林セラピー拠点。認定団体の案内には「中之沢源流域自然散策路」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/gunma-uenomura/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "草津町 森林セラピー基地",
    "area": "群馬県",
    "category": "healing",
    "address": "群馬県草津町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/gunma-kusatsu/",
    "description": "群馬県草津町の森林セラピー拠点。認定団体の案内には「草津森の癒し歩道」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/gunma-kusatsu/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "赤城自然園",
    "area": "群馬県",
    "category": "healing",
    "address": "群馬県渋川市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/gunma-akagishizenen/",
    "description": "群馬県渋川市の森林セラピー拠点。認定団体の案内には「セゾンガーデンエリア」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/gunma-akagishizenen/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "甘楽町森林セラピー基地",
    "area": "群馬県",
    "category": "healing",
    "address": "群馬県甘楽町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/kanramachi/",
    "description": "群馬県甘楽町の森林セラピー拠点。認定団体の案内には「八幡山夕陽ヶ丘コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/kanramachi/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "きたもと森林セラピー",
    "area": "埼玉県",
    "category": "healing",
    "address": "埼玉県北本市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/saitama-kitamoto/",
    "description": "埼玉県北本市の森林セラピー拠点。認定団体の案内には「石戸堤コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/saitama-kitamoto/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "おくたま巨樹に癒される森",
    "area": "東京都",
    "category": "healing",
    "address": "東京都奥多摩町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/okutama/",
    "description": "東京都奥多摩町の森林セラピー拠点。認定団体の案内には「登計トレイル」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/okutama/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "檜原都民の森",
    "area": "東京都",
    "category": "healing",
    "address": "東京都檜原村",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/tokyo-hinohara/",
    "description": "東京都檜原村の森林セラピー拠点。認定団体の案内には「１．檜原ジャガイモとのびる味噌」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/tokyo-hinohara/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "南房総市 森林セラピー基地",
    "area": "千葉県",
    "category": "healing",
    "address": "千葉県南房総市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/minamiboso/",
    "description": "千葉県南房総市の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/minamiboso/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "厚木市 七沢森林公園",
    "area": "神奈川県",
    "category": "healing",
    "address": "神奈川県厚木市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/kanagawa-nanasawa/",
    "description": "神奈川県厚木市の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/kanagawa-nanasawa/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "森林のおもてなし・やまきた",
    "area": "神奈川県",
    "category": "healing",
    "address": "神奈川県山北町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/kanagawa-yamakita/",
    "description": "神奈川県山北町の森林セラピー拠点。認定団体の案内には「河村城跡・洒水の滝コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/kanagawa-yamakita/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "箱根芦ノ湖森林セラピー基地",
    "area": "神奈川県",
    "category": "healing",
    "address": "神奈川県箱根町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/hakone-ashinoko/",
    "description": "神奈川県箱根町の森林セラピー拠点。認定団体の案内には「箱根やすらぎの森セラピーロード」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/hakone-ashinoko/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "はだの表丹沢森林セラピー基地",
    "area": "神奈川県",
    "category": "healing",
    "address": "神奈川県秦野市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/kanagawa-hadano/",
    "description": "神奈川県秦野市の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/kanagawa-hadano/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "森林セラピー基地「樽田の森」",
    "area": "新潟県",
    "category": "healing",
    "address": "新潟県津南町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/taruda-no-mori/",
    "description": "新潟県津南町の森林セラピー拠点。認定団体の案内には「じょんのびコース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/taruda-no-mori/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "生命地域・妙高 薬湯膳の郷",
    "area": "新潟県",
    "category": "healing",
    "address": "新潟県妙高市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/niigata-myoko/",
    "description": "新潟県妙高市の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/niigata-myoko/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "西沢渓谷",
    "area": "山梨県",
    "category": "healing",
    "address": "山梨県山梨市三富川浦",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/yamanasi-nishizawa/",
    "description": "山梨県山梨市三富川浦の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/yamanasi-nishizawa/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "山梨県立武田の杜保健休養林「健康の森」",
    "area": "山梨県",
    "category": "healing",
    "address": "山梨県甲府市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/yamanashi-takeda/",
    "description": "山梨県甲府市の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/yamanashi-takeda/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "森林公園金川の森",
    "area": "山梨県",
    "category": "healing",
    "address": "山梨県笛吹市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/yamanashi-kanegawa/",
    "description": "山梨県笛吹市の森林セラピー拠点。認定団体の案内には「どんぐりの森コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/yamanashi-kanegawa/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "「平尾の森」「春日の森」",
    "area": "長野県",
    "category": "healing",
    "address": "長野県佐久市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/nagano-saku/",
    "description": "長野県佐久市の森林セラピー拠点。認定団体の案内には「「平尾の森」ファーブルの小径」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/nagano-saku/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "森林セラピー基地いいやま",
    "area": "長野県",
    "category": "healing",
    "address": "長野県飯山市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/nagano-iiyama/",
    "description": "長野県飯山市の森林セラピー拠点。認定団体の案内には「ぶなの里山こみち（なべくら高原）」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/nagano-iiyama/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "木島平村 カヤの平高原",
    "area": "長野県",
    "category": "healing",
    "address": "長野県木島平村",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/nagano-kijimadaira/",
    "description": "長野県木島平村の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/nagano-kijimadaira/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "うるわしの森 志賀高原",
    "area": "長野県",
    "category": "healing",
    "address": "長野県山ノ内町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/nagano-shigakogen/",
    "description": "長野県山ノ内町の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/nagano-shigakogen/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "森林セラピー基地小谷",
    "area": "長野県",
    "category": "healing",
    "address": "長野県小谷村",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/nagano-otari/",
    "description": "長野県小谷村の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/nagano-otari/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "信州大芝高原みんなの森",
    "area": "長野県",
    "category": "healing",
    "address": "長野県南箕輪村",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/nagano-minamiminow/",
    "description": "長野県南箕輪村の森林セラピー拠点。認定団体の案内には「リフレッシュコース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/nagano-minamiminow/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "ヘブンスそのはら",
    "area": "長野県",
    "category": "healing",
    "address": "長野県下伊那郡阿智村",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/achi/",
    "description": "長野県下伊那郡阿智村の森林セラピー拠点。認定団体の案内には「いわなの森」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/achi/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "松川町およりての森",
    "area": "長野県",
    "category": "healing",
    "address": "長野県松川町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/nagano-matsukawa/",
    "description": "長野県松川町の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/nagano-matsukawa/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "立山山麓森林セラピー基地",
    "area": "富山県",
    "category": "healing",
    "address": "富山県富山市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/toyama-tateyama/",
    "description": "富山県富山市の森林セラピー拠点。認定団体の案内には「清流と森の小径 初級〜中級者コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/toyama-tateyama/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "剱・きらめきの森",
    "area": "富山県",
    "category": "healing",
    "address": "富山県上市町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/toyama-kamiichi/",
    "description": "富山県上市町の森林セラピー拠点。認定団体の案内には「トガ並木コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/toyama-kamiichi/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "里山の森と湖 石川県森林公園",
    "area": "石川県",
    "category": "healing",
    "address": "石川県津幡町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/ishikawa-tsubata/",
    "description": "石川県津幡町の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/ishikawa-tsubata/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "津市森林セラピー基地",
    "area": "三重県",
    "category": "healing",
    "address": "三重県津市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/tsu/",
    "description": "三重県津市の森林セラピー拠点。認定団体の案内には「大洞山石畳コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/tsu/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "びわこ水源の森 たかしま",
    "area": "滋賀県",
    "category": "healing",
    "address": "滋賀県高島市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/shiga-takashima/",
    "description": "滋賀県高島市の森林セラピー拠点。認定団体の案内には「マキノ高原　調子が滝コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/shiga-takashima/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "高野町 森林セラピー基地",
    "area": "和歌山県",
    "category": "healing",
    "address": "和歌山県伊都郡高野町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/koya/",
    "description": "和歌山県伊都郡高野町の森林セラピー拠点。認定団体の案内には「転軸山周遊ルート」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/koya/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "悠久の風景、吉野の道",
    "area": "奈良県",
    "category": "healing",
    "address": "奈良県吉野町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/yoshino/",
    "description": "奈良県吉野町の森林セラピー拠点。認定団体の案内には「吉野・宮滝 万葉コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/yoshino/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "しそう森林セラピー基地",
    "area": "兵庫県",
    "category": "healing",
    "address": "兵庫県宍粟市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/shiso/",
    "description": "兵庫県宍粟市の森林セラピー拠点。認定団体の案内には「赤西セラピーロード」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/shiso/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "智頭町 森林セラピー基地",
    "area": "鳥取県",
    "category": "healing",
    "address": "鳥取県智頭町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/chizu/",
    "description": "鳥取県智頭町の森林セラピー拠点。認定団体の案内には「国選定重要文化的景観「智頭の林業景観」芦津セラピーロード」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/chizu/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "新庄村森林セラピー基地",
    "area": "岡山県",
    "category": "healing",
    "address": "岡山県新庄村",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/okayama/",
    "description": "岡山県新庄村の森林セラピー拠点。認定団体の案内には「ゆりかごの小径」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/okayama/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "安芸太田町森林セラピー基地",
    "area": "広島県",
    "category": "healing",
    "address": "広島県安芸太田町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/akiota/",
    "description": "広島県安芸太田町の森林セラピー拠点。認定団体の案内には「龍頭峡セラピーロード」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/akiota/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "神石高原町森林セラピー基地",
    "area": "広島県",
    "category": "healing",
    "address": "広島県神石高原町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/jinseki-kogen/",
    "description": "広島県神石高原町の森林セラピー拠点。認定団体の案内には「神龍湖畔こみち」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/jinseki-kogen/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "森林セラピー山口",
    "area": "山口県",
    "category": "healing",
    "address": "山口県山口市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/yamaguchi/",
    "description": "山口県山口市の森林セラピー拠点。認定団体の案内には「愛鳥林コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/yamaguchi/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "四国カルスト天狗高原自然休養林",
    "area": "高知県",
    "category": "healing",
    "address": "高知県津野町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/tsuno/",
    "description": "高知県津野町の森林セラピー拠点。認定団体の案内には「カラマツ林ロード」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/tsuno/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "太郎川公園",
    "area": "高知県",
    "category": "healing",
    "address": "高知県梼原町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/kochi-tarogawa/",
    "description": "高知県梼原町の森林セラピー拠点。認定団体の案内には「久保谷セラピーロード」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/kochi-tarogawa/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "フォレスターハウス",
    "area": "愛媛県",
    "category": "healing",
    "address": "愛媛県新居浜市別子山",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/foresterhouse/",
    "description": "愛媛県新居浜市別子山の森林セラピー拠点。認定団体の案内には「森林浴コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/foresterhouse/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "うきは市 森林セラピー基地",
    "area": "福岡県",
    "category": "healing",
    "address": "福岡県うきは市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/fukuoka-ukiha/",
    "description": "福岡県うきは市の森林セラピー拠点。認定団体の案内には「つづら棚田の散歩道」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/fukuoka-ukiha/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "くつろぎの森グリーンピア八女",
    "area": "福岡県",
    "category": "healing",
    "address": "福岡県八女市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/fukuoka-yame/",
    "description": "福岡県八女市の森林セラピー拠点。認定団体の案内には「熊笹と湖の小道」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/fukuoka-yame/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "森林セラピー基地篠栗",
    "area": "福岡県",
    "category": "healing",
    "address": "福岡県篠栗町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/fukuoka-sasaguri/",
    "description": "福岡県篠栗町の森林セラピー拠点。認定団体の案内には「落陽コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/fukuoka-sasaguri/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "森林セラピー基地 豊前",
    "area": "福岡県",
    "category": "healing",
    "address": "福岡県豊前市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/fukuoka-buzen/",
    "description": "福岡県豊前市の森林セラピー拠点。認定団体の案内には「求菩提山周回コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/fukuoka-buzen/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "大分市 森林セラピー基地",
    "area": "大分県",
    "category": "healing",
    "address": "大分県大分市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/oita/",
    "description": "大分県大分市の森林セラピー拠点。認定団体の案内には「高崎山セラピーロード」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/oita/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "癒しの郷・チェリータウン北郷",
    "area": "宮崎県",
    "category": "healing",
    "address": "宮崎県日南市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/miyazaki-nichinan/",
    "description": "宮崎県日南市の森林セラピー拠点。森林での散策や自然に触れる時間を計画できます。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/miyazaki-nichinan/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "日之影町 森林セラピー基地",
    "area": "宮崎県",
    "category": "healing",
    "address": "宮崎県日之影町",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/miyazaki-hinokage/",
    "description": "宮崎県日之影町の森林セラピー拠点。認定団体の案内には「TR鉄道跡地散策コース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/miyazaki-hinokage/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "水上村森林セラピー基地",
    "area": "熊本県",
    "category": "healing",
    "address": "熊本県水上村",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/kumamoto-mizukami/",
    "description": "熊本県水上村の森林セラピー拠点。認定団体の案内には「森林セラピーショートコース」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/kumamoto-mizukami/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "「いやしの森」国立公園霧島",
    "area": "鹿児島県",
    "category": "healing",
    "address": "鹿児島県霧島市",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/kirishima/",
    "description": "鹿児島県霧島市の森林セラピー拠点。認定団体の案内には「柳ヶ平散策路」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/kirishima/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "命薬の森 国頭村森林セラピー",
    "area": "沖縄県",
    "category": "healing",
    "address": "沖縄県国頭村",
    "lat": null,
    "lng": null,
    "official_url": "https://fo-society.jp/facility/okinawa-kunigami/",
    "description": "沖縄県国頭村の森林セラピー拠点。認定団体の案内には「ヨンナー・リバーソング・ヨンナーコース（1,000ｍ～1,500ｍ）」が掲載されています。コースやプログラムにより出発場所・予約条件が異なります。来訪前に案内窓口で通行状況と開催日をご確認ください。",
    "source_urls": [
      "https://fo-society.jp/facility/okinawa-kunigami/"
    ],
    "location_note": "所在地は認定団体が案内する地域です。複数の散策路を含む拠点もあります。入口・集合場所・通行状況は出典ページの案内窓口でご確認ください。"
  },
  {
    "name": "極楽湯 青森店",
    "area": "青森県",
    "category": "spa",
    "address": "青森県青森市東大野2丁目4-21",
    "lat": 40.7973547,
    "lng": 140.7421325,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/aomori/",
    "description": "青森県青森市東大野2丁目4-21の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/aomori/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 八戸店",
    "area": "青森県",
    "category": "spa",
    "address": "青森県八戸市沼館4-7-108",
    "lat": 40.529992979352215,
    "lng": 141.49713831539924,
    "official_url": "https://hachinohe.gokurakuyu.jp/",
    "description": "青森県八戸市沼館4-7-108の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://hachinohe.gokurakuyu.jp/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 古川店",
    "area": "宮城県",
    "category": "spa",
    "address": "宮城県大崎市古川稲葉国道4号線バイパス近く。",
    "lat": 38.55717597962461,
    "lng": 140.94569831534028,
    "official_url": "https://furukawa.gokurakuyu.jp/",
    "description": "宮城県大崎市古川稲葉国道4号線バイパス近く。の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://furukawa.gokurakuyu.jp/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 富谷店",
    "area": "宮城県",
    "category": "spa",
    "address": "宮城県富谷市成田1-4-1（新富谷ガーデンシティ内）",
    "lat": null,
    "lng": null,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/tomiya/index.html",
    "description": "宮城県富谷市成田1-4-1（新富谷ガーデンシティ内）の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/tomiya/index.html"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 多賀城店",
    "area": "宮城県",
    "category": "spa",
    "address": "宮城県多賀城市町前、国道45号線沿い",
    "lat": 38.284052979669994,
    "lng": 140.9944022153324,
    "official_url": "https://tagajo.gokurakuyu.jp/",
    "description": "宮城県多賀城市町前、国道45号線沿いの温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://tagajo.gokurakuyu.jp/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 名取店",
    "area": "宮城県",
    "category": "spa",
    "address": "宮城県名取市田高字原、県道258号線近く。",
    "lat": 38.179851979687726,
    "lng": 140.87478931532934,
    "official_url": "https://natori.gokurakuyu.jp/",
    "description": "宮城県名取市田高字原、県道258号線近く。の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://natori.gokurakuyu.jp/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 鷹山の湯",
    "area": "山形県",
    "category": "spa",
    "address": "山形県米沢市中田町若宮491-1",
    "lat": 37.93664937973034,
    "lng": 140.12122751532226,
    "official_url": "https://yozan.gokurakuyu.jp/",
    "description": "山形県米沢市中田町若宮491-1の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://yozan.gokurakuyu.jp/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 福島郡山店",
    "area": "福島県",
    "category": "spa",
    "address": "福島県郡山市八山田西五丁目130",
    "lat": 37.42785837982422,
    "lng": 140.36640311588855,
    "official_url": "https://koriyama.gokurakuyu.jp/",
    "description": "福島県郡山市八山田西五丁目130の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://koriyama.gokurakuyu.jp/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 宇都宮店",
    "area": "栃木県",
    "category": "spa",
    "address": "栃木県宇都宮市御幸本町4880",
    "lat": 36.5811,
    "lng": 139.9246,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/utsunomiya/",
    "description": "栃木県宇都宮市御幸本町4880の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/utsunomiya/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 水戸店",
    "area": "茨城県",
    "category": "spa",
    "address": "茨城県水戸市大塚町1838-1",
    "lat": null,
    "lng": null,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/mito/",
    "description": "茨城県水戸市大塚町1838-1の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/mito/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 柏店",
    "area": "千葉県",
    "category": "ganbanyoku",
    "address": "千葉県柏市大山台1-18",
    "lat": 35.8812351,
    "lng": 139.9668424,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/kashiwa/",
    "description": "千葉県柏市大山台1-18の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/kashiwa/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 千葉稲毛店",
    "area": "千葉県",
    "category": "spa",
    "address": "千葉県千葉市稲毛区園生町380-1（オーツーパーク内）",
    "lat": 35.6511245,
    "lng": 140.1200483,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/chibainage/",
    "description": "千葉県千葉市稲毛区園生町380-1（オーツーパーク内）の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/chibainage/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 羽生温泉",
    "area": "埼玉県",
    "category": "spa",
    "address": "埼玉県羽生市神戸８４３−１",
    "lat": null,
    "lng": null,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/hanyu/index.html",
    "description": "埼玉県羽生市神戸８４３−１の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/hanyu/index.html"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 和光店",
    "area": "埼玉県",
    "category": "spa",
    "address": "埼玉県和光市白子1-7-6",
    "lat": 35.7687268,
    "lng": 139.6194225,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/wako/",
    "description": "埼玉県和光市白子1-7-6の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/wako/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 ロイヤル川口",
    "area": "埼玉県",
    "category": "ganbanyoku",
    "address": "埼玉県川口市朝日3丁目13番27号",
    "lat": null,
    "lng": null,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/royalkawaguchi/",
    "description": "埼玉県川口市朝日3丁目13番27号の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/royalkawaguchi/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 上尾店",
    "area": "埼玉県",
    "category": "spa",
    "address": "埼玉県上尾市大字上尾村500-1",
    "lat": 35.9869463,
    "lng": 139.5946382,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/ageo/",
    "description": "埼玉県上尾市大字上尾村500-1の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/ageo/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "京王高尾山温泉",
    "area": "東京都",
    "category": "spa",
    "address": "東京都八王子市高尾町2229番7",
    "lat": null,
    "lng": null,
    "official_url": "https://www.takaosan-onsen.jp/",
    "description": "東京都八王子市高尾町2229番7の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.takaosan-onsen.jp/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 多摩センター店",
    "area": "東京都",
    "category": "spa",
    "address": "東京都多摩市落合一丁目30番地1",
    "lat": null,
    "lng": null,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/tamacenter/",
    "description": "東京都多摩市落合一丁目30番地1の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/tamacenter/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "RAKU SPA Station 府中",
    "area": "東京都",
    "category": "spa",
    "address": "東京都府中市宮西町1-5-1 府中トーセイビルI",
    "lat": null,
    "lng": null,
    "official_url": "https://rakuspa.com/fuchu/",
    "description": "東京都府中市宮西町1-5-1 府中トーセイビルIの温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://rakuspa.com/fuchu/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "RAKU SPA Station 武蔵小金井",
    "area": "東京都",
    "category": "ganbanyoku",
    "address": "東京都小金井市本町2-1-11",
    "lat": null,
    "lng": null,
    "official_url": "https://rakuspa.com/musashi/",
    "description": "東京都小金井市本町2-1-11の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://rakuspa.com/musashi/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "RAKU SPA 1010 神田",
    "area": "東京都",
    "category": "spa",
    "address": "東京都千代田区神田淡路町2-9-9",
    "lat": null,
    "lng": null,
    "official_url": "https://rakuspa.com/kanda/",
    "description": "東京都千代田区神田淡路町2-9-9の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://rakuspa.com/kanda/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "RAKU SPA 鶴見",
    "area": "神奈川県",
    "category": "ganbanyoku",
    "address": "神奈川県横浜市鶴見区元宮2-1-39",
    "lat": null,
    "lng": null,
    "official_url": "https://rakuspa.com/tsurumi/",
    "description": "神奈川県横浜市鶴見区元宮2-1-39の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://rakuspa.com/tsurumi/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "RAKU SPA BAY 横浜",
    "area": "神奈川県",
    "category": "ganbanyoku",
    "address": "神奈川県横浜市神奈川区山内町15-2",
    "lat": null,
    "lng": null,
    "official_url": "https://rakuspa.com/yokohama/",
    "description": "神奈川県横浜市神奈川区山内町15-2の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://rakuspa.com/yokohama/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 横浜芹が谷店",
    "area": "神奈川県",
    "category": "spa",
    "address": "神奈川県横浜市港南区芹が谷5-54-8",
    "lat": 35.4177495,
    "lng": 139.564105,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/serigaya/",
    "description": "神奈川県横浜市港南区芹が谷5-54-8の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/serigaya/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 三島店",
    "area": "静岡県",
    "category": "spa",
    "address": "静岡県三島市三好町4番23号 せせらぎパーク三好内",
    "lat": 35.1107227,
    "lng": 138.9074527,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/mishima/",
    "description": "静岡県三島市三好町4番23号 せせらぎパーク三好内の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/mishima/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "RAKU SPA Cafe 浜松",
    "area": "静岡県",
    "category": "ganbanyoku",
    "address": "静岡県浜松市中央区若林町1680-5",
    "lat": null,
    "lng": null,
    "official_url": "https://www.rakuspa.com/hamamatsu/",
    "description": "静岡県浜松市中央区若林町1680-5の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.rakuspa.com/hamamatsu/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 豊橋店",
    "area": "愛知県",
    "category": "spa",
    "address": "愛知県豊橋市瓜郷町一新替13-1",
    "lat": 34.7883573,
    "lng": 137.3766445,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/toyohashi/",
    "description": "愛知県豊橋市瓜郷町一新替13-1の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/toyohashi/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "RAKU SPA GARDEN 名古屋",
    "area": "愛知県",
    "category": "ganbanyoku",
    "address": "愛知県名古屋市名東区平和が丘1-65-2",
    "lat": null,
    "lng": null,
    "official_url": "https://rakuspa.com/nagoya/",
    "description": "愛知県名古屋市名東区平和が丘1-65-2の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://rakuspa.com/nagoya/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 津店",
    "area": "三重県",
    "category": "spa",
    "address": "三重県津市白塚町3678番地  SENOPARK（セノパーク）津内",
    "lat": 34.7664526,
    "lng": 136.5283685,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/tsu/",
    "description": "三重県津市白塚町3678番地  SENOPARK（セノパーク）津内の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/tsu/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 松崎店",
    "area": "新潟県",
    "category": "spa",
    "address": "新潟県新潟市東区新松崎3丁目-24-13",
    "lat": null,
    "lng": null,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/matsusaki/index.html",
    "description": "新潟県新潟市東区新松崎3丁目-24-13の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/matsusaki/index.html"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 槇尾店",
    "area": "新潟県",
    "category": "spa",
    "address": "新潟県新潟市西区槇尾424",
    "lat": null,
    "lng": null,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/makio/index.html",
    "description": "新潟県新潟市西区槇尾424の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/makio/index.html"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 金沢野々市店",
    "area": "石川県",
    "category": "spa",
    "address": "石川県野々市市若松町18-1",
    "lat": 36.5349609,
    "lng": 136.6124181,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/nonoichi/",
    "description": "石川県野々市市若松町18-1の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/nonoichi/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 福井店",
    "area": "福井県",
    "category": "spa",
    "address": "福井県福井市開発1丁目118番地",
    "lat": null,
    "lng": null,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/fukui/",
    "description": "福井県福井市開発1丁目118番地の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/fukui/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "極楽湯 彦根店",
    "area": "滋賀県",
    "category": "spa",
    "address": "滋賀県彦根市西沼波町175-1",
    "lat": 35.2578328,
    "lng": 136.2665227,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/hikone/",
    "description": "滋賀県彦根市西沼波町175-1の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/hikone/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 茨木店",
    "area": "大阪府",
    "category": "spa",
    "address": "大阪府茨木市田中町１８－１８",
    "lat": 34.8271126,
    "lng": 135.5730011,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/ibaraki/",
    "description": "大阪府茨木市田中町１８－１８の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/ibaraki/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "極楽湯 堺泉北店",
    "area": "大阪府",
    "category": "spa",
    "address": "大阪府堺市南区豊田825",
    "lat": 34.4965537,
    "lng": 135.4935511,
    "official_url": "https://www.gokurakuyu.ne.jp/tempo/sakaisenboku/",
    "description": "大阪府堺市南区豊田825の温浴施設。日帰りの入浴を計画できます。浴場の設備・営業時間・利用料金は公式サイトでご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.gokurakuyu.ne.jp/tempo/sakaisenboku/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・つくば",
    "area": "茨城県",
    "category": "activity",
    "address": "茨城県つくば市沼田1688",
    "lat": 36.2122662,
    "lng": 140.0885941,
    "official_url": "https://foret-aventure.jp/park/fa-tsukuba/",
    "description": "茨城県つくば市沼田1688にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-tsukuba/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・ターザニア",
    "area": "千葉県",
    "category": "activity",
    "address": "千葉県長生郡長柄町味庄1067リソルの森内",
    "lat": 35.5409386992551,
    "lng": 139.7793083721313,
    "official_url": "https://foret-aventure.jp/park/fa-tarzania/",
    "description": "千葉県長生郡長柄町味庄1067リソルの森内にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-tarzania/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・小田原",
    "area": "神奈川県",
    "category": "activity",
    "address": "神奈川県小田原市久野4391",
    "lat": 35.259461,
    "lng": 139.121176,
    "official_url": "https://foret-aventure.jp/park/fa-odawara/",
    "description": "神奈川県小田原市久野4391にある樹上アクティビティ施設。森の地形を活かしたコースで体を動かす体験ができます。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-odawara/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・こすげ",
    "area": "山梨県",
    "category": "activity",
    "address": "山梨県北都留郡小菅村3445 道の駅こすげ・多摩源流温泉「こすげの湯」隣接",
    "lat": 35.753582,
    "lng": 138.949273,
    "official_url": "https://foret-aventure.jp/park/fa-kosuge/",
    "description": "山梨県北都留郡小菅村3445 道の駅こすげ・多摩源流温泉「こすげの湯」隣接にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-kosuge/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・蓼科",
    "area": "長野県",
    "category": "activity",
    "address": "長野県茅野市北山字鹿山4026-2　東急リゾートタウン蓼科 内",
    "lat": 36.06849,
    "lng": 138.255111,
    "official_url": "https://foret-aventure.jp/park/fa-tateshina/",
    "description": "長野県茅野市北山字鹿山4026-2　東急リゾートタウン蓼科 内にある樹上アクティビティ施設。森の地形を活かしたコースで体を動かす体験ができます。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-tateshina/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・松川",
    "area": "長野県",
    "category": "activity",
    "address": "長野県下伊那郡松川町大島2805-1",
    "lat": 35.61483,
    "lng": 137.878136,
    "official_url": "https://foret-aventure.jp/park/fa-matsukawa/",
    "description": "長野県下伊那郡松川町大島2805-1にある樹上アクティビティ施設。トレックコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-matsukawa/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・御殿場",
    "area": "静岡県",
    "category": "activity",
    "address": "静岡県御殿場市印野1380-15",
    "lat": 35.298368,
    "lng": 138.868292,
    "official_url": "https://foret-aventure.jp/park/fa-gotemba/",
    "description": "静岡県御殿場市印野1380-15にある樹上アクティビティ施設。トレックコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-gotemba/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・新城",
    "area": "愛知県",
    "category": "activity",
    "address": "愛知県新城市大海谷下66-1 新城総合公園内",
    "lat": 34.934366,
    "lng": 137.544329,
    "official_url": "https://foret-aventure.jp/park/fa-shinshiro/",
    "description": "愛知県新城市大海谷下66-1 新城総合公園内にある樹上アクティビティ施設。アドベンチャーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-shinshiro/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・米原",
    "area": "滋賀県",
    "category": "activity",
    "address": "滋賀県米原市池下80−1",
    "lat": 35.37430310100119,
    "lng": 136.35953644480915,
    "official_url": "https://foret-aventure.jp/park/fa-maibara/",
    "description": "滋賀県米原市池下80−1にある樹上アクティビティ施設。キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-maibara/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・奥神鍋",
    "area": "兵庫県",
    "category": "activity",
    "address": "兵庫県豊岡市日高町山田690",
    "lat": 35.504167,
    "lng": 134.653161,
    "official_url": "https://foret-aventure.jp/park/fa-okukannabe/",
    "description": "兵庫県豊岡市日高町山田690にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-okukannabe/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・丹波ささやま",
    "area": "兵庫県",
    "category": "activity",
    "address": "兵庫県丹波篠山市火打岩字畑山265-3",
    "lat": 35.130019,
    "lng": 135.256356,
    "official_url": "https://foret-aventure.jp/park/fa-tanbasasayama/",
    "description": "兵庫県丹波篠山市火打岩字畑山265-3にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-tanbasasayama/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・糸島",
    "area": "福岡県",
    "category": "activity",
    "address": "福岡県糸島市二丈一貴山312-390 樋の口ハイランド内",
    "lat": 33.4810603,
    "lng": 130.1577035,
    "official_url": "https://foret-aventure.jp/park/fa-itoshima/",
    "description": "福岡県糸島市二丈一貴山312-390 樋の口ハイランド内にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-itoshima/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・久山",
    "area": "福岡県",
    "category": "activity",
    "address": "福岡県糟屋郡久山町大字山田字塚﨑1226-1",
    "lat": 33.651206,
    "lng": 130.487915,
    "official_url": "https://foret-aventure.jp/park/fa-hisayama/",
    "description": "福岡県糟屋郡久山町大字山田字塚﨑1226-1にある樹上アクティビティ施設。トレックコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-hisayama/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・添田",
    "area": "福岡県",
    "category": "activity",
    "address": "福岡県田川郡添田町大字野田1288-3",
    "lat": 33.549054,
    "lng": 130.859867,
    "official_url": "https://foret-aventure.jp/park/fa-soeda/",
    "description": "福岡県田川郡添田町大字野田1288-3にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-soeda/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・奥日田",
    "area": "大分県",
    "category": "activity",
    "address": "大分県日田市中津江村合瀬3750",
    "lat": 33.129565,
    "lng": 130.880633,
    "official_url": "https://foret-aventure.jp/park/fa-okuhita/",
    "description": "大分県日田市中津江村合瀬3750にある樹上アクティビティ施設。アドベンチャーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-okuhita/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "フォレストアドベンチャー・おおすみ",
    "area": "鹿児島県",
    "category": "activity",
    "address": "鹿児島県曽於市大隅町岩川6048-1",
    "lat": 31.587965,
    "lng": 130.988709,
    "official_url": "https://foret-aventure.jp/park/fa-osumi/",
    "description": "鹿児島県曽於市大隅町岩川6048-1にある樹上アクティビティ施設。アドベンチャーコース・キャノピーコースを公式ページで案内しています。参加できる年齢・身長・同伴条件はコースごとに異なるため、予約前にご確認ください。",
    "source_urls": [
      "https://foret-aventure.jp/park/fa-osumi/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "天空SPA HILLS 竜泉寺の湯 名古屋守山本店",
    "area": "愛知県",
    "category": "ganbanyoku",
    "address": "愛知県名古屋市守山区竜泉寺1丁目1501番地",
    "lat": 35.22422666241071,
    "lng": 136.98576075049834,
    "official_url": "https://www.ryusenjinoyu.com/moriyama/",
    "description": "愛知県名古屋市守山区竜泉寺1丁目1501番地の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.ryusenjinoyu.com/moriyama/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "竜泉寺の湯 豊田浄水店",
    "area": "愛知県",
    "category": "ganbanyoku",
    "address": "愛知県豊田市浄水町四丁目17番地13",
    "lat": null,
    "lng": null,
    "official_url": "https://ryusenjinoyu.com/josui/",
    "description": "愛知県豊田市浄水町四丁目17番地13の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://ryusenjinoyu.com/josui/"
    ],
    "location_note": "地図の位置は未確認です。公式アクセス案内で入口と経路をご確認ください。"
  },
  {
    "name": "湘南RESORT SPA 竜泉寺の湯 湘南茅ヶ崎店",
    "area": "神奈川県",
    "category": "ganbanyoku",
    "address": "神奈川県茅ヶ崎市中島1339-1",
    "lat": 35.33092045661414,
    "lng": 139.3791477510719,
    "official_url": "https://ryusenjinoyu.com/chigasaki/",
    "description": "神奈川県茅ヶ崎市中島1339-1の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://www.ryusenjinoyu.com/chigasaki/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "横濱スパヒルズ 竜泉寺の湯",
    "area": "神奈川県",
    "category": "ganbanyoku",
    "address": "神奈川県横浜市旭区白根８丁目８",
    "lat": 35.49040234792377,
    "lng": 139.5482419511159,
    "official_url": "https://tsurugamine.ryusenjinoyu.com/",
    "description": "神奈川県横浜市旭区白根８丁目８の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://tsurugamine.ryusenjinoyu.com/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "竜泉寺の湯 八王子みなみ野店",
    "area": "東京都",
    "category": "ganbanyoku",
    "address": "東京都八王子市片倉町3505",
    "lat": 35.64070908475903,
    "lng": 139.3330055222699,
    "official_url": "https://hachioji.ryusenjinoyu.com/",
    "description": "東京都八王子市片倉町3505の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://ryusenjinoyu.com/hachioji/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "竜泉寺の湯 草加谷塚店",
    "area": "埼玉県",
    "category": "ganbanyoku",
    "address": "埼玉県草加市谷塚上町476",
    "lat": 35.81454652252445,
    "lng": 139.78577611145457,
    "official_url": "https://ryusenjinoyu.com/souka/",
    "description": "埼玉県草加市谷塚上町476の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://ryusenjinoyu.com/souka/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "スパメッツァおおたか 竜泉寺の湯",
    "area": "千葉県",
    "category": "ganbanyoku",
    "address": "千葉県流山市おおたかの森西一丁目15番1",
    "lat": 35.873230838847846,
    "lng": 139.9206728940645,
    "official_url": "https://www.ryusenjinoyu.com/spametsaotaka/",
    "description": "千葉県流山市おおたかの森西一丁目15番1の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://ryusenjinoyu.com/spametsaotaka/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
  },
  {
    "name": "スパメッツァ仙台 竜泉寺の湯",
    "area": "宮城県",
    "category": "ganbanyoku",
    "address": "宮城県仙台市泉区大沢2丁目5-9",
    "lat": 38.352985971845314,
    "lng": 140.87409717361027,
    "official_url": "https://ryusenjinoyu.com/spametsasendai/",
    "description": "宮城県仙台市泉区大沢2丁目5-9の温浴施設。岩盤浴エリアと入浴の利用案内を公式サイトに掲載しています。岩盤浴の追加料金・対象年齢・専用着の条件をご確認ください。休館日や設備点検による変更は、来館前に最新のお知らせをご確認ください。",
    "source_urls": [
      "https://ryusenjinoyu.com/spametsasendai/"
    ],
    "location_note": "地図は公式アクセス案内の代表地点です。入口や集合場所は公式サイトでご確認ください。"
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
                    'location_note' => $record['location_note'] ?? '地図の位置は公式案内に掲載された地図・現地写真の代表地点です。入口や集合場所は公式アクセス案内でご確認ください。',
                    'tags' => '[]', 'created_at' => now(), 'updated_at' => now(),
                ]));
                $added++;
            }
        });
        $this->command?->info("公式情報を確認した施設を{$added}件追加しました。");
    }
}
