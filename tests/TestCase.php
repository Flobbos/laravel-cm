<?php

namespace Flobbos\LaravelCM\Tests;

use Flobbos\LaravelCM\LaravelCMServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Register the package's service provider for the test application.
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelCMServiceProvider::class,
        ];
    }

    /**
     * Run on an isolated in-memory SQLite database.
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Load the package migrations (newsletter_templates table).
     */
    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../src/database/migrations');
    }
}
