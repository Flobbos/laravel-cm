<?php

namespace Flobbos\LaravelCM\Contracts;
use Flobbos\LaravelCM\Contracts\BaseClientContract;

interface ListContract extends BaseClientContract{
    
    public function get();
    
    public function stats();
    
    public function create();
    
}