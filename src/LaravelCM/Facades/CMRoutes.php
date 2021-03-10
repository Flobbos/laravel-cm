<?php

namespace Flobbos\LaravelCM\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;

class CMRoutes extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return;
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @param  array  $options
     * @return void
     */
    public static function load(string $class, bool $templates = true)
    {
        Route::put('newsletter-template/generate-template/{id}', [$class, 'generateTemplate'])->name('newsletter-templates.generate-template');
        Route::put('newsletter-template/update-template/{id}', [$class, 'updateTemplate'])->name('newsletter-templates.update-template');
        Route::get('templates/{id}/send-preview', [$class, 'sendPreview'])->name('newsletter-templates.send-preview');
        // Newslettertemplate Routes
        if ($templates) {
            Route::resource('newsletter-templates', $class);
        }
    }
}
