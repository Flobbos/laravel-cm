<?php

namespace Flobbos\LaravelCM;
use Flobbos\LaravelCM\Contracts\ListContract;
use Flobbos\LaravelCM\Contracts\ResultFormatContract;
use Flobbos\LaravelCM\BaseClient;

class Lists extends BaseClient implements ListContract, ResultFormatContract{
    
    use Traits\ResultFormat;
    
    /**
     * Get all lists for the current client
     * @return type
     */
    public function get() {
        $result = $this->makeCall('get','clients/'.$this->getClientID().'/lists',[]);
        return collect($result->get('body'));
    }
    
    public function details($list_id) {
        $result = $this->makeCall('get','lists/'.$list_id,[]);
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }
    
    public function stats($list_id){
        $result = $this->makeCall('get','lists/'.$list_id.'/stats',[]);
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }
    
    public function create(array $list_options){
        return $this->makeCall('post','lists/'.$this->getClientID(), [
            'json' => $list_options,
        ]);
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }
    
    public function delete($list_id) {
        $result = $this->makeCall('delete','lists/'.$list_id,[]);
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        return true;
    }
    
    public function makeCall($method = 'get', $url, array $request_data){
        try{
            return $this->formatResult(
                $this->callApi('listID')->{$method}($url.'.'.$this->getFormat(),
                $this->mergeRequestData($request_data)));
        } catch (RequestException $ex) {
            $response_body = $this->formatBody($ex->getResponse()->getBody());
            throw new Exception('Code '.$response_body->Code.': '.$response_body->Message);
        }
    }
}