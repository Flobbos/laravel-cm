<?php

namespace Flobbos\LaravelCM\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ControllerCommand extends GeneratorCommand{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-cm:controller {name} {--route=admin.newsletter-template}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the template controller';
    
    protected $type = 'Controller';
    
    protected $route,$view_path;
    
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace){
        return $rootNamespace.'\Http\Controllers';
    }
    
    protected function replaceViewPath(){
        return $this->view_path ?? 'laravel-cm.templates';
    }
    
    protected function replaceDummyRoute(){
        return $this->route ?? $this->option('route');
    }
    
    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name){
        $controllerNamespace = $this->getNamespace($name);

        $replace["use {$controllerNamespace}\Controller;\n"] = '';
        $replace = array_merge($replace, [
            'DummyViewPath' => $this->replaceViewPath($name),
            'DummyRoute' => $this->replaceDummyRoute()
        ]);
        //dd($replace);
        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }
    
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(){
        return __DIR__.'/../../resources/stubs/controllers/template_controller.stub';
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $this->info('WELCOME TO LARAVEL-CM');
        
        $this->comment('Building template controller');
        
        $this->info('The template controller will use the following route: '.$this->option('route'));
        
        if ($this->confirm("Would you like to change this?", false)) {
            $this->route = $this->ask('What route would you like to set?',$this->option('route'));
        }
        
        $this->info('The template controller will use the following view path: '.$this->replaceViewPath());
        
        if ($this->confirm("Would you like to change this?", false)) {
            $this->info('Please use dot notation for the view path.');
            $this->view_path = $this->ask('What view path would you like to set?',$this->replaceViewPath());
        }
        
        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($name);
        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');
            return false;
        }
        
        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');
        
    }
}
