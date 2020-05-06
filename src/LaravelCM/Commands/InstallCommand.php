<?php

namespace Flobbos\LaravelCM\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-cm:install {--deployment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installation routine for LaravelCM';

    protected $type = 'Installation';

    protected function generateSymlinks()
    {
        //Check for existing layouts in resource path and move it
        if (File::exists(resource_path('laravel-cm')) && !is_link(resource_path('laravel-cm'))) {
            $this->info('Moving existing files to storage.');
            //Create basic laravel-cm directory first
            if (!File::exists(storage_path('app/laravel-cm'))) {
                File::makeDirectory(storage_path('app/laravel-cm/'));
            }
            //Move all existing directories over
            foreach (File::directories(resource_path('laravel-cm')) as $directory) {
                File::moveDirectory($directory, storage_path('app/laravel-cm/' . basename($directory)));
            }
            //Delete now empty directory in resources
            File::deleteDirectory(resource_path('laravel-cm'));
            $this->info('All files moved.');
        }
        //Check for existing public files and move to storage
        if (File::exists(public_path(config('laravel-cm.asset_path'))) && !is_link(public_path(config('laravel-cm.asset_path')))) {
            $this->info('Moving existing public files to storage.');
            File::moveDirectory(public_path(config('laravel-cm.asset_path')), storage_path('app/public/' . config('laravel-cm.asset_path')));
        }
        //Check if files in storage exist
        if (File::exists(storage_path('app/laravel-cm')) && !File::exists(resource_path('laravel-cm'))) {
            symlink(storage_path('app/laravel-cm'), resource_path('laravel-cm'));
            $this->info('Generated symlink to LaravelCM files.');
        } elseif (!File::exists(storage_path('app/laravel-cm'))) {
            Storage::makeDirectory('laravel-cm');
            symlink(storage_path('app/laravel-cm'), resource_path('laravel-cm'));
            $this->info('Created storage directory and symlink.');
        }
        //Check if public assets directory exists
        if (!File::exists(storage_path('app/public/' . config('laravel-cm.asset_path')))) {
            Storage::makeDirectory('public/' . config('laravel-cm.asset_path'));
            $this->info('Created public directory for assets.');
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('WELCOME TO LARAVEL-CM');
        //Check if deployment only 
        //just generate symlinks needed
        if ($this->option('deployment')) {
            $this->info('Generating symlinks and exiting.');
            $this->generateSymlinks();
            return;
        }

        //Quick unattended install
        if ($this->confirm("Would you like to publish all assets and generate symlinks unattended?", false)) {
            $this->info('Publishing config.');
            Artisan::call('vendor:publish', [
                '--tag' => 'laravel-cm-config'
            ]);
            $this->info('Publishing migrations.');
            Artisan::call('vendor:publish', [
                '--tag' => 'laravel-cm-migrations'
            ]);
            $this->info('Publishing base layout.');
            Artisan::call('vendor:publish', [
                '--tag' => 'laravel-cm-layout'
            ]);
            $this->info('Publishing model.');
            Artisan::call('vendor:publish', [
                '--tag' => 'laravel-cm-model'
            ]);
            $this->info('Generating symlinks.');
            $this->generateSymlinks();
            return;
        }

        //Step by step installation
        $this->comment('First we are going to publish necessary assets.');

        if ($this->confirm("Would you like to publish the config?", true)) {
            Artisan::call('vendor:publish', [
                '--tag' => 'laravel-cm-config'
            ]);
            $this->info('LaravelCM configuration published.');
        }

        if ($this->confirm("Would you like to publish the migrations?", true)) {
            Artisan::call('vendor:publish', [
                '--tag' => 'laravel-cm-migrations'
            ]);
            $this->info('LaravelCM migrations published.');
        }

        if ($this->confirm("Would you like to publish the base layout?", true)) {
            Artisan::call('vendor:publish', [
                '--tag' => 'laravel-cm-layout'
            ]);
            $this->info('LaravelCM base layout published.');
        }

        if ($this->confirm("Would you like to publish the Model?", true)) {
            Artisan::call('vendor:publish', [
                '--tag' => 'laravel-cm-model'
            ]);
            $this->info('Basic NewsletterTemplate model published.');
        }

        $this->comment('Now we are going to generate the necessary symlinks.');
        $this->comment('You need to do this after every deployment!');

        if ($this->confirm("Would you like generate the symlinks now?", true)) {
            $this->generateSymlinks();
        }

        $this->info('All done.');
    }
}
