<?php

namespace Tests\Feature;

use App\Models\Spot;
use Database\Seeders\VerifiedWellnessSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifiedWellnessTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_is_repeatable_and_each_genre_has_two_real_records(): void
    {
        $this->seed(VerifiedWellnessSeeder::class);
        $this->seed(VerifiedWellnessSeeder::class);
        $this->assertDatabaseCount('spots', 8);
        $this->assertDatabaseCount('reviews', 0);
        foreach (['activity','ganbanyoku','healing','spa'] as $category) {
            $this->assertSame(2, Spot::where('category', $category)->count());
            $this->get('/categories/'.$category)->assertOk()->assertDontSee('この条件の施設は、まだありません。');
        }
        foreach (Spot::all() as $spot) {
            $this->assertNotEmpty($spot->address);
            $this->assertNotEmpty($spot->source_urls);
            $this->assertSame('2026-09-08', $spot->source_checked_at->format('Y-m-d'));
            $this->assertSame(0, $spot->likes_count);
            $this->assertNull($spot->average_congestion);
            $this->get('/spots/'.$spot->id)->assertOk()->assertSee($spot->address)->assertSee('施設情報の出典・確認日')->assertDontSee('利用者登録・運営未確認');
        }
    }

    public function test_import_preserves_existing_content_and_reviews(): void
    {
        $spot = Spot::create(['name'=>'スパ ラクーア','area'=>'東京都','category'=>'spa','description'=>'利用者が更新した情報','lat'=>35.7,'lng'=>139.7,'likes_count'=>7]);
        $spot->reviews()->create(['nickname'=>'訪問者','rating'=>4,'comment'=>'実際の体験記です。','ip_hash'=>'test']);
        $this->seed(VerifiedWellnessSeeder::class);
        $this->assertDatabaseCount('spots', 8);
        $this->assertDatabaseHas('spots',['id'=>$spot->id,'description'=>'利用者が更新した情報','likes_count'=>7]);
        $this->assertDatabaseCount('reviews', 1);
    }

    public function test_public_submission_cannot_claim_editorial_verification(): void
    {
        $this->post('/spots',['name'=>'新規施設','lat'=>35,'lng'=>139,'category'=>'spa','source_checked_at'=>'2026-09-08','source_urls'=>['https://example.com']])->assertRedirect();
        $this->assertNull(Spot::first()->source_checked_at);
        $this->assertNull(Spot::first()->source_urls);
    }
}
