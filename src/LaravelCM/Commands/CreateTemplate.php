<?php

namespace Flobbos\LaravelCM\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cm:template {template}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Template';

    protected $template;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->template = str_slug($this->argument('template'));

        // Copy stub to new template
        $stubPath = dirname(__FILE__) . '../defaults/template';
        $destPath = resource_path('laravel-cm/' . $this->template);
        if(File::exists($destPath)) {
            $this->error('Template with name "'.$this->template.'" already exist!');
            exit();
        }

        // Rename copied files to template-name
        File::copyDirectory( $stubPath,  $destPath );
        $files = File::allFiles($destPath);
        foreach($files as $file) {
            if(strpos($file->getFilename(), 'template') !== false) {
                $renamePath = $file->getPath() . '/' . str_replace('template', str_slug($this->template), $file->getFilename());
                File::move($file->getPathname(), $renamePath);
            }
        }

        $this->info("Template {$this->template} was created. (resources/laravel-cm/".$this->template.")");
    }
}
