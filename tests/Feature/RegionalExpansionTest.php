<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Support\RegionalGuide;
use Database\Seeders\KansaiGuideSeeder;
use Database\Seeders\MetropolitanGuideSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionalExpansionTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_genre_has_two_sourced_facilities_with_working_navigation_and_schema(): void
    {
        $this->seed([MetropolitanGuideSeeder::class, KansaiGuideSeeder::class]);
        $this->assertDatabaseCount('spots', 24);
        $keys = [];
        foreach (array_keys(RegionalGuide::REGIONS) as $region) {
            $catalog = RegionalGuide::all($region);
            $groups = collect($catalog)->groupBy('category');
            $this->assertCount(12, $catalog);
            $this->assertCount(6, $groups);
            $page = $this->get('/guides/'.$region)->assertOk()->assertSee('掲載12施設');
            foreach ($groups as $category => $records) {
                $this->assertCount(2, $records);
                $page->assertSee('href="#genre-'.$category.'"', false)->assertSee('id="genre-'.$category.'"', false);
            }
            preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $page->getContent(), $matches);
            $collection = collect($matches[1])->map(fn ($json) => json_decode($json, true, 512, JSON_THROW_ON_ERROR))->firstWhere('@type', 'CollectionPage');
            $this->assertCount(12, $collection['mainEntity']['itemListElement']);
            foreach ($catalog as $key => $guide) {
                $this->assertNotContains($key, $keys);
                $keys[] = $key;
                $this->assertNotEmpty($guide['address']);
                $this->assertNotEmpty($guide['sources']);
                $this->assertGreaterThanOrEqual(4, count($guide['facts']));
                foreach ($guide['sources'] as $source) {
                    $this->assertSame('https', parse_url($source['url'], PHP_URL_SCHEME));
                }
                $page->assertSee('id="'.$key.'"', false)->assertSee($guide['checked_at']);
                $spot = Spot::where('editorial_guide', $key)->firstOrFail();
                $this->get('/spots/'.$spot->id)->assertOk()->assertSee('id="write-review"', false);
            }
        }
        $this->assertDatabaseCount('reviews', 0);
        $metro = RegionalGuide::all('metropolitan');
        $kansai = RegionalGuide::all('kansai');
        $this->assertStringContainsString('ロッカー690円', $metro['manyo-machida']['facts']['入浴のみ']);
        $this->assertStringContainsString('木曜定休', $metro['hikawa-camp']['facts']['予約・休業']);
        $this->assertStringContainsString('2,800円', $kansai['tomogashima-camp']['price']);
        $this->assertStringContainsString('宿泊総額ではありません', $kansai['tomogashima-camp']['price_condition']);
        $this->assertStringContainsString('1人利用', $kansai['gr-awaji']['facts']['宿泊条件']);
    }
}
