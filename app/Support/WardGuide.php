<?php

namespace App\Support;

use App\Models\Spot;
use Illuminate\Support\Collection;

class WardGuide
{
    public const METROS = [
        'tokyo' => ['label'=>'東京23区', 'area'=>'東京都', 'municipality'=>'', 'source'=>'https://www.gikai.metro.tokyo.lg.jp/link/ward_municipality.html'],
        'osaka' => ['label'=>'大阪市', 'area'=>'大阪府', 'municipality'=>'大阪市', 'source'=>'https://www.city.osaka.lg.jp/main/soshiki_list.html'],
        'nagoya' => ['label'=>'名古屋市', 'area'=>'愛知県', 'municipality'=>'名古屋市', 'source'=>'https://www.city.nagoya.jp/shisei/gaiyou/1015754/1015781/index.html'],
        'sapporo' => ['label'=>'札幌市', 'area'=>'北海道', 'municipality'=>'札幌市', 'source'=>'https://www.city.sapporo.jp/'],
        'sendai' => ['label'=>'仙台市', 'area'=>'宮城県', 'municipality'=>'仙台市', 'source'=>'https://www.city.sendai.jp/'],
        'saitama' => ['label'=>'さいたま市', 'area'=>'埼玉県', 'municipality'=>'さいたま市', 'source'=>'https://www.city.saitama.lg.jp/'],
        'chiba' => ['label'=>'千葉市', 'area'=>'千葉県', 'municipality'=>'千葉市', 'source'=>'https://www.city.chiba.jp/'],
        'yokohama' => ['label'=>'横浜市', 'area'=>'神奈川県', 'municipality'=>'横浜市', 'source'=>'https://www.city.yokohama.lg.jp/'],
        'kawasaki' => ['label'=>'川崎市', 'area'=>'神奈川県', 'municipality'=>'川崎市', 'source'=>'https://www.city.kawasaki.jp/'],
        'sagamihara' => ['label'=>'相模原市', 'area'=>'神奈川県', 'municipality'=>'相模原市', 'source'=>'https://www.city.sagamihara.kanagawa.jp/'],
        'niigata' => ['label'=>'新潟市', 'area'=>'新潟県', 'municipality'=>'新潟市', 'source'=>'https://www.city.niigata.lg.jp/'],
        'shizuoka' => ['label'=>'静岡市', 'area'=>'静岡県', 'municipality'=>'静岡市', 'source'=>'https://www.city.shizuoka.lg.jp/'],
        'hamamatsu' => ['label'=>'浜松市', 'area'=>'静岡県', 'municipality'=>'浜松市', 'source'=>'https://www.city.hamamatsu.shizuoka.jp/shise/gaiyo/gyoseku/index.html'],
        'kyoto' => ['label'=>'京都市', 'area'=>'京都府', 'municipality'=>'京都市', 'source'=>'https://www.city.kyoto.lg.jp/'],
        'sakai' => ['label'=>'堺市', 'area'=>'大阪府', 'municipality'=>'堺市', 'source'=>'https://www.city.sakai.lg.jp/'],
        'kobe' => ['label'=>'神戸市', 'area'=>'兵庫県', 'municipality'=>'神戸市', 'source'=>'https://www.city.kobe.lg.jp/'],
        'okayama' => ['label'=>'岡山市', 'area'=>'岡山県', 'municipality'=>'岡山市', 'source'=>'https://www.city.okayama.jp/'],
        'hiroshima' => ['label'=>'広島市', 'area'=>'広島県', 'municipality'=>'広島市', 'source'=>'https://www.city.hiroshima.lg.jp/'],
        'kitakyushu' => ['label'=>'北九州市', 'area'=>'福岡県', 'municipality'=>'北九州市', 'source'=>'https://www.city.kitakyushu.lg.jp/'],
        'fukuoka' => ['label'=>'福岡市', 'area'=>'福岡県', 'municipality'=>'福岡市', 'source'=>'https://www.city.fukuoka.lg.jp/'],
        'kumamoto' => ['label'=>'熊本市', 'area'=>'熊本県', 'municipality'=>'熊本市', 'source'=>'https://www.city.kumamoto.jp/'],
    ];

    public static function wards(string $metro): array
    {
        return match ($metro) {
            'tokyo' => ['chiyoda'=>'千代田区','chuo'=>'中央区','minato'=>'港区','shinjuku'=>'新宿区','bunkyo'=>'文京区','taito'=>'台東区','sumida'=>'墨田区','koto'=>'江東区','shinagawa'=>'品川区','meguro'=>'目黒区','ota'=>'大田区','setagaya'=>'世田谷区','shibuya'=>'渋谷区','nakano'=>'中野区','suginami'=>'杉並区','toshima'=>'豊島区','kita'=>'北区','arakawa'=>'荒川区','itabashi'=>'板橋区','nerima'=>'練馬区','adachi'=>'足立区','katsushika'=>'葛飾区','edogawa'=>'江戸川区'],
            'osaka' => ['kita'=>'北区','miyakojima'=>'都島区','fukushima'=>'福島区','konohana'=>'此花区','chuo'=>'中央区','nishi'=>'西区','minato'=>'港区','taisho'=>'大正区','tennoji'=>'天王寺区','naniwa'=>'浪速区','nishiyodogawa'=>'西淀川区','yodogawa'=>'淀川区','higashiyodogawa'=>'東淀川区','higashinari'=>'東成区','ikuno'=>'生野区','asahi'=>'旭区','joto'=>'城東区','tsurumi'=>'鶴見区','abeno'=>'阿倍野区','suminoe'=>'住之江区','sumiyoshi'=>'住吉区','higashisumiyoshi'=>'東住吉区','hirano'=>'平野区','nishinari'=>'西成区'],
            'nagoya' => ['chikusa'=>'千種区','higashi'=>'東区','kita'=>'北区','nishi'=>'西区','nakamura'=>'中村区','naka'=>'中区','showa'=>'昭和区','mizuho'=>'瑞穂区','atsuta'=>'熱田区','nakagawa'=>'中川区','minato'=>'港区','minami'=>'南区','moriyama'=>'守山区','midori'=>'緑区','meito'=>'名東区','tempaku'=>'天白区'],
            'sapporo' => ['chuo'=>'中央区','kita'=>'北区','higashi'=>'東区','shiroishi'=>'白石区','toyohira'=>'豊平区','minami'=>'南区','nishi'=>'西区','atsubetsu'=>'厚別区','teine'=>'手稲区','kiyota'=>'清田区'],
            'sendai' => ['aoba'=>'青葉区','miyagino'=>'宮城野区','wakabayashi'=>'若林区','taihaku'=>'太白区','izumi'=>'泉区'],
            'saitama' => ['nishi'=>'西区','kita'=>'北区','omiya'=>'大宮区','minuma'=>'見沼区','chuo'=>'中央区','sakura'=>'桜区','urawa'=>'浦和区','minami'=>'南区','midori'=>'緑区','iwatsuki'=>'岩槻区'],
            'chiba' => ['chuo'=>'中央区','hanamigawa'=>'花見川区','inage'=>'稲毛区','wakaba'=>'若葉区','midori'=>'緑区','mihama'=>'美浜区'],
            'yokohama' => ['tsurumi'=>'鶴見区','kanagawa'=>'神奈川区','nishi'=>'西区','naka'=>'中区','minami'=>'南区','konan'=>'港南区','hodogaya'=>'保土ケ谷区','asahi'=>'旭区','isogo'=>'磯子区','kanazawa'=>'金沢区','kohoku'=>'港北区','midori'=>'緑区','aoba'=>'青葉区','tsuzuki'=>'都筑区','totsuka'=>'戸塚区','sakae'=>'栄区','izumi'=>'泉区','seya'=>'瀬谷区'],
            'kawasaki' => ['kawasaki'=>'川崎区','saiwai'=>'幸区','nakahara'=>'中原区','takatsu'=>'高津区','miyamae'=>'宮前区','tama'=>'多摩区','asao'=>'麻生区'],
            'sagamihara' => ['midori'=>'緑区','chuo'=>'中央区','minami'=>'南区'],
            'niigata' => ['kita'=>'北区','higashi'=>'東区','chuo'=>'中央区','konan'=>'江南区','akiha'=>'秋葉区','minami'=>'南区','nishi'=>'西区','nishikan'=>'西蒲区'],
            'shizuoka' => ['aoi'=>'葵区','suruga'=>'駿河区','shimizu'=>'清水区'],
            'hamamatsu' => ['chuo'=>'中央区','hamana'=>'浜名区','tenryu'=>'天竜区'],
            'kyoto' => ['kita'=>'北区','kamigyo'=>'上京区','sakyo'=>'左京区','nakagyo'=>'中京区','higashiyama'=>'東山区','shimogyo'=>'下京区','minami'=>'南区','ukyo'=>'右京区','fushimi'=>'伏見区','yamashina'=>'山科区','nishikyo'=>'西京区'],
            'sakai' => ['sakai'=>'堺区','naka'=>'中区','higashi'=>'東区','nishi'=>'西区','minami'=>'南区','kita'=>'北区','mihara'=>'美原区'],
            'kobe' => ['higashinada'=>'東灘区','nada'=>'灘区','chuo'=>'中央区','hyogo'=>'兵庫区','kita'=>'北区','nagata'=>'長田区','suma'=>'須磨区','tarumi'=>'垂水区','nishi'=>'西区'],
            'okayama' => ['kita'=>'北区','naka'=>'中区','higashi'=>'東区','minami'=>'南区'],
            'hiroshima' => ['naka'=>'中区','higashi'=>'東区','minami'=>'南区','nishi'=>'西区','asaminami'=>'安佐南区','asakita'=>'安佐北区','aki'=>'安芸区','saeki'=>'佐伯区'],
            'kitakyushu' => ['moji'=>'門司区','kokurakita'=>'小倉北区','kokuraminami'=>'小倉南区','wakamatsu'=>'若松区','yahatahigashi'=>'八幡東区','yahatanishi'=>'八幡西区','tobata'=>'戸畑区'],
            'fukuoka' => ['higashi'=>'東区','hakata'=>'博多区','chuo'=>'中央区','minami'=>'南区','jonan'=>'城南区','sawara'=>'早良区','nishi'=>'西区'],
            'kumamoto' => ['chuo'=>'中央区','higashi'=>'東区','nishi'=>'西区','minami'=>'南区','kita'=>'北区'],
            default => [],
        };
    }

    public static function locate(string $area, ?string $address): ?array
    {
        if (! $address) { return null; }
        $address = preg_replace('/[\s　]+/u', '', mb_convert_kana($address, 'asKV'));
        $address = preg_replace('/^〒?\d{3}[-−]?\d{4}/u', '', $address);
        foreach (self::METROS as $metro => $info) {
            if ($area !== $info['area']) { continue; }
            if (str_starts_with($address, $area)) { $address = substr($address, strlen($area)); }
            foreach (self::wards($metro) as $slug => $label) {
                if (str_starts_with($address, $info['municipality'].$label)) {
                    return ['metro'=>$metro, 'ward'=>$slug, 'label'=>$label];
                }
            }
        }
        return null;
    }

    public static function addressForSpot(Spot $spot): ?string
    {
        if ($spot->address) { return $spot->address; }
        $guide = RegionalGuide::forSpot($spot);
        if ($guide) { return $guide['address']; }
        foreach (array_merge(ApiVerifiedFacilities::all(), CapitalFacilities::all()) as $record) {
            if (ApiVerifiedFacilities::matches($spot, $record)) { return $record['address']; }
        }
        return null;
    }

    public static function groups(): Collection
    {
        $groups = collect();
        foreach (Spot::whereIn('area', array_column(self::METROS, 'area'))->orderBy('name')->get() as $spot) {
            $address = self::addressForSpot($spot);
            $location = self::locate($spot->area, $address);
            if (! $location) { continue; }
            $key = $location['metro'].'/'.$location['ward'];
            if (! $groups->has($key)) { $groups->put($key, collect()); }
            // Display fallback provenance without overwriting user-owned fields in the database.
            $spot->setAttribute('ward_address', $address);
            $groups->get($key)->push($spot);
        }
        return $groups;
    }
}
