<?php

namespace Flobbos\LaravelCM;
use Flobbos\LaravelCM\Contracts\ListContract;
use Flobbos\LaravelCM\Contracts\ResultFormatContract;
use Flobbos\LaravelCM\BaseClient;

class Lists extends BaseClient implements ListContract, ResultFormatContract{
    
    use Traits\ResultFormat;
    
    public function get(){
        $result = $this->makeCall('get','clients/'.$this->getClientID().'/lists',[]);
        return collect($result->get('body'));
    }
    
    public function stats(){
        
    }
    
    public function create(){
        
    }
    
    public function makeCall($method = 'get', $url, array $request_data){
        return $this->formatResult(
                $this->guzzle->{$method}($url.'.'.$this->getFormat(),
                $this->mergeRequestData($request_data)));
    }
    
}