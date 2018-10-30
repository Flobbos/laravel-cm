<?php

namespace Flobbos\LaravelCM;

use Flobbos\LaravelCM\Contracts\TemplateContract;
use Symfony\Component\DomCrawler\Crawler;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Leafo\ScssPhp\Compiler as ScssCompiler;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Artisan;
use Flobbos\LaravelCM\Exceptions\TemplateNotFoundException;
use Flobbos\LaravelCM\Models\NewsletterTemplate;

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
        //Generate template files
        $this->generateTemplate();
        //Check if template exists
        $this->templateExists($template_name);
        //Start compiling if nothing went wrong
        $this->compileSass();
        $this->copyImages();
        $this->html = $this->saveViewAsHtml($this->template, $data);
        $this->inlineStyles();
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


        return $this->disk->put($this->template . '/assets/style.css', $css);
    }

    /**
     * Copy images to storage
     *
     * @return void
     */
    public function copyImages() {

        $imageFolder = resource_path('laravel-cm/'.$this->template.'/assets/images');
        $dest = $this->disk->path($this->template . '/assets');
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
    
    /**
     * Remove assets-folder
     *
     * @return void
     */
    public function clearAssets() {
        return $this->disk->deleteDirectory($this->cm_template_id . '/assets');
    }
    
    private function generateTemplate(){
        // Copy stub to new template
        $stubPath = dirname(__FILE__) . '/../../resources/defaults/template';
        $destPath = resource_path('laravel-cm/' . $this->template);

        // Rename copied files to template-name
        File::copyDirectory( $stubPath,  $destPath );
        $files = File::allFiles($destPath);
        foreach($files as $file) {
            if(strpos($file->getFilename(), 'template') !== false) {
                $renamePath = $file->getPath() . '/' . str_replace('template', str_slug($this->template), $file->getFilename());
                File::move($file->getPathname(), $renamePath);
            }
        }
        return;
    }
    
}
