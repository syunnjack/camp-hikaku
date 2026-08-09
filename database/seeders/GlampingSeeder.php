<?php

namespace Database\Seeders;

use App\Models\Spot;
use Illuminate\Database\Seeder;

/**
 * Seeds real, well-known Japanese glamping facilities spread across all
 * regions of Japan, using the same Spot schema and idempotent firstOrCreate
 * approach as CampSeeder. Sourced via manual research (public listing sites)
 * and geocoded with the OpenStreetMap Nominatim API.
 *
 * Same honesty rule as CampSeeder: only real, verifiable static facts are
 * seeded (name / description / area / coordinates / category / editorial
 * tags). congestion_reports, average_congestion, and likes_count are left at
 * their defaults because those represent real-time user-submitted data.
 *
 * Idempotent: firstOrCreate keyed on [name, area].
 */
class GlampingSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->spots() as $spot) {
            Spot::firstOrCreate(
                ['name' => $spot['name'], 'area' => $spot['area']],
                [
                    'description' => $spot['description'],
                    'category' => 'glamping',
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
            ['name' => '温泉グランピング小樽はなえみ', 'area' => '北海道', 'lat' => 43.1906806, 'lng' => 140.9946021, 'tags' => ['couple', 'family'],
                'description' => '小樽市にある温泉付きグランピング施設。冷暖房完備のドームで北海道食材のBBQを楽しめる。'],
            ['name' => '星野リゾート トマム グランピングドーム', 'area' => '北海道', 'lat' => 43.0670538, 'lng' => 142.6218083, 'tags' => ['family', 'couple'],
                'description' => '占冠村、星野リゾート トマム内にあるグランピングドーム施設。'],
            ['name' => 'スパリゾートハワイアンズ グランピングドーム', 'area' => '福島県', 'lat' => 36.9931068, 'lng' => 140.8157191, 'tags' => ['family', 'couple'],
                'description' => 'いわき市のスパリゾートハワイアンズ内にあるグランピング施設。'],
            ['name' => 'ルーラグラン山形', 'area' => '山形県', 'lat' => 38.0550810, 'lng' => 140.1481134, 'tags' => ['couple', 'family'],
                'description' => '南陽市赤湯温泉エリアにある、山形県内で先駆けとなった温泉付きグランピング施設。'],
            ['name' => 'グランピングヴィレッジ茨城', 'area' => '茨城県', 'lat' => 36.8018507, 'lng' => 140.7513188, 'tags' => ['family', 'couple'],
                'description' => '北茨城市にあるグランピング施設。大型ドームテントとグランピングトレーラーを備える。'],
            ['name' => 'ノーラ名栗', 'area' => '埼玉県', 'lat' => 35.8730286, 'lng' => 139.1751608, 'tags' => ['couple', 'friends', 'solo'],
                'description' => '飯能市名栗地区にある北欧文化をテーマにしたアウトドア・グランピング施設。テントサウナも利用できる。'],
            ['name' => 'THE BASE GLAMPING湯河原', 'area' => '神奈川県', 'lat' => 35.1479182, 'lng' => 139.1081530, 'tags' => ['couple'],
                'description' => '足柄下郡湯河原町にある全棟貸切タイプの温泉付きグランピング施設。'],
            ['name' => '高滝湖グランピングリゾート', 'area' => '千葉県', 'lat' => 35.3493654, 'lng' => 140.1570382, 'tags' => ['family', 'friends'],
                'description' => '市原市、高滝湖畔にあるグランピングリゾート。廃校をリノベーションした施設。'],
            ['name' => '星のや富士', 'area' => '山梨県', 'lat' => 35.5253129, 'lng' => 138.7451346, 'tags' => ['couple'],
                'description' => '富士河口湖町にある、グランピングをコンセプトにした星野リゾートの宿泊施設。富士山の眺望が特徴。'],
            ['name' => 'GLAMPROOK飯綱高原', 'area' => '長野県', 'lat' => 36.7056753, 'lng' => 138.1414208, 'tags' => ['couple', 'family'],
                'description' => '長野市飯綱高原、湖のほとりにあるグランピング施設。'],
            ['name' => 'シオサイテラス', 'area' => '和歌山県', 'lat' => 33.6781748, 'lng' => 135.3479399, 'tags' => ['couple'],
                'description' => '西牟婁郡白浜町の高台にあるグランピング施設。白浜の眺望を一望できる。'],
            ['name' => '琵琶湖ドギーズグランピング今津浜', 'area' => '滋賀県', 'lat' => 35.4184397, 'lng' => 136.0461994, 'tags' => ['family', 'friends'],
                'description' => '高島市今津浜、琵琶湖畔にある愛犬同伴可能なグランピング施設。各棟に専用ドッグランを完備。'],
            ['name' => '温井ダムリゾート グランピング', 'area' => '広島県', 'lat' => 34.6338987, 'lng' => 132.2992536, 'tags' => ['family', 'friends'],
                'description' => '安芸太田町、温井ダム湖畔にある愛犬同伴可能なグランピング施設。'],
            ['name' => 'こしかの温泉グランピング', 'area' => '鹿児島県', 'lat' => 31.7486620, 'lng' => 130.3311864, 'tags' => ['couple', 'solo'],
                'description' => 'いちき串木野市にある温泉・サウナ付きグランピング施設。'],
            ['name' => 'WESPA椿山', 'area' => '高知県', 'lat' => 33.7633143, 'lng' => 134.0311236, 'tags' => ['family', 'friends'],
                'description' => '香美市、べふ峡温泉エリアにあるグランピング・アウトドア複合施設。'],
            ['name' => 'GCTVグラマラスキャンプトワイライトヴィレッジ', 'area' => '香川県', 'lat' => 34.1986856, 'lng' => 133.7179334, 'tags' => ['couple', 'friends'],
                'description' => '三豊市、荘内半島にある瀬戸内海沿いのグランピング施設。'],
            ['name' => 'glampark つるぎの湯大桜', 'area' => '徳島県', 'lat' => 34.0373324, 'lng' => 134.0640279, 'tags' => ['couple'],
                'description' => '美馬郡つるぎ町、剣山系に囲まれた1日1組限定のドーム型グランピング施設。'],
            ['name' => 'WAKKAしまなみ', 'area' => '愛媛県', 'lat' => 34.2454272, 'lng' => 133.0228810, 'tags' => ['couple', 'family'],
                'description' => '今治市大三島、しまなみ海道沿いにあるグランピング施設。全室オーシャンビュー。'],
            ['name' => '瀬底Ocean Terrace', 'area' => '沖縄県', 'lat' => 26.6414360, 'lng' => 127.8640559, 'tags' => ['family', 'friends', 'couple'],
                'description' => '本部町瀬底島にある、ドームテント＆キャビン全16棟の沖縄最大級グランピングリゾート。'],
            ['name' => 'グランドーム福岡ふくつ', 'area' => '福岡県', 'lat' => 33.7668264, 'lng' => 130.4913329, 'tags' => ['family', 'couple'],
                'description' => '福津市にあるドーム型グランピング施設。'],
        ];
    }
}
