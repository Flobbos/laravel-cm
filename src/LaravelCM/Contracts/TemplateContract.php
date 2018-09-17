<?php

namespace Flobbos\LaravelCM\Contracts;

interface TemplateContract {
    
    /**
     * Start compiling process
     *
     * @return void
     */
    public function compile();

    /**
     * Compile inky template to html and save it to storage
     *
     * @param [string] $view
     * @param array $data
     * @return void
     */
    public function saveViewAsHtml($view, $data = []);

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
     * Zip the assets to archive
     *
     * @return void
     */
    public function zipAssets();

    /**
     * Remove assets-folder
     *
     * @return void
     */
    public function clearAssets();

}
