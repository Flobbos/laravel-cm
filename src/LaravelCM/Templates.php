<?php

namespace Flobbos\LaravelCM;

use Flobbos\LaravelCM\Contracts\TemplateContract;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Flobbos\LaravelCM\Exceptions\TemplateNotFoundException;
use App\Models\NewsletterTemplate;
use Flobbos\LaravelCM\RemoteCompiler;
use Flobbos\LaravelCM\Exceptions\NoLayoutsException;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Templates implements TemplateContract
{

    protected $disk;
    protected $template;
    protected $srcTemplatePath;
    protected $html;
    protected $template_db;

    public function __construct(NewsletterTemplate $template_db)
    {

        $this->disk = Storage::disk('laravel_cm');
        $this->srcTemplatePath = $this->getTemplatePath();
        $this->template_db = $template_db;
    }

    //CRUD methods

    /**
     * Get all templates in DB
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return $this->template_db->get();
    }

    /**
     * Create new template in DB
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->template_db->create($data);
    }

    /**
     * Update Template
     * @param array $data
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data, $return_model = false)
    {
        $model = $this->find($id);
        if ($return_model) {
            $model->update($data);
            return $model;
        }
        return $model->update($data);
    }

    /**
     * Set relations for templates
     * @param  array|string  $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->template_db = $this->template_db->with($relations);
        return $this;
    }

    /**
     * Find a specific template
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        return $this->template_db->find($id);
    }

    /**
     * Delete a template
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        $model = $this->find($id);
        if (!is_null($model)) {
            //Delete public assets
            $this->disk->deleteDirectory(Str::slug($model->template_name));
            //Delete resource files
            File::deleteDirectory($this->srcTemplatePath . '/' . Str::slug($model->template_name));
            return $model->delete();
        }
        return false;
    }

    /**
     * Get all templates from DB
     * @return \Illuminate\Support\Collection
     */
    public function getTemplatesFromDB()
    {
        return $this->template_db->all();
    }

    /**
     * Set the current template
     *
     * @param string $template_name
     * @return $this
     */
    public function setTemplate(string $template_name)
    {
        $this->template = $template_name;
        return $this;
    }

    /**
     * Get the current template name in use
     *
     * @return string template name
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Start compiling process
     *
     * @return void
     */
    public function compile(string $template_name, array $data = [])
    {
        //Set template
        $this->setTemplate($template_name);

        if (!File::exists($this->getTemplatePath($template_name)) || Arr::get($data['template']->getChanges(), 'layout')) {
            $this->generateTemplate($data['template']->layout ?? config('laravel-cm.base_layout', 'base'));
        }
        //Check if template exists
        $this->templateExists($template_name);

        //Start compiling if nothing went wrong
        $this->remoteCompiler($data);

        return true;
    }

    /**
     * Compile inky template to html and save it to storage
     *
     * @param [string] $view
     * @param array $data
     * @return void
     */
    public function saveViewAsHtml($view, $data)
    {

        $viewPath = $view . '.views.' . $view;

        $html = View::make($viewPath, $data)->render();

        $this->disk->put($this->template . '/' . $this->template . '.html', $html);

        return $html;
    }

    /**
     * Copy images to storage
     *
     * @return void
     */
    public function copyImages()
    {
        $imageFolder = $this->getImagePath();
        $dest = $this->disk->path($this->template . '/images');
        return File::copyDirectory($imageFolder, $dest);
    }

    public function templateExists(string $template)
    {
        if (!File::exists($this->getTemplatePath($template))) {
            throw new TemplateNotFoundException('Given template "' . $template . '" not found at ' . resource_path('laravel-cm'));
        }
        return true;
    }

    /**
     * Get all layouts from disk
     * @return array of layouts available
     * @throws NoLayoutsException
     */
    public function getLayouts()
    {
        if (!config('laravel-cm.multi_layout')) {
            return [];
        }
        $files = File::directories(resource_path(config('laravel-cm.layout_path')));
        if (empty($files)) {
            throw new NoLayoutsException(resource_path(config('laravel-cm.layout_path')));
        }
        $layouts = [];
        foreach ($files as $layout) {
            $layouts[] = basename($layout);
        }
        return $layouts;
    }

    /**
     * Get the validation rules for storing a new template
     * @return array
     */
    public function getValidationRulesStore(): array
    {
        if (config('laravel-cm.multi_layout')) {
            return [
                'template_name' => 'required|unique:newsletter_templates',
                'layout' => 'required',
            ];
        } else {
            return [
                'template_name' => 'required|unique:newsletter_templates',
            ];
        }
    }

    /**
     * Get validation rules for updating a template
     *
     * @return array
     */
    public function getValidationRulesUpdate(): array
    {
        if (config('laravel-cm.multi_layout')) {
            return [
                'template_name' => 'required|unique:newsletter_templates',
            ];
        } else {
            return [
                'template_name' => 'required|unique:newsletter_templates',
            ];
        }
    }

    private function generateTemplate(string $layout = null)
    {
        // Copy stub to new template
        $stubPath = $this->getLayoutPath($layout);
        $destPath = $this->getTemplatePath($this->template);

        //Empty target
        File::deleteDirectory($destPath);

        if (!File::exists($destPath)) {
            // Rename copied files to template-name
            File::copyDirectory($stubPath, $destPath);
            $files = File::allFiles($destPath);
            foreach ($files as $file) {
                if (strpos($file->getFilename(), $layout) !== false) {
                    $renamePath = $file->getPath() . '/' . str_replace($layout, Str::slug($this->template), $file->getFilename());
                    File::move($file->getPathname(), $renamePath);
                }
            }
        }
        return;
    }

    private function remoteCompiler(array $data)
    {
        $viewPath = $this->template . '.' . $this->template;

        $html = View::make($this->getTemplateViewPath($viewPath), $data)->render();

        //Resolve API
        $api = resolve(RemoteCompiler::class);
        $compiled = $api->compile($html, $this->getResourceFiles());

        $this->disk->put($this->template . '/' . $this->template . '.html', $compiled);

        $this->copyImages();

        return $compiled;
    }

    private function getResourceFiles()
    {

        $files = iterator_to_array(
            Finder::create()->files()->ignoreDotFiles(true)->in($this->getTemplatePath($this->template))->depth(0)->name('*.scss')->sortByName(),
            false
        );
        $resource_files = [];
        foreach ($files as $file) {
            $resource_files[] = [
                'name' => 'sass-files[]',
                'filename' => File::name($file) == $this->template ? 'template.' . File::extension($file) : File::name($file) . '.' . File::extension($file),
                'contents' => File::get($file)
            ];
        }

        return $resource_files;
    }

    private function getLayoutPath(string $layout = null)
    {
        if (!$layout) {
            $layout = config('laravel-cm.base_layout', 'base');
        }
        return resource_path(config('laravel-cm.layout_path') . '/' . $layout);
    }

    private function getTemplatePath()
    {
        return resource_path(config('laravel-cm.template_path') . '/' . $this->getTemplate());
    }

    private function getImagePath()
    {
        return $this->getTemplatePath() . '/images';
    }

    private function getTemplateViewPath($viewPath)
    {
        return $viewPath;
        return str_replace('/', '.', rtrim(config('laravel-cm.template_path'), '/')) . '.' . $viewPath;
    }
}
