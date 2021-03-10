<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterTemplate extends Model
{

    protected $fillable = [
        'template_name',
        'layout', //remove this if you're using a single layout
        'title'
    ];


    public function getTemplateUrlAttribute()
    {
        return url('storage/' . config('laravel-cm.asset_path') . '/' . $this->template_name);
    }

    public function getTemplateFileUrlAttribute()
    {
        return $this->template_url . '/' . $this->template_name . '.html';
    }

    public function getTemplatePathAttribute()
    {
        return storage_path('app/public/' . config('laravel-cm.asset_path') . '/' . $this->template_name);
    }

    public function getTemplateFilePathAttribute()
    {
        return $this->template_path . '/' . $this->template_name . '.html';
    }
}
