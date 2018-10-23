<?php

namespace Flobbos\LaravelCM;

use Flobbos\LaravelCM\BaseClient;
use Flobbos\LaravelCM\Contracts\SubscriberContract;
use Flobbos\LaravelCM\Contracts\ResultFormatContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class Subscribers extends BaseClient implements SubscriberContract, ResultFormatContract{
    
    use \Flobbos\LaravelCM\Traits\ResultFormat;
    use \Flobbos\LaravelCM\Traits\BaseImport;
    
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
    
    public function getSubscriberDetails(string $email) {
        return $this->formatResultSet($this->guzzle->get('subscribers/'.$this->listID.'.'.$this->getFormat(),[
            'query' => [
                'email' => $email,
                'includetrackingpreference' => true
            ],
            'stream' => true,
            'auth' => $this->getAuthInformation()
        ]));
    }
    
    //Create
    public function add(array $subscriber_data){
        try{
            $result = $this->formatResultSet($this->guzzle->post('subscribers/'.$this->listID.'.'.$this->getFormat(),[
                'json' => $subscriber_data,
                'auth' => $this->getAuthInformation(),
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]));
            if($result->get('code') != '201'){
                throw new Exception($result->get('body'));
            }
            return;
        } catch (GuzzleException $ex) {
            throw $ex;
        } catch (Exception $ex){
            throw $ex;
        }
    }
    
    //Resubscribe
    public function resubscribe(string $email){
        $result = $this->formatResultSet($this->guzzle->put('subscribers/'.$this->listID.'.'.$this->getFormat(),[
            'query' => [
                'email' => $email
            ],
            'json' => [
                'Resubscribe' => true,
                'ConsentToTrack' => 'Yes'
            ],
            'auth' => $this->getAuthInformation()
        ]));
        if($result->get('code') == '200'){
            return true;
        }
        return false;
    }
    
    //Remove
    public function remove(string $email){
        $result = $this->formatResultSet($this->guzzle->post('subscribers/'.$this->listID.'/unsubscribe.'.$this->getFormat(),[
            'json' => ['EmailAddress'=>$email],
            'auth' => $this->getAuthInformation(),
                'headers' => [
                    'Accept' => 'application/json'
                ]
        ]));
        //dd($result);
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        return;
    }
    
    //Import
    public function import(Request $request, $field = 'excel'){
        //Handle upload and populate result
        $this->initResults()->loadFile($this->handleUpload($request, 'excel', '/xls'));
        //Process subscriber list
        $subscribers['Subscribers'] = [];
        $subscribers['Resubscribe'] = true;
        $subscribers['QueueSubscriptionBasedAutoResponders'] = false;
        $subscribers['RestartSubscriptionBasedAutoresponders'] = false;
        foreach($this->results as $k=>$result){
            $subscribers['Subscribers'][] = array_merge($result->toArray(),['ConsentToTrack' => 'Yes']);
        }
        //Sync to CM
        $result = $this->formatResultSet($this->guzzle->post('subscribers/'.$this->listID.'/import.'.$this->getFormat(),[
            'stream' => true,
            'json' => $subscribers,
            'auth' => $this->getAuthInformation()
        ]));
        if($result->get('code') != '201'){
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }
    
    public function makeCall($method = 'get', $url, array $request_data){
        return $this->formatResult(
                $this->guzzle->{$method}($url.'.'.$this->getFormat(),
                $this->mergeRequestData($request_data)));
    }
    
}
