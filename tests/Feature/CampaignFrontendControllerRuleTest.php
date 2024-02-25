<?php

namespace Tests\Feature;

use App\Http\Controllers\CampaignFrontendController;
use App\Models\Campaign;
use App\Models\Step;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Tests\TestCase;

class CampaignFrontendControllerRuleTest extends TestCase
{
    protected $campaignFrontendController;

    public function setUp(): void
    {
        parent::setUp();
        $this->campaignFrontendController = new CampaignFrontendController();
    }

    public function testGenerateRules()
    {
        $actual = $this->campaignFrontendController->generateRules(['name', 'date_of_birth']);
        $expected = [
            'name' => 'required',
            'date_of_birth' => [
                'required',
                'date',
                'before:' . Carbon::now()->subYears(18)->toDateString(),
            ]
        ];

        $this->assertEquals($expected, $actual);

        $actual = $this->campaignFrontendController->generateRules(['name', 'email']);
        $expected = [
            'name' => 'required',
            'email' => 'required'
        ];

        $this->assertEquals($expected, $actual);
    }


}
