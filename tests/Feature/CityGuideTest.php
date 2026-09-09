<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Support\CityGuide;
use App\Support\RegionalGuide;
use Database\Seeders\CityGuideSeeder;
use Database\Seeders\KansaiGuideSeeder;
use Database\Seeders\MetropolitanGuideSeeder;
use Database\Seeders\VerifiedWellnessSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityGuideTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_twenty_cities_have_sourced_guides_navigation_and_matching_structured_lists(): void
    {
        $this->seed([MetropolitanGuideSeeder::class, KansaiGuideSeeder::class, CityGuideSeeder::class]);
        $this->assertDatabaseCount('spots', 59);
        $this->assertCount(20, CityGuide::cities());
        $index = $this->get('/cities')->assertOk()->assertSee('40施設');
        $sitemap = $this->get('/sitemap.xml')->assertOk();
        $categories = array_fill_keys(CityGuide::CATEGORIES, 0);
        $keys = [];
        foreach (CityGuide::cities() as $slug => $city) {
            $index->assertSee(route('cities.show', $slug), false);
            $sitemap->assertSee('/cities/'.$slug);
            $guides = CityGuide::forCity($slug);
            $page = $this->get('/cities/'.$slug)->assertOk()->assertSee($city['label'].'から、');
            preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $page->getContent(), $schemas);
            $collection = collect($schemas[1])->map(fn ($s) => json_decode($s, true, 512, JSON_THROW_ON_ERROR))->firstWhere('@type', 'CollectionPage');
            $this->assertCount(count($guides), $collection['mainEntity']['itemListElement']);
            foreach ($guides as $key => $guide) {
                $this->assertNotContains($key, $keys);
                $keys[] = $key;
                $categories[$guide['category']]++;
                $spot = Spot::where('editorial_guide', $key)->firstOrFail();
                $page->assertSee(route('spots.show', $spot).'#official-guide', false);
                $page->assertSee($guide['address'])->assertSee($guide['price']);
                $this->assertStringContainsString($guide['municipality'], $guide['address']);
                $this->assertSame($guide['municipality'] === $city['label'] ? 'city' : 'nearby', $guide['scope']);
                $this->assertGreaterThanOrEqual(4, count($guide['facts']));
                $detail = $this->get('/spots/'.$spot->id)->assertOk()->assertSee('FAQPage')->assertSee('id="write-review"', false);
                foreach ($guide['sources'] as $source) {
                    $this->assertSame('https', parse_url($source['url'], PHP_URL_SCHEME));
                    $detail->assertSee($source['url']);
                }
            }
        }
        $this->assertCount(40, $keys);
        $this->assertLessThanOrEqual(2, max($categories)-min($categories));
        $this->assertDatabaseCount('reviews', 0);
        $this->get('/cities/unknown')->assertNotFound();
        $this->get('/cities/tokyo')->assertNotFound();
        $this->get('/')->assertOk()->assertSee('/cities');
    }

    public function test_import_is_idempotent_and_preserves_existing_content_and_reviews(): void
    {
        $this->seed([VerifiedWellnessSeeder::class, MetropolitanGuideSeeder::class, KansaiGuideSeeder::class]);
        $existing = Spot::where('name', 'like', '%スパメッツァ仙台%')->firstOrFail();
        $existing->update(['description'=>'利用者が書いた紹介', 'likes_count'=>9, 'booking_url'=>'https://example.com/booking']);
        $existing->reviews()->create(['nickname'=>'利用者','rating'=>4,'comment'=>'訪問時の感想です。','ip_hash'=>'test']);
        $before = $existing->fresh()->getAttributes();
        $this->seed(CityGuideSeeder::class);
        $count = Spot::count();
        $this->seed(CityGuideSeeder::class);
        $this->assertSame($count, Spot::count());
        $this->assertSame('spametsa-sendai', $existing->fresh()->editorial_guide);
        $after = $existing->fresh()->getAttributes();
        unset($before['editorial_guide'], $after['editorial_guide']);
        $this->assertEquals($before, $after);
        $this->assertDatabaseCount('reviews', 1);
        $this->assertSame(59, Spot::whereNotNull('editorial_guide')->count());
        $this->assertSame('cities', RegionalGuide::forSpot($existing->fresh())['region']);
        $this->get('/spots/'.$existing->id)->assertOk()->assertSee('/cities/sendai');
    }

    public function test_nearby_and_day_only_conditions_are_visible_without_false_city_claims(): void
    {
        $this->get('/cities/niigata')->assertOk()->assertSee('市外の近郊候補')->assertSee('阿賀野市');
        $this->get('/cities/kyoto')->assertOk()->assertSee('南丹市');
        $this->get('/cities/hiroshima')->assertOk()->assertSee('呉市');
        $this->get('/cities/saitama')->assertOk()->assertSee('宿泊ではなく')->assertSee('1区画1,500円');
        $this->get('/cities/sendai')->assertOk()->assertSee('1,900円')->assertSee('岩盤浴だけの利用はできません');
        $this->get('/cities/nagoya')->assertOk()->assertSee('2026年10月から料金改定');
    }
}
