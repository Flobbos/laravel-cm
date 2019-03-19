<?php

namespace Flobbos\LaravelCM;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
class LaravelCMServiceProvider extends ServiceProvider{
    
    public function boot(){
        //Publish config
        $this->publishes([
            __DIR__.'/../config/laravel-cm.php' => config_path('laravel-cm.php'),
        ],'config');
        //Publish migrations
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'), 
        ],'migrations');
        //Publishes defaults
        $this->publishes([
            __DIR__.'/../resources/defaults/template' => resource_path('laravel-cm/default')
        ]);
        
        //Add Laravel CM routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        //Add views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-cm');
        //Add language files
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-cm');

        //Extend validation rules
        Validator::extend("emails", function($attribute, $values, $parameters) {
            $value = explode(',', $values);
            $rules = [
                'email' => 'required|email',
            ];
            if ($value) {
                $validator = \Validator::make(['emails' => $value], [
                    'emails' => 'max:' . config('laravel-cm.max_test_emails')
                ]);
                if ($validator->fails()) {
                    return false;
                }

                foreach ($value as $email) {
                    $data = [
                        'email' => $email
                    ];
                    $validator = \Validator::make($data, $rules);
                    if ($validator->fails()) {
                        return false;
                    }
                }
                return true;
            }
        });

    }

    /**
     * Register the service provider.
     */
    public function register(){
        //Merge config
        $this->mergeConfigFrom(
             __DIR__.'/../config/laravel-cm.php', 'laravel-cm'
        );
        //register commands
        $this->commands([
            Commands\ControllerCommand::class,
            Commands\ViewCommand::class,
        ]);
        //Bindings
        $this->app->bind('Flobbos\LaravelCM\Contracts\CampaignContract', Campaigns::class);
        $this->app->bind('Flobbos\LaravelCM\Contracts\ListContract', Lists::class);
        $this->app->bind('Flobbos\LaravelCM\Contracts\SubscriberContract', Subscribers::class);
        $this->app->bind('Flobbos\LaravelCM\Contracts\TemplateContract', Templates::class);
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
