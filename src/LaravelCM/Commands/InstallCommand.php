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

    protected function ensureDirectory(string $path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    protected function copyMissingFiles(string $source, string $target)
    {
        if (!File::isDirectory($source)) {
            return;
        }

        $this->ensureDirectory($target);

        foreach (File::allFiles($source) as $file) {
            $relativePath = ltrim(str_replace($source, '', $file->getPathname()), DIRECTORY_SEPARATOR);
            $targetFile = rtrim($target, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $relativePath;
            $targetDir = dirname($targetFile);

            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            if (!File::exists($targetFile)) {
                File::copy($file->getPathname(), $targetFile);
            }
        }
    }

    protected function generateSymlinks()
    {
        $resourceRoot = resource_path('laravel-cm');
        $layoutPath = resource_path(config('laravel-cm.layout_path'));
        $resourceTemplatePath = resource_path(config('laravel-cm.template_path'));
        $storageTemplatePath = storage_path(config('laravel-cm.template_storage_path', 'app/laravel-cm/templates'));
        $legacyStorageRoot = storage_path('app/laravel-cm');
        $legacyLayoutPath = $legacyStorageRoot . '/layouts';
        $legacyTemplatePath = $legacyStorageRoot . '/templates';

        // Remove legacy symlink of resources/laravel-cm -> storage/app/laravel-cm
        if (is_link($resourceRoot)) {
            $linkTarget = readlink($resourceRoot);
            $resolvedLinkTarget = $linkTarget ? realpath($linkTarget) : false;
            $resolvedLegacyStorageRoot = realpath($legacyStorageRoot);

            if (
                $linkTarget === $legacyStorageRoot ||
                ($resolvedLinkTarget && $resolvedLegacyStorageRoot && $resolvedLinkTarget === $resolvedLegacyStorageRoot)
            ) {
                @unlink($resourceRoot);
                $this->info('Removed legacy resources symlink for laravel-cm.');
            }
        }

        // Layouts are now repository-managed under resources
        $this->ensureDirectory($resourceRoot);
        $this->ensureDirectory($layoutPath);

        // Backward compatibility: preserve and migrate old storage layouts without overwriting repo files
        if (File::isDirectory($legacyLayoutPath)) {
            $this->copyMissingFiles($legacyLayoutPath, $layoutPath);
            $this->info('Synced legacy layouts from storage to resources (existing files preserved).');
        }

        // Templates are now storage-managed by default
        $this->ensureDirectory($storageTemplatePath);

        // Backward compatibility: migrate existing templates from old locations without overwriting storage files
        if (File::isDirectory($resourceTemplatePath) && !is_link($resourceTemplatePath)) {
            $this->copyMissingFiles($resourceTemplatePath, $storageTemplatePath);
            $this->info('Synced existing resource templates to storage (existing files preserved).');
        }

        if (File::isDirectory($legacyTemplatePath)) {
            $this->copyMissingFiles($legacyTemplatePath, $storageTemplatePath);
        }

        //Check for existing public files and move to storage
        if (File::exists(public_path(config('laravel-cm.asset_path'))) && !is_link(public_path(config('laravel-cm.asset_path')))) {
            $this->info('Moving existing public files to storage.');
            File::moveDirectory(public_path(config('laravel-cm.asset_path')), storage_path('app/public/' . config('laravel-cm.asset_path')));
        }

        //Check if public assets directory exists
        if (!File::exists(storage_path('app/public/' . config('laravel-cm.asset_path')))) {
            Storage::makeDirectory('public/' . config('laravel-cm.asset_path'));
            $this->info('Created public directory for assets.');
        }

        // Ensure Laravel's public storage symlink exists for serving compiled templates
        $publicStorage = public_path('storage');
        if (!is_link($publicStorage) && !File::exists($publicStorage)) {
            Artisan::call('storage:link');
            $this->info('Created public/storage symlink.');
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
