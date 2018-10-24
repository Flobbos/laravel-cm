<?php

namespace Flobbos\LaravelCM;

use Illuminate\Support\ServiceProvider;

class LaravelCMServiceProvider extends ServiceProvider{
    
    public function boot(){
        $this->publishes([
            __DIR__.'/../config/laravel-cm.php' => config_path('laravel-cm.php'),
        ]);

        // Register command for template-generation via artisan
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\CreateTemplate::class
            ]);
        }
        //Add Laravel CM routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        //Add views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-cm');
        //Add language files
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-cm');
    }

    /**
     * Register the service provider.
     */
    public function register(){
        //Merge config
        $this->mergeConfigFrom(
             __DIR__.'/../config/laravel-cm.php', 'laravel-cm'
        );
        //Bindings
        $this->app->bind('Flobbos\LaravelCM\Contracts\CampaignContract', Campaigns::class);
        $this->app->bind('Flobbos\LaravelCM\Contracts\ListContract', Lists::class);
        $this->app->bind('Flobbos\LaravelCM\Contracts\SubscriberContract', Subscribers::class);
        $this->app->bind('Flobbos\LaravelCM\Contracts\TemplateContract', Templates::class);
        $this->app->bind('Flobbos\LaravelCM\Contracts\ImportContract', Importer::class);
        // Register new storage-disk
        config(['filesystems.disks.laravel_cm' => [
            'driver' => 'local',
            'root' => public_path('laravel-cm'),
            'url' => env('APP_URL').'/laravel-cm',
            'visibility' => 'public'
        ]]);

        // Disable default inliner of laravel-blinky-package
        config(['view.laravel_blinky' => ['use_inliner' => false]]);

        // Register template-location
        $this->app['view']->addLocation(resource_path('laravel-cm'));
    }
}
