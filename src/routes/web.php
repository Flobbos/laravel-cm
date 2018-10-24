<?php

Route::group(['middleware'=>['web','auth'],'namespace'=>'Flobbos\LaravelCM\Controllers','prefix'=>'laravel-cm','as'=>'laravel-cm::'], function(){
    //Dashboard
    Route::get('/','NewsletterController@index')->name('home');
    //Subscribers
    Route::get('subscribers/subscriber-details/{email}','SubscriberController@showDetails')->name('subscribers.subscriber-details');
    Route::put('subscribers/resubscribe/{email}','SubscriberController@resubscribe')->name('subscribers.resubscribe');
    Route::get('subscribers/unsubscribe/{email}','SubscriberController@unsubscribe')->name('subscribers.unsubscribe');
    Route::resource('subscribers','SubscriberController')->only(['index','edit','update']);
    //Lists
    Route::get('lists/stats/{list_id}','ListController@showListStats')->name('lists.stats');
    Route::get('lists/details/{list_id}','ListController@showListDetails')->name('lists.details');
    Route::resource('lists','ListController')->except(['update','edit','show']);
    //Campaigns
    Route::get('campaigns/send-preview/{campaign_id}','CampaignController@sendCampaignPreview')->name('campaigns.send-preview');
    Route::resource('campaigns','CampaignController');
});
