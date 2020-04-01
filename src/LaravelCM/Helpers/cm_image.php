<?php

use Illuminate\Support\Str;

if (!function_exists('cm_image')) {
    function cm_image(string $template_name, string $filename)
    {
        return url('laravel-cm-assets/' . Str::slug($template_name) . '/assets/images/' . $filename);
    }
}
