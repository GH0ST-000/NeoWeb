<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Participation;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CampaignFrontendController extends Controller
{
    public function display(Request $request, $campaignUuid)
    {
        $campaign = Campaign::where('uuid', $campaignUuid)->firstOrFail();

        if ($campaign->end_date < now()) {
            return view('campaign.expired');
        }

        $currentStep = $request->session()->get('current_step', 1);

        $step = $campaign->steps()->where('order_num', $currentStep)->first();

        if (!$step) {
            return redirect()->route('campaign.expired');
        }
//        return view($step->fileName, ['campaignTitle' => $campaign->title]);
        $data = [
            'blade_name'=>$step->fileName,
            'blade_param'=> $campaign->title
        ];
        return  response()->json($data);
    }

    public function submit(Request $request, $campaignUuid): \Illuminate\Http\RedirectResponse
    {
        $this->validateForm($request, $campaignUuid);

        $participation = Participation::updateOrCreate(
            ['email' => $request->input('email'), 'campaign_id' => $request->input('campaign_id')],
            ['data' => $request->all()]
        );
        $currentStep = $request->session()->get('current_step', 1);
        if ($currentStep > 1) {
            // Your logic to enrich participation data based on the current step
        }
        $request->session()->put('current_step', $currentStep + 1);

        return redirect()->route('campaign.display', ['campaign' => $campaignUuid]);
    }

    private function validateForm(Request $request, $campaignUuid): void
    {
        $currentStep = $request->session()->get('current_step', 1);
        $step = Step::whereHas('campaign', function ($query) use ($campaignUuid) {
            $query->where('uuid', $campaignUuid);
        })->where('order_num', $currentStep)->first();

        $fields = $step->fields->pluck('input')->toArray();
        $rules = [];
        foreach ($fields as $field) {
            $rules[$field] = 'required';
            if ($field === 'date_of_birth') {
                $rules['date_of_birth'] = [
                    'required',
                    'date',
                    Rule::requiredIf(function () use ($request) {
                        return $request->input('date_of_birth') !== null;
                    }),
                    'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                ];
            }
        }
        $this->validate($request, $rules);
    }
}
