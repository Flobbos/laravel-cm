<?php

namespace Flobbos\LaravelCM;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\AliasLoader;

class LaravelCMServiceProvider extends ServiceProvider
{

  public function boot()
  {
    //Publish config
    $this->publishes([
      __DIR__ . '/../config/laravel-cm.php' => config_path('laravel-cm.php'),
    ], 'laravel-cm-config');
    //Publish migrations
    $this->publishes([
      __DIR__ . '/../database/migrations/' => database_path('migrations'),
    ], 'laravel-cm-migrations');
    //Publishes defaults
    $this->publishes([
      __DIR__ . '/../resources/defaults/base' => resource_path(config('laravel-cm.layout_path') . '/base')
    ], 'laravel-cm-layout');
    //Publishes defaults
    $this->publishes([
      __DIR__ . '/Models' => app_path('/Models')
    ], 'laravel-cm-model');

    //Add Laravel CM routes
    $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    //Add views depending on the css framework setting in config
    $this->loadViewsFrom(__DIR__ . '/../resources/views/' . config('laravel-cm.css_framework'), 'laravel-cm');
    //Add language files
    $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravel-cm');

    //Extend validation rules
    Validator::extend("emails", function ($attribute, $values, $parameters) {
      $value = explode(',', $values);
      $rules = [
        'email' => 'required|email',
      ];
      if ($value) {
        $validator = Validator::make(['emails' => $value], [
          'emails' => 'max:' . config('laravel-cm.max_test_emails')
        ]);
        if ($validator->fails()) {
          return false;
        }

        foreach ($value as $email) {
          $data = [
            'email' => $email
          ];
          $validator = Validator::make($data, $rules);
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
  public function register()
  {
    //Merge config
    $this->mergeConfigFrom(
      __DIR__ . '/../config/laravel-cm.php',
      'laravel-cm'
    );
    //register commands
    $this->commands([
      Commands\ControllerCommand::class,
      Commands\ViewCommand::class,
      Commands\LayoutCommand::class,
      Commands\InstallCommand::class,
    ]);

    //Bindings
    $this->app->bind('Flobbos\LaravelCM\Contracts\CampaignContract', Campaigns::class);
    $this->app->bind('Flobbos\LaravelCM\Contracts\ListContract', Lists::class);
    $this->app->bind('Flobbos\LaravelCM\Contracts\SubscriberContract', Subscribers::class);
    $this->app->bind('Flobbos\LaravelCM\Contracts\TemplateContract', Templates::class);
    // Register new storage-disk
    config(['filesystems.disks.laravel_cm' => [
      'driver' => 'local',
      'root' => storage_path('app/public/laravel-cm-assets'),
      'url' => env('APP_URL') . '/storage/laravel-cm-assets',
      'visibility' => 'public'
    ]]);
    // Register template-location
    $this->app['view']->addLocation(resource_path(config('laravel-cm.template_path')));
    //Grab loader and register static routes facade
    $loader = AliasLoader::getInstance();
    $loader->alias('CMRoutes', 'Flobbos\LaravelCM\Facades\CMRoutes');
  }
}
