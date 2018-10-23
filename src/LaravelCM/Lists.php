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
        $result = $this->formatResultSet($this->guzzle->get('lists/'.$list_id.'/stats.'.$this->geformat(),[
            'auth' => $this->getAuthInformation()
        ]));
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }
    
    public function create(array $options){
        return $this->formatResultSet($this->guzzle->post('lists/'.$this->clientID.'.'.$this->getFormat(), [
            'json' => $options,
            'auth' => $this->getAuthInformation()
        ]));
    }
    
    public function makeCall($method = 'get', $url, array $request_data){
        return $this->formatResult(
                $this->guzzle->{$method}($url.'.'.$this->getFormat(),
                $this->mergeRequestData($request_data)));
    }
    
}