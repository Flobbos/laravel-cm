<?php

namespace Flobbos\LaravelCM;

use Flobbos\LaravelCM\BaseClient;
use Flobbos\LaravelCM\Contracts\SubscriberContract;
use Flobbos\LaravelCM\Contracts\ResultFormatContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class Subscribers extends BaseClient implements SubscriberContract, ResultFormatContract{
    
    use \Flobbos\LaravelCM\Traits\ResultFormat;
    
    //Getters
    public function getActive(int $page = 1, $pageName = 'page', int $perPage = 25){
        $result = $this->makeCall('get','lists/'.$this->getListID().'/active',[
            'query' => [
                'page' => $page,
                'pagesize' => $perPage,
            ],
        ]);
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        //Return formatted list
        return $this->formatSubscribers($result->get('body'), $pageName);
    }
    
    public function getUnsubscribed(int $page = 1, $pageName = 'page', int $perPage = 25){
        $result = $this->makeCall('get','lists/'.$this->getListID().'/unsubscribed',[
            'query' => [
                'page' => $page,
                'pagesize' => $perPage,
            ],
        ]);
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        return $this->formatSubscribers($result->get('body'));
    }
    
    public function getUnconfirmed(int $page = 1, $pageName = 'page', int $perPage = 25){
        $result = $this->makeCall('get','lists/'.$this->getListID().'/unconfirmed',[
            'query' => [
                'page' => $page,
                'pagesize' => $perPage,
            ],
        ]);
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        return $this->formatSubscribers($result->get('body'));
    }
    
    public function getDeleted(int $page = 1, $pageName = 'page', int $perPage = 25){
        
    }
    
    //Create
    public function add(array $subscriber_data){
        
    }
    
    //Resubscribe
    public function resubscribe(string $email){
        
    }
    
    //Remove
    public function remove(string $email){
        
    }
    
    //Import
    public function import(array $subscribers){
        
    }
    
    public function makeCall($method = 'get', $url, array $request_data){
        return $this->formatResult(
                $this->guzzle->{$method}($url.'.'.$this->getFormat(),
                $this->mergeRequestData($request_data)));
    }
    
}
