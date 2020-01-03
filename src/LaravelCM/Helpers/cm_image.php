<?php

if (!function_exists('cm_image')) {
    function cm_image(string $template_name, string $filename){
        return url('laravel-cm-assets/'.str_slug($template_name).'/assets/images/'.$filename);
    }
}
