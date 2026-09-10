<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Support\CapitalFacilities;
use App\Support\ApiVerifiedFacilities;
use App\Support\CityGuide;
use Database\Seeders\ApiVerifiedFacilitiesSeeder;
use Database\Seeders\CapitalFacilitiesSeeder;
use Database\Seeders\CityGuideSeeder;
use Database\Seeders\KansaiGuideSeeder;
use Database\Seeders\MetropolitanGuideSeeder;
use Database\Seeders\VerifiedWellnessSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CapitalFacilitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_capitals_have_real_facilities_and_52_area_pages_have_matching_lists_and_counts(): void
    {
        $this->seed([MetropolitanGuideSeeder::class, KansaiGuideSeeder::class, CityGuideSeeder::class, ApiVerifiedFacilitiesSeeder::class, CapitalFacilitiesSeeder::class]);
        $before = Spot::count();
        $this->seed(CapitalFacilitiesSeeder::class);
        $this->assertSame($before, Spot::count());
        $this->assertDatabaseCount('reviews', 0);
        $this->assertCount(47, CityGuide::capitals());
        $this->assertCount(47, array_unique(array_column(CityGuide::capitals(), 'area')));
        $this->assertCount(52, CityGuide::cities());
        $this->assertSame('新宿区', CityGuide::capitals()['shinjuku']['label']);
        foreach (CityGuide::designatedCities() as $slug => $metadata) {
            $this->assertSame($metadata, CityGuide::cities()[$slug]);
        }
        $index = $this->get('/cities')->assertOk()->assertSee('52エリア')->assertSee('新宿区');
        $guideSpot = Spot::whereNotNull('editorial_guide')->firstOrFail();
        foreach (['/cities', '/guides/metropolitan', '/guides/kansai', '/spots/'.$guideSpot->id] as $path) {
            $markup = $this->get($path)->assertOk()->getContent();
            preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $markup, $blocks);
            $this->assertNotEmpty($blocks[1]);
            foreach ($blocks[1] as $json) {
                $this->assertSame('https://schema.org', json_decode($json, true, 512, JSON_THROW_ON_ERROR)['@context'] ?? null);
                $this->assertStringNotContainsString('<?php', $json);
            }
        }
        $sitemap = $this->get('/sitemap.xml')->assertOk();
        $total = 0;
        foreach (CityGuide::cities() as $slug => $metadata) {
            $index->assertSee(route('cities.show', $slug), false);
            $sitemap->assertSee('/cities/'.$slug);
            $page = $this->get('/cities/'.$slug)->assertOk()->assertSee($metadata['label'].'から、');
            preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $page->getContent(), $schemas);
            $schema = collect($schemas[1])->map(fn ($s) => json_decode($s, true, 512, JSON_THROW_ON_ERROR))->firstWhere('@type', 'CollectionPage');
            foreach ($schemas[1] as $json) {
                $this->assertSame('https://schema.org', json_decode($json, true)['@context'] ?? null);
            }
            $items = $schema['mainEntity']['itemListElement'];
            $this->assertNotEmpty($items, $slug);
            $this->assertCount(count($items), array_unique(array_column($items, 'url')));
            $page->assertSee('掲載施設 '.count($items).'施設');
            $total += count($items);
            foreach ($items as $i => $item) {
                $this->assertSame($i+1, $item['position']);
                $page->assertSee($item['name']);
                $page->assertSee($item['url'], false);
            }
            // Every genre jump must lead to an actual element, with unique IDs.
            preg_match_all('/id="([^"]+)"/', $page->getContent(), $ids);
            $this->assertCount(count($ids[1]), array_unique($ids[1]), $slug);
            preg_match_all('/href="#([^"]+)"/', $page->getContent(), $anchors);
            foreach ($anchors[1] as $anchor) { $this->assertContains($anchor, $ids[1]); }
        }
        $index->assertSee($total.'施設');
        $this->assertCount(32, array_unique(array_column(CapitalFacilities::all(), 'city')));
        foreach (CapitalFacilities::all() as $record) {
            $city = CityGuide::capitals()[$record['city']];
            $this->assertStringStartsWith($city['area'].$city['label'], $record['address']);
            $this->assertContains($record['category'], CityGuide::CATEGORIES);
            $spot = Spot::where('name', $record['name'])->firstOrFail();
            $this->assertNull($spot->lat);
            $this->assertNull($spot->lng);
            $detail = $this->get('/spots/'.$spot->id)->assertOk()->assertSee($record['address'])->assertSee('id="write-review"', false)->assertSee('2026年09月10日');
            foreach ($record['source_urls'] as $url) { $detail->assertSee($url); }
        }
        $this->get('/cities/shinjuku')->assertDontSee('スパ ラクーア');
    }

    public function test_reimport_preserves_existing_reviews_and_user_fields(): void
    {
        $first = CapitalFacilities::all()[0];
        $spot = Spot::create(['name'=>'利用者が登録した名称', 'area'=>$first['area'], 'category'=>$first['category'], 'official_url'=>$first['official_url'].'?from=existing', 'description'=>'残す紹介', 'likes_count'=>3]);
        $spot->reviews()->create(['nickname'=>'訪問者', 'rating'=>4, 'comment'=>'残す体験記', 'ip_hash'=>'test']);
        $before = $spot->fresh()->getAttributes();
        $this->seed(CapitalFacilitiesSeeder::class);
        $this->seed(CapitalFacilitiesSeeder::class);
        $this->assertEquals($before, $spot->fresh()->getAttributes());
        $this->assertDatabaseCount('spots', count(CapitalFacilities::all()));
        $this->assertDatabaseCount('reviews', 1);
        $this->get('/cities/'.$first['city'])->assertOk()->assertSee('利用者が登録した名称');
        $this->get('/spots/'.$spot->id)->assertOk()->assertSee('公式情報で確認した利用案内')->assertSee($first['address'])->assertSee($first['description'])->assertSee('残す紹介');
    }

    public function test_catalog_merges_with_the_existing_national_wellness_catalog_without_duplicates(): void
    {
        $this->seed([VerifiedWellnessSeeder::class, MetropolitanGuideSeeder::class, KansaiGuideSeeder::class, CityGuideSeeder::class, ApiVerifiedFacilitiesSeeder::class, CapitalFacilitiesSeeder::class]);
        $spots = Spot::all();
        foreach (CapitalFacilities::all() as $record) {
            $matches = $spots->filter(fn ($spot) => ApiVerifiedFacilities::matches($spot, $record));
            $this->assertCount(1, $matches, $record['name']);
            $this->get('/cities/'.$record['city'])->assertOk()->assertSee(route('spots.show', $matches->first()), false);
        }
    }
}
