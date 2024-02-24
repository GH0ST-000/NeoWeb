<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Step;
use App\Models\StepField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CampaignSeeder extends Seeder
{

    public function run(): void
    {
        $campaign = Campaign::create(['title' => 'Sample Campaign', 'end_date' => now()->addDays(30), 'uuid' => Str::random()]);

        $step1 = Step::create(['campaign_id' => $campaign->id, 'title' => 'Step 1', 'order_num' => 1, 'fileName' => 'step1.blade.php']);
        $step2 = Step::create(['campaign_id' => $campaign->id, 'title' => 'Step 2', 'order_num' => 2, 'fileName' => 'step2.blade.php']);

        StepField::create(['step_id' => $step1->id, 'input' => 'email']);
        StepField::create(['step_id' => $step1->id, 'input' => 'name']);
        StepField::create(['step_id' => $step1->id, 'input' => 'date_of_birth']);

        StepField::create(['step_id' => $step2->id, 'input' => 'phone']);
        StepField::create(['step_id' => $step2->id, 'input' => 'address']);
    }
}
