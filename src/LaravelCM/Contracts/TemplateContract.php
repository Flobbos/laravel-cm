<?php

namespace Flobbos\LaravelCM\Contracts;

use Flobbos\LaravelCM\Contracts\BaseClientContract;

interface TemplateContract{
    
    /**
     * Get all templates in DB
     * @return type
     */
    public function get();
    
    /**
     * Create new template in DB
     * @return type
     */
    public function create(array $data);
    
    /**
     * Set relations for templates
     * @param type $relations
     * @return $this
     */
    public function with($relations);
    
    /**
     * Find a specific template
     * @param type $id
     * @return type
     */
    public function find($id);
    
    /**
     * Delete a template
     * @param type $id
     * @return boolean
     */
    public function delete($id);
    
    /**
     * Get all templates from DB (alias for get)
     */
    public function getTemplatesFromDB();
    
    /**
     * Set current template
     * @param string $template_name
     */
    public function setTemplate(string $template_name);
    
    /**
     * Get current template
     */
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
