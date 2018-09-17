<?php

namespace Flobbos\LaravelCM;

use Illuminate\Support\ServiceProvider;

class LaravelCMServiceProvider extends ServiceProvider{
    
    public function boot(){
        $this->publishes([
            __DIR__.'/../config/newsletter.php' => config_path('newsletter.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register(){
        $this->mergeConfigFrom(
            __DIR__.'/../config/newsletter.php', 'newsletter'
        );
        $config = app()->make('config');
        $this->app->bind('Flobbos\LaravelNewsletter\Contracts\Newsletter',$config->get('newsletter.implementation'));
        $this->app->when($config->get('api_implementation.when'))
                ->needs('Flobbos\LaravelNewsletter\Contracts\Api')
                ->give($config->get('api_implementation.give'));
    }
}
