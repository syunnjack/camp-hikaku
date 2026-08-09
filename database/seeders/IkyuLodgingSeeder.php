<?php

namespace Database\Seeders;

use App\Models\Spot;
use Illuminate\Database\Seeder;

/**
 * Seeds real, verified glamping/luxury-outdoor-stay properties listed on
 * 一休.com (Ikyu), found via a live search of ikyu.com's own "おすすめの
 * グランピング" listings and confirmed with a direct HTTP 200 check on each
 * property's real ikyu.com page before being added here.
 *
 * Affiliate link caveat: the user's ValueCommerce Ikyu tag (sid=3771711,
 * pid=892676008) was curl-verified to NOT honor a vc_url deep-link param —
 * it always redirects to the generic ikyu.com homepage regardless of what
 * target URL is passed. So `booking_url` here is the real, verified,
 * non-affiliate ikyu.com property page (for readers to actually reach the
 * right listing), and the affiliate tag itself is surfaced separately as a
 * site-wide "一休.comで宿泊施設を探す" banner CTA (see IKYU_BANNER_URL usage
 * in the layout/index view), not attached to individual property links.
 *
 * Same honesty rule as CampSeeder/GlampingSeeder: only real, verified
 * listings; congestion_reports/average_congestion/likes_count left at
 * defaults. Idempotent via firstOrCreate keyed on [name, area].
 */
class IkyuLodgingSeeder extends Seeder
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
                    'booking_url' => $spot['url'],
                    'booking_provider' => 'ikyu',
                ]
            );
        }
    }

    private function spots(): array
    {
        return [
            ['name' => '五氣里', 'area' => '千葉県', 'lat' => 35.2539394, 'lng' => 140.3849461, 'tags' => ['couple'],
                'url' => 'https://www.ikyu.com/00003154/',
                'description' => 'いすみ市にある一休.com掲載の高級グランピング施設。食事付きプランが中心。'],
            ['name' => '小谷流の里 ドギーズアイランド', 'area' => '千葉県', 'lat' => 35.2847921, 'lng' => 140.2452603, 'tags' => ['couple', 'family'],
                'url' => 'https://www.ikyu.com/00002166/',
                'description' => '大多喜町にある一休.com掲載のグランピング施設。愛犬同伴プランがある。'],
            ['name' => '蒼の湖邸 BIWAFRONT HIKONE', 'area' => '滋賀県', 'lat' => 35.2744066, 'lng' => 136.2596539, 'tags' => ['couple'],
                'url' => 'https://www.ikyu.com/00003100/',
                'description' => '彦根市、琵琶湖畔にある一休.com掲載の高級ヴィラ・グランピング施設。'],
            ['name' => 'あさま空山望', 'area' => '群馬県', 'lat' => 36.5437713, 'lng' => 138.6499599, 'tags' => ['couple', 'family'],
                'url' => 'https://www.ikyu.com/00051122/',
                'description' => '北軽井沢にある一休.com掲載のグランピング施設。浅間山を望む立地。'],
            ['name' => 'エンゼルフォレスト白河高原', 'area' => '福島県', 'lat' => 37.1416581, 'lng' => 140.1553467, 'tags' => ['family', 'couple'],
                'url' => 'https://www.ikyu.com/00030708/',
                'description' => '西郷村、白河高原にある一休.com掲載のグランピング施設。'],
            ['name' => 'ビーチテラス房総', 'area' => '千葉県', 'lat' => 35.3039146, 'lng' => 139.8570499, 'tags' => ['couple'],
                'url' => 'https://www.ikyu.com/00051942/',
                'description' => '富津市の海辺にある一休.com掲載の高級グランピング施設。'],
            ['name' => 'GLAMPROOK しまなみ', 'area' => '愛媛県', 'lat' => 34.0658182, 'lng' => 132.9976758, 'tags' => ['couple', 'friends'],
                'url' => 'https://www.ikyu.com/00051289/',
                'description' => '今治市、しまなみ海道の島にある一休.com掲載のグランピング施設。'],
            ['name' => 'ラビスタ横須賀観音崎テラス', 'area' => '神奈川県', 'lat' => 35.2612864, 'lng' => 139.7378269, 'tags' => ['couple', 'family'],
                'url' => 'https://www.ikyu.com/00003128/',
                'description' => '横須賀市、観音崎にある一休.com掲載のグランピング・ホテル施設。'],
            ['name' => 'GLAMPROOK 飯綱高原', 'area' => '長野県', 'lat' => 36.7545299, 'lng' => 138.2355784, 'tags' => ['couple', 'family'],
                'url' => 'https://www.ikyu.com/00051077/',
                'description' => '飯綱町、湖畔にある一休.com掲載のグランピング施設。'],
            ['name' => 'キャメルホテルリゾート', 'area' => '千葉県', 'lat' => 35.0387486, 'lng' => 139.8371399, 'tags' => ['couple', 'family'],
                'url' => 'https://www.ikyu.com/00001932/',
                'description' => '南房総市にある一休.com掲載のグランピング・ホテル施設。'],
            ['name' => 'おごと温泉 びわこ緑水亭', 'area' => '滋賀県', 'lat' => 35.0177852, 'lng' => 135.8548122, 'tags' => ['couple'],
                'url' => 'https://www.ikyu.com/00002098/',
                'description' => '大津市おごと温泉にある一休.com掲載の温泉旅館・グランピング施設。'],
            ['name' => 'クリスタルヴィラ白浜', 'area' => '和歌山県', 'lat' => 33.6781748, 'lng' => 135.3479399, 'tags' => ['couple'],
                'url' => 'https://www.ikyu.com/00050738/',
                'description' => '白浜町にある一休.com掲載の高級ヴィラ・グランピング施設。'],
            ['name' => 'MOROISOSO', 'area' => '神奈川県', 'lat' => 35.1441984, 'lng' => 139.6207589, 'tags' => ['couple'],
                'url' => 'https://www.ikyu.com/00051364/',
                'description' => '三浦市にあるサウナ・温水プール付き一休.com掲載のラグジュアリーヴィラ。'],
            ['name' => '志摩グリーンアドベンチャーグランピングフィールド', 'area' => '三重県', 'lat' => 34.3605431, 'lng' => 136.8450926, 'tags' => ['family', 'friends'],
                'url' => 'https://www.ikyu.com/00031268/',
                'description' => '志摩市にある一休.com掲載のグランピング施設。'],
            ['name' => '藤乃煌 富士御殿場', 'area' => '静岡県', 'lat' => 35.3087530, 'lng' => 138.9349133, 'tags' => ['couple', 'family'],
                'url' => 'https://www.ikyu.com/00050429/',
                'description' => '御殿場市、富士山を望む一休.com掲載のグランピング施設。'],
            ['name' => 'クリスタルヴィラ白浜オーシャンズドッグリゾート', 'area' => '和歌山県', 'lat' => 33.6781748, 'lng' => 135.3479399, 'tags' => ['couple', 'family'],
                'url' => 'https://www.ikyu.com/00052283/',
                'description' => '白浜町にある一休.com掲載の愛犬同伴グランピング施設。'],
            ['name' => 'ASOBIYUKU 京都るり渓温泉HANARE/VILLA', 'area' => '京都府', 'lat' => 35.0329958, 'lng' => 135.3979101, 'tags' => ['couple'],
                'url' => 'https://www.ikyu.com/00050427/',
                'description' => '南丹市るり渓にある一休.com掲載の温泉付きグランピング施設。'],
            ['name' => '天空の温泉ヴィラ紬 河口湖', 'area' => '山梨県', 'lat' => 35.5130603, 'lng' => 138.7448243, 'tags' => ['couple'],
                'url' => 'https://www.ikyu.com/00051940/',
                'description' => '富士河口湖町にある一休.com掲載の高級ヴィラ・グランピング施設。'],
            ['name' => 'Snow Peak FIELD SUITE HAKUBA KITAONE KOGEN', 'area' => '長野県', 'lat' => 36.6981042, 'lng' => 137.8620680, 'tags' => ['couple', 'family'],
                'url' => 'https://www.ikyu.com/00050627/',
                'description' => '白馬村にあるスノーピーク監修の一休.com掲載グランピング施設。'],
            ['name' => '西伊豆グランピング 天空テラス', 'area' => '静岡県', 'lat' => 34.9718480, 'lng' => 138.7793000, 'tags' => ['couple'],
                'url' => 'https://www.ikyu.com/00031064/',
                'description' => '沼津市西伊豆エリアにある一休.com掲載のグランピング施設。'],
        ];
    }
}
