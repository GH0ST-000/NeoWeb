<?php

use App\Http\Controllers\CampaignFrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::controller(CampaignFrontendController::class)->group(function (){
    Route::get('campaign/{campaignUuid}', 'display')->name('campaign.display');
    Route::get('campaign/{campaignUuid}/submit', 'submit')->name('campaign.submit');
});


Route::middleware('auth')->group(function () {
    Route::get('participations', 'ParticipationController@index')->name('participations.index');
});
