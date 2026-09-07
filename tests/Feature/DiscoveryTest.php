<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Support\Discovery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscoveryTest extends TestCase
{
    use RefreshDatabase;

    private function spot(array $attributes = []): Spot
    {
        return Spot::create(array_merge(['name'=>'湖畔のテスト施設','area'=>'山梨県','lat'=>35.5,'lng'=>138.5,'category'=>'campground','tags'=>['solo'],'description'=>'テスト用の施設紹介です。'], $attributes));
    }

    public function test_category_search_and_filters_are_combined(): void
    {
        $this->spot();
        $this->spot(['name'=>'別のスパ','category'=>'spa']);
        $this->get('/categories/solo?q=湖畔&area='.urlencode('山梨県').'&tag=solo')->assertOk()->assertSee('湖畔のテスト施設')->assertDontSee('別のスパ');
        $this->get('/categories/unknown')->assertNotFound();
        $this->get('/?q[]=bad')->assertRedirect();
    }

    public function test_all_category_pages_and_empty_states_render(): void
    {
        foreach (Discovery::CATEGORIES as $key=>$value) {
            $this->get('/categories/'.$key)->assertOk()->assertSee('この条件の施設は、まだありません。');
        }
        foreach (['/','/create','/areas','/about','/guidelines','/journals','/compare'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_pagination_has_stable_self_canonical(): void
    {
        for ($i=0; $i<14; $i++) { $this->spot(['name'=>'施設 '.$i]); }
        $this->get('/?page=2')->assertOk()->assertSee('http://localhost?page=2', false)->assertSee('2 / 2ページ');
        $this->get('/?q=施設')->assertSee('noindex,follow', false);
    }

    public function test_compare_is_limited_and_contains_real_values(): void
    {
        $first = $this->spot();
        $second = $this->spot(['name'=>'スパのテスト','category'=>'spa']);
        $this->get('/compare?ids[]='.$first->id.'&ids[]='.$second->id)->assertOk()->assertSee('スパのテスト')->assertSee('投稿なし');
        $this->get('/compare?ids[]=1&ids[]=2&ids[]=3&ids[]=4')->assertRedirect();
    }

    public function test_review_details_persist_and_appear_on_the_facility(): void
    {
        $spot = $this->spot();
        $this->post('/spots/'.$spot->id.'/reviews', ['nickname'=>'旅人','rating'=>4,'comment'=>'湖を眺めて静かに過ごせました。','visited_on'=>'2026-01-01','party'=>'solo','cost'=>3200])->assertRedirect();
        $this->assertDatabaseHas('reviews',['spot_id'=>$spot->id,'party'=>'solo','cost'=>3200]);
        $this->get('/spots/'.$spot->id)->assertOk()->assertSee('湖を眺めて')->assertSee('3,200')->assertSee('2026/01/01');
        $this->get('/journals')->assertOk()->assertSee('湖を眺めて');
    }

    public function test_future_visit_is_rejected(): void
    {
        $spot = $this->spot();
        $this->post('/spots/'.$spot->id.'/reviews',['rating'=>4,'comment'=>'未来の訪問テストです。','visited_on'=>now()->addDay()->format('Y-m-d')])->assertSessionHasErrors('visited_on');
        $this->assertDatabaseCount('reviews',0);
    }

    public function test_reports_are_deduplicated_and_hidden_reviews_are_excluded(): void
    {
        $spot = $this->spot();
        $review = $spot->reviews()->create(['rating'=>1,'comment'=>'非表示対象の本文です。','nickname'=>'テスト','ip_hash'=>'x']);
        for ($i=0;$i<2;$i++) { $this->post('/reviews/'.$review->id.'/report',['reason'=>'spam'])->assertRedirect(); }
        $this->assertDatabaseCount('review_reports',1);
        $this->artisan('reviews:visibility', ['review'=>$review->id,'state'=>'hide'])->assertSuccessful();
        $this->get('/spots/'.$spot->id)->assertOk()->assertDontSee('非表示対象の本文です。');
        $this->get('/journals')->assertDontSee('非表示対象の本文です。');
        $this->get('/')->assertSee('体験記を募集中');
    }

    public function test_structured_data_is_valid_and_cannot_close_the_script(): void
    {
        $spot = $this->spot(['name'=>'施設 </script><script>alert(1)</script>']);
        $response = $this->get('/spots/'.$spot->id)->assertOk();
        $response->assertDontSee('<script>alert(1)</script>',false);
        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s',$response->getContent(),$matches);
        $this->assertGreaterThanOrEqual(3,count($matches[1]));
        foreach ($matches[1] as $json) {
            $value=json_decode($json,true,512,JSON_THROW_ON_ERROR);
            $this->assertSame('https://schema.org',$value['@context']);
        }
    }

    public function test_sitemap_has_all_discovery_routes_and_valid_xml(): void
    {
        $spot=$this->spot();
        $response=$this->get('/sitemap.xml')->assertOk()->assertSee('/categories/spa')->assertSee('/spots/'.$spot->id);
        $this->assertNotFalse(simplexml_load_string($response->getContent()));
    }

    public function test_registration_validates_category_and_official_url(): void
    {
        $fields=['name'=>'スパ登録テスト','lat'=>35,'lng'=>139,'category'=>'spa','official_url'=>'https://example.com','tags'=>['couple']];
        $this->post('/spots',$fields)->assertRedirect(route('spots.thanks'));
        $this->assertDatabaseHas('spots',['name'=>'スパ登録テスト','category'=>'spa']);
        $this->post('/spots',array_merge($fields,['official_url'=>'javascript:alert(1)']))->assertSessionHasErrors('official_url');
    }
}
