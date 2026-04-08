<?php

use Flobbos\LaravelCM\Controllers\NewsletterController;
use Flobbos\LaravelCM\Controllers\SubscriberController;
use Flobbos\LaravelCM\Controllers\ListController;
use Flobbos\LaravelCM\Controllers\CampaignController;

Route::group(['middleware' => config('laravel-cm.middleware'), 'prefix' => 'laravel-cm', 'as' => 'laravel-cm::'], function () {
    //Dashboard
    Route::get('/', [NewsletterController::class, 'index'])->name('dashboard');
    //Subscribers
    Route::get('subscribers/details/{email}', [SubscriberController::class, 'showDetails'])->name('subscribers.details');
    Route::put('subscribers/resubscribe/{email}', [SubscriberController::class, 'resubscribe'])->name('subscribers.resubscribe');
    Route::delete('subscribers/unsubscribe/{email}', [SubscriberController::class, 'unsubscribe'])->name('subscribers.unsubscribe');
    Route::get('subscribers/show-import', [SubscriberController::class, 'showImport'])->name('subscribers.show-import');
    Route::post('subscribers/import', [SubscriberController::class, 'import'])->name('subscribers.import');
    Route::resource('subscribers', SubscriberController::class)->only(['index', 'edit', 'update']);
    //Lists
    Route::get('lists/stats/{list_id}', [ListController::class, 'showListStats'])->name('lists.stats');
    Route::get('lists/details/{list_id}', [ListController::class, 'showListDetails'])->name('lists.details');
    Route::resource('lists', ListController::class)->except(['show']);
    //Campaigns
    Route::get('campaigns/show-preview/{campaign_id}', [CampaignController::class, 'showCampaignPreview'])->name('campaigns.show-preview');
    Route::post('campaigns/send-preview/{campaign_id}', [CampaignController::class, 'sendCampaignPreview'])->name('campaigns.send-preview');
    Route::get('campaigns/show-send/{campaign_id}', [CampaignController::class, 'scheduleCampaign'])->name('campaigns.show-send');
    Route::post('campaigns/send/{campaign_id}', [CampaignController::class, 'saveScheduleCampaign'])->name('campaigns.send');
    Route::get('campaigns/unschedule/{campaign_id}', [CampaignController::class, 'unScheduleCampaign'])->name('campaigns.unschedule');
    Route::resource('campaigns', CampaignController::class);
});
