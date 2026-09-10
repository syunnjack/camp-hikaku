<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Support\WardGuide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WardGuideTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_194_wards_have_routes_and_empty_pages_are_honest_and_noindex(): void
    {
        $this->assertCount(21, WardGuide::METROS);
        $national = $this->get('/wards')->assertOk()->assertSee('全国194区');
        $this->assertSame(194, array_sum(array_map(fn($metro)=>count(WardGuide::wards($metro)), array_keys(WardGuide::METROS))));
        foreach (array_keys(\App\Support\CityGuide::designatedCities()) as $city) {
            $this->assertArrayHasKey($city, WardGuide::METROS);
            $this->get('/cities/'.$city)->assertOk()->assertSee(route('wards.index',$city), false);
        }
        $sitemap = $this->get('/sitemap.xml')->assertOk();
        foreach (WardGuide::METROS as $metro=>$info) {
            $index = $this->get('/wards/'.$metro)->assertOk();
            $national->assertSee(route('wards.index',$metro),false);
            $sitemap->assertSee(route('wards.index',$metro), false);
            foreach (WardGuide::wards($metro) as $ward=>$label) {
                $index->assertSee(route('wards.show',[$metro,$ward]), false)->assertSee($label);
                $page = $this->get('/wards/'.$metro.'/'.$ward)->assertOk()->assertSee('noindex,follow', false)->assertSee($label.'の施設は、まだ掲載されていません。');
                $sitemap->assertDontSee(route('wards.show',[$metro,$ward]), false);
                preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $page->getContent(), $schemas);
                foreach ($schemas[1] as $json) { $this->assertSame('https://schema.org', json_decode($json,true,512,JSON_THROW_ON_ERROR)['@context']); }
            }
        }
        foreach (['/wards/not-a-city','/wards/osaka/shinjuku','/wards/nagoya/naniwa','/wards/tokyo/unknown'] as $path) { $this->get($path)->assertNotFound(); }
        $this->get('/cities')->assertOk()->assertSee('/wards/tokyo')->assertSee('/wards/osaka')->assertSee('/wards/nagoya');
    }

    private function makeSpot(array $attributes): Spot
    {
        $spot = new Spot();
        $spot->forceFill($attributes)->save();
        return $spot;
    }

    public function test_real_addresses_determine_ward_and_counts_schema_sitemap_and_detail_links_agree(): void
    {
        $attributes = ['category'=>'spa', 'name'=>'東京のスパ','area'=>'東京都','address'=>'〒105-0001 東京都港区虎ノ門1-1'];
        $tokyo = $this->makeSpot($attributes);
        $osaka = $this->makeSpot(array_merge($attributes,['name'=>'大阪のスパ','area'=>'大阪府','address'=>'大阪市港区弁天1-1']));
        $nagoya = $this->makeSpot(array_merge($attributes,['name'=>'名古屋のスパ','area'=>'愛知県','address'=>'愛知県名古屋市港区港町1-1']));
        $this->makeSpot(array_merge($attributes,['name'=>'堺市の施設','area'=>'大阪府','address'=>'大阪府堺市北区金岡町1']));
        $this->makeSpot(array_merge($attributes,['name'=>'市の不明な施設','area'=>'大阪府','address'=>'大阪府北区1']));
        $this->makeSpot(array_merge($attributes,['name'=>'区の不明な施設','address'=>null]));
        $sitemap=$this->get('/sitemap.xml')->assertOk();
        foreach (['tokyo'=>$tokyo,'osaka'=>$osaka,'nagoya'=>$nagoya] as $metro=>$spot) {
            $page=$this->get('/wards/'.$metro.'/minato')->assertOk()->assertSee($spot->name)->assertSee('掲載施設 1件')->assertDontSee('noindex,follow',false);
            preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s',$page->getContent(),$schemas);
            $schema=collect($schemas[1])->map(fn($j)=>json_decode($j,true))->firstWhere('@type','CollectionPage');
            $this->assertSame([['@type'=>'ListItem','position'=>1,'name'=>$spot->name,'url'=>route('spots.show',$spot)]],$schema['mainEntity']['itemListElement']);
            $sitemap->assertSee(route('wards.show',[$metro,'minato']),false);
            $this->get('/wards/'.$metro)->assertOk()->assertSee('施設を1件掲載');
            $this->get('/spots/'.$spot->id)->assertOk()->assertSee(route('wards.show',[$metro,'minato']),false);
        }
        $this->get('/wards/osaka/kita')->assertDontSee('堺市の施設')->assertDontSee('市の不明な施設');
        $this->get('/wards/tokyo/minato')->assertDontSee('大阪のスパ')->assertDontSee('名古屋のスパ')->assertDontSee('区の不明な施設');
        $this->assertSame(['metro'=>'nagoya','ward'=>'nakagawa','label'=>'中川区'],WardGuide::locate('愛知県','愛知県名古屋市中川区1'));
        $this->assertSame(['metro'=>'osaka','ward'=>'higashisumiyoshi','label'=>'東住吉区'],WardGuide::locate('大阪府','大阪市東住吉区1'));
        $this->assertNull(WardGuide::locate('東京都','東京都八王子市港区という施設名'));
    }

    public function test_current_hamamatsu_wards_and_editorial_address_fallback_preserve_stored_records(): void
    {
        $this->assertSame(['chuo'=>'中央区','hamana'=>'浜名区','tenryu'=>'天竜区'], WardGuide::wards('hamamatsu'));
        $this->assertNull(WardGuide::locate('静岡県','浜松市北区三方原町1'));
        $this->assertSame('chuo', WardGuide::locate('静岡県','浜松市中央区三方原町1')['ward']);
        $this->assertSame('hamana', WardGuide::locate('静岡県','浜松市浜名区細江町1')['ward']);
        $this->assertSame('shimizu', WardGuide::locate('静岡県','静岡市清水区1')['ward']);
        $this->assertSame('saiwai', WardGuide::locate('神奈川県','川崎市幸区1')['ward']);
        $this->assertSame('midori', WardGuide::locate('神奈川県','相模原市緑区1')['ward']);
        $spot = $this->makeSpot(['name'=>'既存の紹介を保持する施設','area'=>'北海道','category'=>'glamping','description'=>'利用者が登録した紹介','editorial_guide'=>'quope']);
        $before = $spot->fresh()->getAttributes();
        $this->get('/wards/sapporo/nishi')->assertOk()->assertSee($spot->name)->assertSee('北海道札幌市西区小別沢49');
        $this->get('/spots/'.$spot->id)->assertOk()->assertSee('/wards/sapporo/nishi');
        $this->assertSame($before,$spot->fresh()->getAttributes());
        $this->get('/wards/hamamatsu/kita')->assertNotFound();
    }
}
