<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Support\ApiVerifiedFacilities;
use App\Support\CityGuide;
use Database\Seeders\ApiVerifiedFacilitiesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiVerifiedFacilitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_reviewed_catalog_is_balanced_repeatable_and_visible_in_all_twenty_cities(): void
    {
        $this->seed(ApiVerifiedFacilitiesSeeder::class);
        $this->seed(ApiVerifiedFacilitiesSeeder::class);
        $this->assertDatabaseCount('spots', 36);
        $this->assertDatabaseCount('reviews', 0);
        foreach (CityGuide::CATEGORIES as $category) {
            $this->assertSame(6, Spot::where('category', $category)->count());
        }
        foreach (ApiVerifiedFacilities::all() as $record) {
            $city = CityGuide::cities()[$record['city']];
            $this->assertStringStartsWith($city['area'].$city['label'], $record['address']);
            $spot = Spot::where('name', $record['name'])->firstOrFail();
            $this->assertNull($spot->lat);
            $this->assertNull($spot->lng);
            $this->assertSame(0, $spot->likes_count);
            $this->assertNotEmpty($spot->source_urls);
            $this->get('/spots/'.$spot->id)->assertOk()->assertSee($spot->address)->assertSee('2026年09月10日');
        }
        foreach (array_keys(CityGuide::designatedCities()) as $city) {
            $response = $this->get('/cities/'.$city)->assertOk()->assertSee('このエリアで見つかる施設');
            foreach (collect(ApiVerifiedFacilities::all())->where('city', $city) as $record) {
                $response->assertSee($record['name']);
            }
        }
    }

    public function test_url_variants_do_not_duplicate_or_overwrite_existing_user_content(): void
    {
        $spot = Spot::create(['name' => '利用者が登録した施設名', 'area' => '神奈川県', 'category' => 'glamping', 'official_url' => 'http://www.hibiya-stay.com/relax/?utm_source=existing', 'description' => '保存する体験情報', 'booking_url' => 'https://example.com/booking', 'likes_count' => 5]);
        $spot->reviews()->create(['nickname' => '訪問者', 'rating' => 4, 'comment' => '実際に訪れた感想', 'ip_hash' => 'test']);
        $this->seed(ApiVerifiedFacilitiesSeeder::class);
        $this->assertDatabaseCount('spots', 36);
        $this->assertDatabaseCount('reviews', 1);
        $this->assertDatabaseHas('spots', ['id' => $spot->id, 'description' => '保存する体験情報', 'booking_url' => 'https://example.com/booking', 'likes_count' => 5]);
        $this->assertNull($spot->fresh()->source_checked_at);
        $this->get('/cities/sagamihara')->assertOk()->assertSee('利用者が登録した施設名');
    }
}
