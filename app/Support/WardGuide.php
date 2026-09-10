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
    ];

    public static function wards(string $metro): array
    {
        return match ($metro) {
            'tokyo' => ['chiyoda'=>'千代田区','chuo'=>'中央区','minato'=>'港区','shinjuku'=>'新宿区','bunkyo'=>'文京区','taito'=>'台東区','sumida'=>'墨田区','koto'=>'江東区','shinagawa'=>'品川区','meguro'=>'目黒区','ota'=>'大田区','setagaya'=>'世田谷区','shibuya'=>'渋谷区','nakano'=>'中野区','suginami'=>'杉並区','toshima'=>'豊島区','kita'=>'北区','arakawa'=>'荒川区','itabashi'=>'板橋区','nerima'=>'練馬区','adachi'=>'足立区','katsushika'=>'葛飾区','edogawa'=>'江戸川区'],
            'osaka' => ['kita'=>'北区','miyakojima'=>'都島区','fukushima'=>'福島区','konohana'=>'此花区','chuo'=>'中央区','nishi'=>'西区','minato'=>'港区','taisho'=>'大正区','tennoji'=>'天王寺区','naniwa'=>'浪速区','nishiyodogawa'=>'西淀川区','yodogawa'=>'淀川区','higashiyodogawa'=>'東淀川区','higashinari'=>'東成区','ikuno'=>'生野区','asahi'=>'旭区','joto'=>'城東区','tsurumi'=>'鶴見区','abeno'=>'阿倍野区','suminoe'=>'住之江区','sumiyoshi'=>'住吉区','higashisumiyoshi'=>'東住吉区','hirano'=>'平野区','nishinari'=>'西成区'],
            'nagoya' => ['chikusa'=>'千種区','higashi'=>'東区','kita'=>'北区','nishi'=>'西区','nakamura'=>'中村区','naka'=>'中区','showa'=>'昭和区','mizuho'=>'瑞穂区','atsuta'=>'熱田区','nakagawa'=>'中川区','minato'=>'港区','minami'=>'南区','moriyama'=>'守山区','midori'=>'緑区','meito'=>'名東区','tempaku'=>'天白区'],
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

    public static function groups(): Collection
    {
        $records = array_merge(ApiVerifiedFacilities::all(), CapitalFacilities::all());
        $groups = collect();
        foreach (Spot::whereIn('area', array_column(self::METROS, 'area'))->orderBy('name')->get() as $spot) {
            $address = $spot->address;
            if (! $address) {
                foreach ($records as $record) {
                    if (ApiVerifiedFacilities::matches($spot, $record)) { $address = $record['address']; break; }
                }
            }
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
