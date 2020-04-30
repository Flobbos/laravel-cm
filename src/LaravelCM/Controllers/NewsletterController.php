<?php

namespace Flobbos\LaravelCM\Controllers;

use App\Http\Controllers\Controller;

class NewsletterController extends Controller{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('laravel-cm::dashboard');
    }

}

