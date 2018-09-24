<?php


Route::get('newsletters/create-template','NewsletterController@showCreateTemplate')->name('newsletters.create-template');
Route::post('newsletters/store-template','NewsletterController@storeTemplate')->name('newsletters.store-template');
Route::get('newsletters/excel-import','NewsletterController@showImportExcel')->name('newsletters.show-import');
Route::post('newsletters/import','NewsletterController@importExcel')->name('newsletters.import');
Route::resource('newsletters','NewsletterController');