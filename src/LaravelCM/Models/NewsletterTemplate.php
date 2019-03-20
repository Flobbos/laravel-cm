<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterTemplate extends Model{
    
    protected $fillable = [
        'template_name',
        'title',
        'intro',
        'issue'
    ];
    
    
}
