<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Participation;
use App\Models\Step;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CampaignFrontendController extends Controller
{

    public function display(Request $request, Campaign $campaignUuid)
    {
        $campaign = $campaignUuid;

        if ($campaign->end_date < now()) {
            return $this->showExpiredCampaign();
        }
        $request->session()->put('current_step',0);
        $currentStep = $request->session()->get('current_step', 1);
        $step = $campaign->steps()->where('order_num', $currentStep)->first();
        if (!$step) {
            return $this->showExpiredCampaign();
        }
        return view($step->filename, ['campaignTitle' => $campaign->title]);

    }


    public function submit(Request $request, Campaign $campaign): \Illuminate\Http\RedirectResponse
    {
        $currentStep = $request->session()->get('current_step', 1);

        $step = Step::whereHas('campaign', function ($query) use ($campaign) {
            $query->where('uuid', $campaign->uuid);
        })->where('order_num', $currentStep)->firstOrFail();

        $fields = $step->fields->pluck('field_name')->toArray();
        $rules = $this->generateRules($fields);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $participation =  Participation::updateOrCreate(
            ['email' => $request->input('email'), 'campaign_id' => $campaign->id],
            ['data' => $request->except('_token')]
        );
        if ($currentStep > 1) {
            $existingData = $participation->data;
            $newData = array_merge($existingData, $request->except('_token'));
            $participation->update(['data' => $newData]);
        }
        $request->session()->put('current_step', $currentStep + 1);
        return redirect()->route('campaign.display', ['campaign' => $campaign->uuid]);
    }


    private function showExpiredCampaign()
    {
        return 'expired';
    }


    protected function generateRules(array $fields): array
    {
        $rules = array_fill_keys($fields, 'required');
        if (in_array('date_of_birth', $fields, true)) {
            $rules['date_of_birth'] = [
                'required',
                'date',
                'before:' . Carbon::now()->subYears(18)->toDateString(),
            ];
        }

        return $rules;
    }
}
