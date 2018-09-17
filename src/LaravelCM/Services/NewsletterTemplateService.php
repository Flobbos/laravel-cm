<?php

namespace Flobbos\LaravelCM\Services;

use Symfony\Component\DomCrawler\Crawler;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Leafo\ScssPhp\Compiler as ScssCompiler;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use \ZipArchive;

class NewsletterTemplateService {

    protected $disk;
    protected $template;
    protected $cm_template_id;
    protected $srcTemplatePath;
    protected $distTemplatePath;
    protected $html;

    public function __construct($template, $cm_template_id) {

        $this->disk = Storage::disk('larvel-cm');

        if(!File::exists(resource_path('laravel-cm/templates/' . $template))) {
            throw new \Exception('Given template "'.$template.'" not found at ' . resource_path('laravel-cm'));
        }

        $this->template = $template;
        $this->cm_template_id = $cm_template_id;
        $this->srcTemplatePath = resource_path('laravel-cm/templates/' . $this->template);
        $this->distTemplatePath = $this->disk->path($this->cm_template_id);

        // After build the service run this to start compiling.
        // $this->compile();
    }
    
    /**
     * Start compiling process
     */
    public function compile() {
        $this->compileSass();
        $this->copyImages();
        $this->html = $this->saveViewAsHtml($this->template);
        $this->inlineStyles();
        $this->zipAssets();
        $this->clearAssets();
    }

    /**
     * Compile inky template to html and save it to storage
     */
    public function saveViewAsHtml($view, $data = []) {
        $viewPath = $view . '.views.' . $view;
        
        $view = View::make($viewPath, $data);
        $html = (string) $view;

        $this->disk->put($this->cm_template_id . '/' . $this->cm_template_id . '.html', $html);

        return $html;
    }

    /**
     * Compile template scss to css and save file to storage
     */
    public function compileSass() {
 
        $importPaths = [
            // Set template imports
            resource_path('laravel-cm/templates/'.$this->template.'/assets/scss'),
            // Set foundation-email imports
            __DIR__ . '/../defaults/assets/foundation-emails',
            __DIR__ . '/../defaults/assets/foundation-emails/utils',
            __DIR__ . '/../defaults/assets/foundation-emails/components',
            __DIR__ . '/../defaults/assets/foundation-emails/grid',
            __DIR__ . '/../defaults/assets/foundation-emails/settings',
        ];

        $src = resource_path('laravel-cm/templates/'.$this->template.'/assets/scss/'.$this->template.'.scss');

        $scss = new ScssCompiler();
        $scss->setImportPaths($importPaths);

        $scssContent = File::get($src);
        $css = $scss->compile($scssContent);

        return $this->disk->put($this->cm_template_id . '/assets/style.css', $css);
    }

    /**
     * Copy images to storage
     *
     * @return void
     */
    public function copyImages() {
        $imageFolder = resource_path('laravel-cm/templates/'.$this->template.'/assets/images');
        $dest = $this->disk->path($this->cm_template_id . '/assets');
        return File::copyDirectory($imageFolder, $dest);
    }

    /**
     * Run Style-Inliner to inline template styles to html-document
     */
    public function inlineStyles() {
        $crawler = new Crawler();
        $crawler->addHtmlContent($this->html);
        
        $stylesheets = $crawler->filter('link[rel=stylesheet]');
        // collect hrefs
        $stylesheetsHrefs = collect($stylesheets->extract('href'));
        // remove links
        $stylesheets->each(function (Crawler $crawler) {;
            foreach ($crawler as $node) {
                $node->parentNode->removeChild($node);
            }
        });
        $results = $crawler->html();
        // get the styles

        
        $styles = $stylesheetsHrefs->map(function ($stylesheet) {
            $path = 'public/laravel-cm/' . $this->cm_template_id . '/' . $stylesheet;
            return Storage::disk('local')->get($path);
        })->implode("\n\n");
        $inliner = new CssToInlineStyles();

        return $this->disk->put($this->cm_template_id . '/' . $this->cm_template_id . '.html', $inliner->convert($results, $styles));
    }

    public function zipAssets() {
        $zipFileName = 'assets.zip';

        $zip = new ZipArchive();
        $zip->open($this->distTemplatePath . '/assets.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        foreach ($this->disk->files($this->cm_template_id . '/assets') as $filename) {
            $filepath = $this->disk->path($filename);
            $zip->addFile($filepath , basename($filename));
        }

        return $zip->close();
        
    }

    public function clearAssets() {
        return $this->disk->deleteDirectory($this->cm_template_id . '/assets');
    }
    
}
