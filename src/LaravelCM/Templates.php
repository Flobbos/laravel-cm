<?php

namespace Flobbos\LaravelCM;

use Flobbos\LaravelCM\Contracts\TemplateContract;
use Symfony\Component\DomCrawler\Crawler;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use ScssPhp\ScssPhp\Compiler as ScssCompiler;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Artisan;
use Flobbos\LaravelCM\Exceptions\TemplateNotFoundException;
use App\NewsletterTemplate;
use Flobbos\LaravelCM\RemoteCompiler;

class Templates implements TemplateContract {

    protected $disk;
    protected $template;
    protected $srcTemplatePath;
    protected $distTemplatePath;
    protected $html;
    protected $template_db;

    public function __construct(NewsletterTemplate $template_db) {

        $this->disk = Storage::disk('laravel_cm');
        $this->srcTemplatePath = resource_path('laravel-cm/' . $this->template);
        $this->distTemplatePath = $this->disk->path($this->template);
        $this->template_db = $template_db;
    }
    
    //CRUD methods
    /**
     * Get all templates in DB
     * @return type
     */
    public function get(){
        return $this->template_db->get();
    }
    
    /**
     * Create new template in DB
     * @return type
     */
    public function create(array $data){
        return $this->template_db->create($data);
    }
    
    /**
     * Update Template
     * @param array $data
     * @return bool
     */
    public function update($id, array $data, $return_model = false){
        $model = $this->find($id);
        if($return_model){
            $model->update($data);
            return $model;
        }
        return $model->update($data);
    }
    
    /**
     * Set relations for templates
     * @param type $relations
     * @return $this
     */
    public function with($relations){
        $this->template_db->with($relations);
        return $this;
    }
    
    /**
     * Find a specific template
     * @param type $id
     * @return type
     */
    public function find($id){
        return $this->template_db->find($id);
    }
    
    /**
     * Delete a template
     * @param type $id
     * @return boolean
     */
    public function delete($id){
        $model = $this->find($id);
        if(!is_null($model)){
            //Delete public assets
            $this->disk->deleteDirectory(str_slug($model->template_name));
            //Delete resource files
            File::deleteDirectory($this->srcTemplatePath.'/'.str_slug($model->template_name));
            return $model->delete();
        }
        return false;
    }

    /**
     * Get all templates from DB
     * @return type
     */
    public function getTemplatesFromDB() {
        return $this->template_db->all();
    }

    public function setTemplate(string $template_name) {
        $this->template = $template_name;
        return $this;
    }
    
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Start compiling process
     *
     * @return void
     */
    public function compile(string $template_name, array $data = []) {
        //Set template
        $this->setTemplate($template_name);
        if(!File::exists(resource_path('laravel-cm/' . $template_name))){
            $this->generateTemplate();
        }
        //Check if template exists
        $this->templateExists($template_name);
        //Start compiling if nothing went wrong
        if(config('laravel-cm.use_api')){
            //API compiler
            $this->remoteCompiler($data);
        }
        else{
            //local compiler
            $this->localCompiler($data);
        }
        
        
        return true;
    }
    
    /**
     * Compile inky template to html and save it to storage
     *
     * @param [string] $view
     * @param array $data
     * @return void
     */
    public function saveViewAsHtml($view, $data) {

        $viewPath = $view . '.views.' . $view;

        $html = View::make($viewPath, $data)->render();

        $this->disk->put($this->template . '/' . $this->template . '.html', $html);

        return $html;

    }

    /**
     * Compile template scss to css and save file to storage
     *
     * @return void
     */
    public function compileSass() {
 
        $importPaths = [
            // Set template imports
            resource_path('laravel-cm/'.$this->template.'/assets/scss'),
            // Set foundation-email imports
            __DIR__ . '/../resources/defaults/assets/foundation-emails'
        ];
        
        $src = resource_path('laravel-cm/'.$this->template.'/assets/scss/'.$this->template.'.scss');

        $scss = new ScssCompiler();
        $scss->setImportPaths($importPaths);

        $scssContent = File::get($src);
        
        $css = trim(preg_replace('/\s+/', ' ', $scss->compile($scssContent)));
        //dd($this->disk);
        return $this->disk->put($this->template . '/assets/style.css', $css);
    }

    /**
     * Copy images to storage
     *
     * @return void
     */
    public function copyImages() {
        $imageFolder = resource_path('laravel-cm/'.$this->template.'/assets/images');
        $dest = $this->disk->path($this->template . '/assets/images');
        return File::copyDirectory($imageFolder, $dest);
    }

    /**
     * Run Style-Inliner to inline template styles to html-document
     *
     * @return void
     */
    public function inlineStyles() {

        $crawler = new Crawler();
        $crawler->addHtmlContent($this->html);
        
        $stylesheets = $crawler->filter('link[rel=stylesheet]');
        // collect hrefs
        $stylesheetsHrefs = collect($stylesheets->extract('href'));
        // remove links
        // $stylesheets->each(function (Crawler $crawler) {;
        //     foreach ($crawler as $node) {
        //         $node->parentNode->removeChild($node);
        //     }
        // });

        $results = $crawler->html();

        // get the styles

        $styles = $stylesheetsHrefs->map(function ($stylesheet) {
            $path = $this->template . '/assets/style.css';
            return $this->disk->get($path);
        })->implode("\n\n");

        $inliner = new CssToInlineStyles();

        return $this->disk->put($this->template . '/' . $this->template . '.html', $inliner->convert($results, $styles));

    }
    
    public function templateExists(string $template){
        if(!File::exists(resource_path('laravel-cm/' . $template))) {
            throw new TemplateNotFoundException('Given template "'.$template.'" not found at ' . resource_path('laravel-cm'));
        }
        return true;
    }
    
    private function generateTemplate(){
        // Copy stub to new template
        $stubPath = resource_path('laravel-cm/default');
        $destPath = resource_path('laravel-cm/' . $this->template);

        if(!File::exists( $destPath)) {
            // Rename copied files to template-name
            File::copyDirectory($stubPath, $destPath);
            $files = File::allFiles($destPath);
            foreach ($files as $file) {
                if (strpos($file->getFilename(), 'template') !== false) {
                    $filename = config('laravel-cm.use_api') ? str_replace('inky', 'blade', $file->getFilename()) : $file->getFilename();
                    $renamePath = $file->getPath() . '/' . str_replace('template', str_slug($this->template), $filename);
                    File::move($file->getPathname(), $renamePath);
                }
            }
        }
        return;
    }
    
    private function localCompiler(array $data){
        $this->compileSass();
        $this->copyImages();
        $this->html = $this->saveViewAsHtml($this->template, $data);
        $this->inlineStyles();
        return;
    }
    
    private function remoteCompiler(array $data){
        $viewPath = $this->template . '.views.' . $this->template;

        $html = View::make($viewPath, $data)->render();

        //Resolve API
        $api = resolve(RemoteCompiler::class);
        $compiled = $api->compile($html, $this->getResourceFiles());
        
        $this->disk->put($this->template . '/' . $this->template . '.html', $compiled);

        $this->copyImages();

        return $compiled;
    }
    
    private function getResourceFiles(){

        $files = File::files(resource_path('laravel-cm/'.$this->template.'/assets/scss'));

        $resource_files = [];
        foreach($files as $file){
            $resource_files[] = [
                'name'     => 'sass-files[]',
                'filename' => File::name($file) == $this->template?'template.'.File::extension($file):File::name($file) . '.' . File::extension($file),
                'contents' => File::get($file)
            ];
        }

        return $resource_files;
    }
    
}
