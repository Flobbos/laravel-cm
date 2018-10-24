<?php

namespace Flobbos\LaravelCM\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

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

