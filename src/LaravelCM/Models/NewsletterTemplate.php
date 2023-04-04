<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class NewsletterTemplate extends Model
{

    protected $fillable = [
        'template_name',
        'layout', //remove this if you're using a single layout
        'title'
    ];


    public function templateUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => url('storage/' . config('laravel-cm.asset_path') . '/' . $this->template_name)
        );
    }

    public function templateFileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->template_url . '/' . $this->template_name . '.html'
        );
    }

    public function templatePath(): Attribute
    {
        return Attribute::make(
            get: fn () => storage_path('app/public/' . config('laravel-cm.asset_path') . '/' . $this->template_name)
        );
    }

    public function templateFilePath()
    {
        return Attribute::make(
            get: fn () => $this->template_path . '/' . $this->template_name . '.html'
        );
    }
}
