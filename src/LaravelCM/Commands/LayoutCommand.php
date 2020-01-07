<?php

namespace Flobbos\LaravelCM\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use InvalidArgumentException;

class LayoutCommand extends GeneratorCommand {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'laravel-cm:layout {name} {--fresh}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generates layouts for template generation.';

  /**
   * Get the stub file for the generator.
   *
   * @return string
   */
  protected function getStub(){

    $src = $this->getPath('base');

    if($this->generateFresh()) {
      $src = __DIR__.'/../../resources/defaults/base/';
    }

    return [
      ($this->getPathInput() . '.blade.php') =>_($src . '/base.blade.php'),
      ($this->getPathInput() . '.scss') => ($src . '/base.scss'),
    ];
  }

  /**
   * Check if fresh-option is set in command
   *
   * @return boolean
   */
  protected function generateFresh() {
    return $this->option('fresh');
  }

  /*
   * Get path-info for given layout-name
   */
  protected function getPathInput(){
    return trim($this->argument('name'));
  }

  /**
   * Get the destination class path.
   *
   * @param  string  $name
   * @return string
   */
  protected function getPath($name){
    return resource_path('laravel-cm/layouts/'.$this->getDirectoryName($name));
  }

  /**
   * Get directory name
   *
   * @param string $name
   * @return string
   */
  protected function getDirectoryName($name){
    return strtolower(Str::kebab($name));
  }

  /**
   * Determine if the class already exists.
   *
   * @param  string $rawName
   * @return bool
   */
  protected function alreadyExists($rawName=''){
    return $this->files->exists($this->getPath($this->getPathInput()));
  }

  /**
   * Check if base-layout is published
   *
   * @return boolean
   */
  protected function baseNotPublished() {
    return $this->files->exists($this->getPath('base'));
  }

  /**
   * Publish Base-Layout
   *
   * @return mixed
   */
  protected function publishBaseLayout() {
    $this->info('Base-Layout created successfully.');
    return $this->files->copyDirectory(__DIR__.'/../../resources/defaults/base/', $this->getPath(strtolower('base')));
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle(){

    $this->info('WELCOME TO LARAVEL-CM');

    $this->comment('Building new layout.');

    $path = $this->getPath(strtolower($this->getPathInput()));

     // Check if Base-Layout is published
    if(!$this->baseNotPublished()) {

      // Ask for generate base-layout
      $publish_base = $this->ask('Base-Layout not published! Should it be published now?');

      if(!$publish_base) {
        $this->error('Base-Layout was not generated. Layouts could only generated if base-layout exists.');
        return false;
      }

      // Publish base-layout
      $this->publishBaseLayout();
    }

    // Check if layout already exists
    if ($this->alreadyExists()) {
      $this->error('Layout already exists!');
      return false;
    }

    foreach($this->getStub() as $name=>$stub){
      $this->current_stub = $stub;
      $this->makeDirectory($path.'/'.$name);
      $this->files->put($path.'/'.$name, $this->files->get($stub));
    }

    $this->files->makeDirectory($path.'/images');

    // Next, we will generate the path to the location where this class' file should get
    // written. Then, we will build the class and make the proper replacements on the
    // stub files so that it gets the correctly formatted namespace and class name.

    $this->info('Layout created successfully.');
  }

}
