<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Participation;
use App\Models\Step;
use App\Models\StepField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CampaignSeeder extends Seeder
{



    public function run(): void
    {
        $campaign = Campaign::factory()->create([
            'title' => 'example campaign',
            'uuid' => Str::random(),
            'end_date' => now()->addDays(30)
        ]);

        Participation::factory()->create([
            'campaign_id' => $campaign->id,
            'email'=>'test@gmail.com',
            'data'=>json_encode(['position_one'=>'some data']),
        ]);

        $step_one = Step::factory()->create([
            'campaign_id' => $campaign->id,
            'filename'   => 'step',
            'order_num'=>1

        ]);
        StepField::factory()->create([
            'step_id' => $step_one->id,
            'field_name'   => 'email',

        ]);

         Step::factory()->create([
            'campaign_id' => $campaign->id,
            'filename'  => 'step',
             'order_num'=>1
        ]);
    }
}
