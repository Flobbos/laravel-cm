<?php

namespace Flobbos\LaravelCM;

use Illuminate\Support\ServiceProvider;

class LaravelCMServiceProvider extends ServiceProvider{
    
    public function boot(){
        $this->publishes([
            __DIR__.'/../config/newsletter.php' => config_path('newsletter.php'),
        ]);

        // Register command for template-generation via artisan
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\CreateTemplate::class
            ]);
        }
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

        // Register new storage-disk
        app()->config["filesystems.disks.larvel-cm"] = [
            'driver' => 'local',
            'root' => public_path('laravel-cm'),
            'url' => env('APP_URL').'/laravel-cm',
            'visibility' => 'public'
        ];

        // Register template-location
        $this->app['view']->addLocation(resource_path('laravel-cm'));
    }
}
