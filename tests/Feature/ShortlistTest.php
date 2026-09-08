<?php

namespace Tests\Feature;

use App\Models\Spot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_shortlist_preserves_order_and_tolerates_removed_facilities(): void
    {
        $a = Spot::create(['name'=>'森の施設','category'=>'healing','area'=>'長野県','lat'=>null,'lng'=>null]);
        $b = Spot::create(['name'=>'温浴施設','category'=>'spa','area'=>'東京都','lat'=>35,'lng'=>139]);
        $this->get('/my-list?ids[]='.$b->id.'&ids[]=9999&ids[]='.$a->id)->assertOk()
            ->assertSeeInOrder(['温浴施設','森の施設'])->assertSee('noindex,follow', false);
        $this->get('/my-list')->assertOk()->assertSee('気になる場所を、ひとつずつ。');
        $this->get('/my-list?ids[]=javascript:alert(1)')->assertRedirect();
        $this->get('/my-list?'.http_build_query(['ids'=>range(1,51)]))->assertRedirect();
    }

    public function test_unknown_coordinates_never_generate_a_map_pin_or_geo_schema(): void
    {
        $spot = Spot::create(['name'=>'森林の拠点','category'=>'healing','area'=>'長野県','lat'=>null,'lng'=>null,'official_url'=>'https://example.org/']);
        $response = $this->get('/spots/'.$spot->id)->assertOk()->assertSee('公式案内でアクセスを確認')
            ->assertDontSee('openstreetmap.org')->assertDontSee('GeoCoordinates');
    }

    public function test_source_filter_and_address_search_work_together(): void
    {
        $a = Spot::create(['name'=>'出典確認済み施設','category'=>'spa','area'=>'東京都','lat'=>null,'lng'=>null]);
        $a->forceFill(['address'=>'東京都小金井市本町','source_checked_at'=>'2026-09-08'])->save();
        Spot::create(['name'=>'利用者の施設','category'=>'spa','area'=>'東京都','lat'=>35,'lng'=>139]);
        $this->get('/categories/spa?verified=1&q='.urlencode('小金井'))->assertOk()
            ->assertSee('出典確認済み施設')->assertDontSee('利用者の施設')->assertSee('noindex,follow', false);
    }
}
