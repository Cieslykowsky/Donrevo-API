<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MailingCampaignController;
use App\Http\Controllers\MailTemplateController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'groups' => GroupController::class,
    'campaigns' => CampaignController::class,
    'contacts' => ContactController::class,
    'mail-templates' => MailTemplateController::class,
    'mailing-campaigns' => MailingCampaignController::class,
    'tasks' => TaskController::class,
]);