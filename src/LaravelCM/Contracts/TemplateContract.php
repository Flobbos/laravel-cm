<?php

namespace Flobbos\LaravelCM\Contracts;

use Flobbos\LaravelCM\Contracts\BaseClientContract;

interface TemplateContract{
    
    
    public function setTemplate(string $template_name);
    
    public function getTemplate();
    
    /**
     * Start compiling process
     *
     * @return void
     */
    public function compile(string $template_name, array $data = []);

    /**
     * Compile inky template to html and save it to storage
     *
     * @param [string] $view
     * @param array $data
     * @return void
     */
    public function saveViewAsHtml($view, $data);

    /**
     * Compile template scss to css and save file to storage
     *
     * @return void
     */
    public function compileSass();

    /**
     * Copy images to storage
     *
     * @return void
     */
    public function copyImages();

    /**
     * Run Style-Inliner to inline template styles to html-document
     *
     * @return void
     */
    public function inlineStyles();
    
    /**
     * Check if the template file exists
     * @param type $name
     */
    public function templateExists(string $template_name);
    
}
