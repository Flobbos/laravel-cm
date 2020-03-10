<?php
namespace Flobbos\LaravelCM\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;

class CMRoutes extends Facade {
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(){
        return;
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @param  array  $options
     * @return void
     */
    public static function load(){
        Route::put('newsletter-template/generate-template/{id}', 'NewsletterTemplateController@generateTemplate')->name('newsletter-template.generate-template');
        Route::put('newsletter-template/update-template/{id}', 'NewsletterTemplateController@updateTemplate')->name('newsletter-template.update-template');
        Route::get('templates/{id}/send-preview','NewsletterTemplateController@sendPreview')->name('newsletter-template.send-preview');
        // Newslettertemplate Routes
        Route::resource('newsletter-template', 'NewsletterTemplateController');
    }
}
