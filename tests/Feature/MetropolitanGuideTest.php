<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Support\MetropolitanGuide;
use Database\Seeders\MetropolitanGuideSeeder;
use Database\Seeders\VerifiedWellnessSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MetropolitanGuideTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_enriches_existing_spots_without_touching_reviews(): void
    {
        $this->seed(VerifiedWellnessSeeder::class);
        $spot = Spot::where('name', 'スパ ラクーア')->firstOrFail();
        $spot->update(['description'=>'訪問者が登録した紹介', 'likes_count'=>7, 'booking_url'=>'https://example.com/booking']);
        $spot->reviews()->create(['nickname'=>'訪問者','rating'=>4,'comment'=>'実際の訪問記録です。','ip_hash'=>'test']);
        $before = $spot->fresh()->getAttributes();
        $this->seed(MetropolitanGuideSeeder::class);
        $this->seed(MetropolitanGuideSeeder::class);
        $this->assertDatabaseCount('spots', 162);
        $this->assertDatabaseCount('reviews', 1);
        $after = $spot->fresh()->getAttributes();
        unset($before['editorial_guide'], $after['editorial_guide']);
        $this->assertSame($before, $after);
        $this->assertSame(12, Spot::whereNotNull('editorial_guide')->count());
    }

    public function test_guide_links_to_all_rendered_details_with_matching_faq_data(): void
    {
        $this->seed(MetropolitanGuideSeeder::class);
        $index = $this->get('/guides/metropolitan')->assertOk()->assertSee('掲載12施設');
        foreach (Spot::all() as $spot) {
            $guide = MetropolitanGuide::forSpot($spot);
            $index->assertSee(route('spots.show', $spot).'#official-guide', false);
            $page = $this->get('/spots/'.$spot->id)->assertOk()->assertSee('料金・予約・利用条件')->assertSee($guide['price'])->assertSee($guide['checked_at']);
            preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $page->getContent(), $matches);
            $faqFound = false;
            foreach ($matches[1] as $json) {
                $schema = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
                if (($schema['@type'] ?? '') === 'FAQPage') {
                    $faqFound = true;
                    foreach ($schema['mainEntity'] as $question) {
                        $page->assertSee($question['name'])->assertSee($question['acceptedAnswer']['text']);
                    }
                }
            }
            $this->assertTrue($faqFound);
        }
        $this->get('/sitemap.xml')->assertOk()->assertSee('/guides/metropolitan');
    }

    public function test_public_submission_cannot_attach_an_editorial_guide(): void
    {
        $this->post('/spots', ['name'=>'一般投稿の施設','lat'=>35,'lng'=>139,'category'=>'spa','editorial_guide'=>'laqua'])->assertRedirect();
        $spot = Spot::firstOrFail();
        $this->assertNull($spot->editorial_guide);
        $this->get('/spots/'.$spot->id)->assertOk()->assertDontSee('id="official-guide"', false);
    }

    public function test_ambiguous_existing_facilities_abort_instead_of_attaching_to_the_wrong_one(): void
    {
        foreach ([1, 2] as $i) {
            Spot::create(['name'=>'THE FARM', 'area'=>'千葉県','lat'=>35,'lng'=>140]);
        }
        try {
            $this->seed(MetropolitanGuideSeeder::class);
            $this->fail('Duplicate candidates must require review.');
        } catch (\RuntimeException $e) {
            $this->assertStringContainsString('重複候補', $e->getMessage());
        }
        $this->assertSame(0, Spot::whereNotNull('editorial_guide')->count());
        $this->assertDatabaseCount('spots', 2);
    }
}
