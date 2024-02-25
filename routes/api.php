<?php

use App\Http\Controllers\CampaignFrontendController;
use App\Http\Controllers\ParticipationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::controller(CampaignFrontendController::class)->group(function (){
    Route::get('/campaign/{campaignUuid}','display');
    Route::post('/campaign/{campaignUuid}','submit');
});



Route::middleware('api.key')->group(function () {
    Route::get('participations',[ParticipationController::class,'index'])->name('participations.index');
});
