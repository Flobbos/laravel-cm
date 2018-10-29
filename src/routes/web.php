<?php

Route::group(['middleware'=>['web','auth'],'namespace'=>'Flobbos\LaravelCM\Controllers','prefix'=>'laravel-cm','as'=>'laravel-cm::'], function(){
    //Dashboard
    Route::get('/','NewsletterController@index')->name('dashboard');
    //Subscribers
    Route::get('subscribers/details/{email}','SubscriberController@showDetails')->name('subscribers.details');
    Route::put('subscribers/resubscribe/{email}','SubscriberController@resubscribe')->name('subscribers.resubscribe');
    Route::get('subscribers/unsubscribe/{email}','SubscriberController@unsubscribe')->name('subscribers.unsubscribe');
    Route::get('subscribers/show-import','SubscriberController@showImport')->name('subscribers.show-import');
    Route::post('subscribers/import','SubscriberController@import')->name('subscribers.import');
    Route::resource('subscribers','SubscriberController')->only(['index','edit','update']);
    //Lists
    Route::get('lists/stats/{list_id}','ListController@showListStats')->name('lists.stats');
    Route::get('lists/details/{list_id}','ListController@showListDetails')->name('lists.details');
    Route::resource('lists','ListController')->except(['update','edit','show']);
    //Campaigns
    Route::get('campaigns/show-preview/{campaign_id}','CampaignController@showCampaignPreview')->name('campaigns.show-preview');
    Route::post('campaigns/send-preview/{campaign_id}','CampaignController@sendCampaignPreview')->name('campaigns.send-preview');
    Route::get('campaigns/send/{campaign_id}','CampaignController@scheduleCampaign')->name('campaigns.send');
    Route::resource('campaigns','CampaignController');
});
