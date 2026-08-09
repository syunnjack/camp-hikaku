<?php

namespace Database\Seeders;

use App\Models\Spot;
use Illuminate\Database\Seeder;

/**
 * Seeds real, well-known Japanese campgrounds spread across all regions of
 * Japan (Hokkaido through Okinawa) so the nationwide map is populated with
 * genuine locations rather than showing an empty state.
 *
 * Only verifiable static facts are seeded: name, a short factual description,
 * a prefecture-level `area` label, and coordinates geocoded via the OpenStreetMap
 * Nominatim API. `congestion_reports`, `average_congestion`, and `likes_count`
 * are intentionally left at their defaults (null / 0) because those fields
 * represent real-time user-submitted data that must never be fabricated.
 *
 * Idempotent: uses firstOrCreate keyed on [name, area], so re-running this
 * seeder (e.g. after a fresh deploy) will not create duplicate rows.
 */
class CampSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->spots() as $spot) {
            Spot::firstOrCreate(
                ['name' => $spot['name'], 'area' => $spot['area']],
                [
                    'description' => $spot['description'],
                    'category' => 'campground',
                    'tags' => $spot['tags'],
                    'lat' => $spot['lat'],
                    'lng' => $spot['lng'],
                ]
            );
        }
    }

    private function spots(): array
    {
        return [
            // Hokkaido
            ['name' => '支笏湖美笛キャンプ場', 'area' => '北海道', 'lat' => 42.7315098, 'lng' => 141.2639554, 'tags' => ['family', 'friends'],
                'description' => '支笏湖畔、天然林に囲まれたキャンプ場。湖畔沿いのフリーテントサイトから支笏湖の眺望を楽しめる。'],
            ['name' => 'モラップキャンプ場', 'area' => '北海道', 'lat' => 42.7444129, 'lng' => 141.4086720, 'tags' => ['family', 'friends'],
                'description' => '支笏湖畔のキャンプ場。初心者でも利用しやすい設備が整い、近隣の温泉施設も利用できる。'],
            ['name' => '然別湖北岸野営場', 'area' => '北海道', 'lat' => 43.2815389, 'lng' => 143.1167518, 'tags' => ['solo', 'friends'],
                'description' => '北海道内で最も標高の高い場所にある湖、然別湖の北岸にある野営場。'],

            // Tohoku
            ['name' => '大間崎キャンプ場', 'area' => '青森県', 'lat' => 41.5464894, 'lng' => 140.9129659, 'tags' => ['solo', 'friends'],
                'description' => '本州最北端・大間崎にあるキャンプ場。津軽海峡を望む岬に位置する。'],
            ['name' => '網張温泉キャンプ場', 'area' => '岩手県', 'lat' => 39.8149116, 'lng' => 140.9348358, 'tags' => ['friends', 'solo'],
                'description' => '岩手山麓、網張温泉エリアにあるキャンプ場。登山の拠点としても利用される。'],
            ['name' => 'みやぎ蔵王きららの森キャンプ場', 'area' => '宮城県', 'lat' => 38.1777164, 'lng' => 140.6430953, 'tags' => ['family', 'friends'],
                'description' => '蔵王連峰南麓に広がるキャンプ場。コテージ、オートサイト、フリーサイトを備える。'],
            ['name' => 'とことん山キャンプ場', 'area' => '秋田県', 'lat' => 39.0124352, 'lng' => 140.6576245, 'tags' => ['family', 'friends'],
                'description' => '秋田県湯沢市にある通年営業のキャンプ場。'],
            ['name' => '小野川湖畔の家キャンプ場', 'area' => '山形県', 'lat' => 37.9218342, 'lng' => 140.1161931, 'tags' => ['family', 'couple'],
                'description' => '米沢市小野川温泉近くにあるキャンプ場。'],
            ['name' => 'フォレストパークあだたら', 'area' => '福島県', 'lat' => 37.5815445, 'lng' => 140.3286937, 'tags' => ['family', 'friends'],
                'description' => '「ふくしま県民の森」内にある、日本オートキャンプ協会5つ星認定のオートキャンプ場。'],
            ['name' => '休暇村裏磐梯キャンプ場', 'area' => '福島県', 'lat' => 37.6647356, 'lng' => 140.0435291, 'tags' => ['family', 'couple'],
                'description' => '磐梯朝日国立公園内、裏磐梯エリアにある休暇村直営のキャンプ場。'],

            // Kanto
            ['name' => 'キャンプ&キャビンズ那須高原', 'area' => '栃木県', 'lat' => 37.0747053, 'lng' => 140.0052522, 'tags' => ['family', 'couple'],
                'description' => '那須高原にある高規格キャンプ場。'],
            ['name' => '北軽井沢スウィートグラス', 'area' => '群馬県', 'lat' => 36.4699306, 'lng' => 138.5337357, 'tags' => ['family', 'friends'],
                'description' => '浅間山麓・北軽井沢エリアにある人気の高規格キャンプ場。'],
            ['name' => '長瀞オートキャンプ場', 'area' => '埼玉県', 'lat' => 36.1048648, 'lng' => 139.1139403, 'tags' => ['family', 'friends'],
                'description' => '荒川沿い、長瀞にあるオートキャンプ場。'],
            ['name' => '氷川キャンプ場', 'area' => '東京都', 'lat' => 35.8069144, 'lng' => 139.0995634, 'tags' => ['family', 'friends', 'solo'],
                'description' => '奥多摩町、多摩川沿いにある東京都内のキャンプ場。'],
            ['name' => '大子グリンヴィラ', 'area' => '茨城県', 'lat' => 36.7647755, 'lng' => 140.3639606, 'tags' => ['family', 'friends'],
                'description' => '茨城県大子町にあるキャンプ場。'],
            ['name' => 'PICAさがみ湖', 'area' => '神奈川県', 'lat' => 35.6042341, 'lng' => 139.2078206, 'tags' => ['family', 'couple'],
                'description' => '相模湖畔、さがみ湖リゾート内にあるキャンプ施設。'],
            ['name' => '成田ゆめ牧場ファミリーオートキャンプ場', 'area' => '千葉県', 'lat' => 35.7268876, 'lng' => 140.3430548, 'tags' => ['family'],
                'description' => '千葉県富里市の観光牧場「成田ゆめ牧場」内にあるファミリー向けオートキャンプ場。'],

            // Chubu
            ['name' => 'ふもとっぱら', 'area' => '静岡県', 'lat' => 35.3985153, 'lng' => 138.5659069, 'tags' => ['family', 'friends', 'solo'],
                'description' => '富士宮市にある、富士山を望む広大な草原のキャンプ場。フリーサイトが中心。'],
            ['name' => 'PICA富士西湖', 'area' => '山梨県', 'lat' => 35.4985177, 'lng' => 138.6853744, 'tags' => ['family', 'couple'],
                'description' => '富士五湖の一つ、西湖畔にあるキャンプ施設。'],
            ['name' => '戸隠キャンプ場', 'area' => '長野県', 'lat' => 36.7423126, 'lng' => 138.0833548, 'tags' => ['family', 'friends'],
                'description' => '長野市戸隠、戸隠連峰を望む高原のキャンプ場。全サイトフリーサイト。'],
            ['name' => '大源太キャニオンキャンプ場', 'area' => '新潟県', 'lat' => 36.9179207, 'lng' => 138.8906201, 'tags' => ['family', 'friends'],
                'description' => '「越後のマッターホルン」と呼ばれる大源太山の麓、湯沢町にあるキャンプ場。'],
            ['name' => '立山山麓家族旅行村', 'area' => '富山県', 'lat' => 36.5745115, 'lng' => 137.4338647, 'tags' => ['family'],
                'description' => '立山連峰の山麓、富山市にある宿泊・キャンプ施設。'],
            ['name' => '白山永井キャンプ場', 'area' => '石川県', 'lat' => 36.5143504, 'lng' => 136.5658067, 'tags' => ['friends', 'solo'],
                'description' => '白山市の白山麓エリアにあるキャンプ場。'],
            ['name' => '九頭竜元橋キャンプ場', 'area' => '福井県', 'lat' => 35.9044816, 'lng' => 136.6615446, 'tags' => ['friends', 'solo'],
                'description' => '九頭竜湖近く、大野市にあるキャンプ場。'],
            ['name' => 'ホワイトピア高鷲オートキャンプ場', 'area' => '岐阜県', 'lat' => 35.9466812, 'lng' => 136.8782737, 'tags' => ['family', 'friends'],
                'description' => '郡上市高鷲町、スキー場に隣接するオートキャンプ場。'],
            ['name' => '茶臼山高原キャンプ場', 'area' => '愛知県', 'lat' => 35.2230075, 'lng' => 137.6588121, 'tags' => ['family', 'friends'],
                'description' => '愛知県最高峰・茶臼山の麓、豊根村にある高原キャンプ場。'],

            // Kansai
            ['name' => '志摩オートキャンプ場', 'area' => '三重県', 'lat' => 34.3411841, 'lng' => 136.8196451, 'tags' => ['family', 'friends'],
                'description' => '三重県志摩市、伊勢志摩国立公園エリアにあるオートキャンプ場。'],
            ['name' => '朽木オートキャンプ場', 'area' => '滋賀県', 'lat' => 35.3476793, 'lng' => 135.9153162, 'tags' => ['family', 'friends'],
                'description' => '高島市朽木、安曇川沿いにあるオートキャンプ場。'],
            ['name' => '笠置キャンプ場', 'area' => '京都府', 'lat' => 34.7590176, 'lng' => 135.9357301, 'tags' => ['friends', 'solo'],
                'description' => '木津川沿い、笠置町にあるキャンプ場。'],
            ['name' => 'スノーピーク箕面キャンプフィールド', 'area' => '大阪府', 'lat' => 34.8269554, 'lng' => 135.4704617, 'tags' => ['solo', 'couple', 'friends'],
                'description' => '大阪府箕面市にある、アウトドアブランド運営のキャンプフィールド。'],
            ['name' => '淡路じゃのひれオートキャンプ場', 'area' => '兵庫県', 'lat' => 34.5855364, 'lng' => 135.0028858, 'tags' => ['family', 'couple'],
                'description' => '淡路島北部・岩屋にあるオートキャンプ場&コテージ。'],
            ['name' => '天の川青少年旅行村', 'area' => '奈良県', 'lat' => 34.2191315, 'lng' => 135.8584089, 'tags' => ['family', 'friends'],
                'description' => '奈良県天川村、天の川沿いにあるキャンプ場。'],
            ['name' => '川湯野営場木魂の里', 'area' => '和歌山県', 'lat' => 33.8163184, 'lng' => 135.7800323, 'tags' => ['friends', 'solo'],
                'description' => '田辺市、川湯温泉近くにあるキャンプ場。'],

            // Chugoku
            ['name' => '桝水高原キャンプ場', 'area' => '鳥取県', 'lat' => 35.5107190, 'lng' => 133.4961180, 'tags' => ['family', 'friends'],
                'description' => '大山北麓、桝水高原にあるキャンプ場。'],
            ['name' => '島根県立石見海浜公園オートキャンプ場', 'area' => '島根県', 'lat' => 34.9497155, 'lng' => 132.1238324, 'tags' => ['family', 'friends'],
                'description' => '浜田市の海浜公園内にある県営オートキャンプ場。'],
            ['name' => '休暇村蒜山高原キャンプ場', 'area' => '岡山県', 'lat' => 35.2944506, 'lng' => 133.6311544, 'tags' => ['family', 'couple'],
                'description' => '真庭市蒜山高原にある休暇村直営のキャンプ場。'],
            ['name' => '国営備北丘陵公園備北オートビレッジ', 'area' => '広島県', 'lat' => 34.8395801, 'lng' => 132.9966590, 'tags' => ['family', 'friends'],
                'description' => '庄原市の国営備北丘陵公園内、日本オートキャンプ協会5つ星認定のキャンプ場。'],
            ['name' => '長野山緑地公園キャンプ場', 'area' => '山口県', 'lat' => 34.0550595, 'lng' => 131.8064092, 'tags' => ['solo', 'friends'],
                'description' => '周南市、標高約1000mに位置する中国地方屈指の高地キャンプ場。'],

            // Shikoku
            ['name' => '四国山岳植物園岳人の森', 'area' => '徳島県', 'lat' => 34.0259698, 'lng' => 133.8071758, 'tags' => ['solo', 'friends'],
                'description' => '三好市、土須峠付近、標高約1000mの山岳植物園内にあるキャンプ場。'],
            ['name' => '国営讃岐まんのう公園キャンプ場', 'area' => '香川県', 'lat' => 34.1660823, 'lng' => 133.8846662, 'tags' => ['family', 'friends'],
                'description' => 'まんのう町の国営公園内にあるキャンプ場。'],
            ['name' => '大角海浜公園キャンプ場', 'area' => '愛媛県', 'lat' => 34.1406092, 'lng' => 132.9416435, 'tags' => ['family', 'friends'],
                'description' => '今治市、愛媛県最北端の砂浜に面したキャンプ場。'],
            ['name' => '中津渓谷キャンプ場', 'area' => '高知県', 'lat' => 33.5609988, 'lng' => 133.1297313, 'tags' => ['friends', 'solo'],
                'description' => '仁淀川支流・中津渓谷沿いにあるキャンプ場。'],

            // Kyushu
            ['name' => '大野城市いこいの森キャンプ場', 'area' => '福岡県', 'lat' => 33.5362390, 'lng' => 130.4786580, 'tags' => ['family', 'friends'],
                'description' => '福岡県大野城市にある市営のキャンプ場。'],
            ['name' => '波戸岬キャンプ場', 'area' => '佐賀県', 'lat' => 33.5552756, 'lng' => 129.8465907, 'tags' => ['family', 'friends'],
                'description' => '唐津市、玄界灘に突き出た波戸岬にある県営キャンプ場。'],
            ['name' => '雲仙お山の情報館オートキャンプ場', 'area' => '長崎県', 'lat' => 32.8351500, 'lng' => 130.1877200, 'tags' => ['family', 'friends'],
                'description' => '雲仙市、雲仙国立公園内にあるオートキャンプ場。'],
            ['name' => '南阿蘇あぐりキャンプ場', 'area' => '熊本県', 'lat' => 32.8469382, 'lng' => 131.0325835, 'tags' => ['family', 'friends'],
                'description' => '阿蘇郡南阿蘇村にあるキャンプ場。'],
            ['name' => '長崎鼻リゾートキャンプ場', 'area' => '大分県', 'lat' => 33.6832748, 'lng' => 131.5226874, 'tags' => ['family', 'couple'],
                'description' => '豊後高田市、国東半島にある絶景キャンプ場。花公園が隣接する。'],
            ['name' => 'オートキャンプ場in高千穂', 'area' => '宮崎県', 'lat' => 32.7117310, 'lng' => 131.3076492, 'tags' => ['family', 'friends'],
                'description' => '高千穂町、高千穂峡近くにあるオートキャンプ場。'],
            ['name' => '霧島高原国民休養地', 'area' => '鹿児島県', 'lat' => 31.7410148, 'lng' => 130.7632406, 'tags' => ['family', 'friends'],
                'description' => '霧島市、霧島連山の麓にある国民休養地キャンプ場。'],

            // Okinawa
            ['name' => '沖縄県総合運動公園オートキャンプ場', 'area' => '沖縄県', 'lat' => 26.3086014, 'lng' => 127.8211176, 'tags' => ['family', 'friends'],
                'description' => '沖縄市泡瀬、沖縄県総合運動公園内にあるオートキャンプ場。'],
            ['name' => '屋我地ビーチ', 'area' => '沖縄県', 'lat' => 26.6621465, 'lng' => 128.0109963, 'tags' => ['family', 'friends', 'couple'],
                'description' => '名護市屋我地島にあるビーチキャンプ場。芝生サイトから海を望める。'],
        ];
    }
}
