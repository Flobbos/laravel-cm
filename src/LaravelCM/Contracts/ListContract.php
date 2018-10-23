<?php

namespace Flobbos\LaravelCM\Contracts;
use Flobbos\LaravelCM\Contracts\BaseClientContract;

interface ListContract extends BaseClientContract{
    
    public function get();
    
    public function details($list_id);

    public function stats($list_id);
    
    public function create(array $list_options);
    
    public function delete($list_id);
    
}