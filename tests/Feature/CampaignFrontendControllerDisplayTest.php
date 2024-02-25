<?php

namespace Tests\Feature;
use App\Http\Controllers\CampaignFrontendController;
use App\Models\Campaign;
use App\Models\Step;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Str;
use Tests\TestCase;

class CampaignFrontendControllerDisplayTest extends TestCase
{

    public function testDisplayForExpiredCampaign(): void
    {
        $controller = new CampaignFrontendController();
        $campaign = Campaign::factory()->create(['end_date' => now()->subDay(),'uuid'=>Str::random(),'title'=>'test']);

        $request = Request::create('/', 'GET');
        $response = $controller->display($request, $campaign);

        $this->assertEquals('expired', $response->name());
    }


    public function testDisplayForValidCampaign(): void
    {
        $campaign = Campaign::factory()->create(['end_date' => now()->addDays(1),'uuid'=>Str::random(),'title'=>'test']);
        $controller = new CampaignFrontendController();

        Step::factory()->create([
            'campaign_id' => $campaign->id,
            'order_num' => 1,
            'filename' => 'welcome'
        ]);

        $response = $this->withSession(['current_step' => 1])
            ->get('/', ['campaign' => $campaign]);

        $responseContent = $response->getContent();

        $this->assertStringContainsString($campaign->title, $responseContent);
    }


}
