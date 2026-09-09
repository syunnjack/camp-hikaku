<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Support\RegionalGuide;
use Database\Seeders\KansaiGuideSeeder;
use Database\Seeders\MetropolitanGuideSeeder;
use Database\Seeders\VerifiedWellnessSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KansaiGuideTest extends TestCase
{
    use RefreshDatabase;

    public function test_kansai_preserves_existing_facilities_and_both_regions_remain_separate(): void
    {
        $this->seed(VerifiedWellnessSeeder::class);
        $kasagi = Spot::create(['name'=>'笠置キャンプ場','area'=>'京都府','category'=>'campground','description'=>'既存の紹介','lat'=>35,'lng'=>135,'booking_url'=>'https://example.com/book','likes_count'=>8]);
        $kasagi->reviews()->create(['nickname'=>'利用者','rating'=>4,'comment'=>'現地での体験記です。','ip_hash'=>'test']);
        $before = $kasagi->fresh()->getAttributes();
        $this->seed(MetropolitanGuideSeeder::class);
        $count = Spot::count();
        $this->seed(KansaiGuideSeeder::class);
        $this->seed(KansaiGuideSeeder::class);
        $this->assertSame($count + 3, Spot::count());
        $after = $kasagi->fresh()->getAttributes();
        unset($before['editorial_guide'], $after['editorial_guide']);
        $this->assertEquals($before, $after);
        $this->assertDatabaseCount('reviews', 1);
        $this->assertSame(12, Spot::whereNotNull('editorial_guide')->count());
        foreach (['metropolitan','kansai'] as $region) {
            $catalog = RegionalGuide::all($region);
            $index = $this->get('/guides/'.$region)->assertOk()->assertSee('aria-current="page"', false);
            $other = $region === 'kansai' ? 'THE FARM' : 'とれとれの湯';
            $index->assertDontSee($other);
            foreach ($catalog as $key => $guide) {
                $spot = Spot::where('editorial_guide', $key)->firstOrFail();
                $index->assertSee(route('spots.show', $spot).'#official-guide', false);
                $page = $this->get('/spots/'.$spot->id)->assertOk()->assertSee($guide['price'])->assertSee($guide['checked_at']);
                $page->assertSee(RegionalGuide::REGIONS[$region]['label'].'の6ジャンルを比較する');
                $this->assertSame($region, RegionalGuide::forSpot($spot)['region']);
                foreach ($guide['sources'] as $source) {
                    $page->assertSee($source['url']);
                }
            }
        }
        $this->get('/sitemap.xml')->assertOk()->assertSee('/guides/kansai')->assertSee('/guides/metropolitan');
        $this->get('/')->assertOk()->assertSee('関西ガイド');
    }

    public function test_catalog_covers_six_genres_and_six_prefectures_without_old_prices(): void
    {
        $catalog = RegionalGuide::all('kansai');
        $this->assertCount(6, array_unique(array_column($catalog, 'category')));
        $this->assertCount(6, array_unique(array_column($catalog, 'area')));
        $this->seed(KansaiGuideSeeder::class);
        $this->get('/guides/kansai')->assertOk()->assertSee('料金改定の告知あり')->assertSee('料金・開催日は主催窓口へ確認')->assertDontSee('5,050円');
        $this->get('/guides/unknown')->assertNotFound();
    }

    public function test_import_refuses_to_replace_a_different_editorial_assignment(): void
    {
        $spot = Spot::create(['name'=>'笠置キャンプ場','area'=>'京都府','lat'=>35,'lng'=>135]);
        $spot->forceFill(['editorial_guide'=>'other-editorial-record'])->save();
        try {
            $this->seed(KansaiGuideSeeder::class);
            $this->fail('An existing assignment must not be overwritten.');
        } catch (\RuntimeException $e) {
            $this->assertStringContainsString('既存の編集情報', $e->getMessage());
        }
        $this->assertDatabaseCount('spots', 1);
        $this->assertSame('other-editorial-record', $spot->fresh()->editorial_guide);
    }
}
