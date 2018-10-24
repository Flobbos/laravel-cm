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
        $result = $this->makeCall('get','lists/'.$this->getListID().'/deleted',[
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
    
    public function getBounced(int $page = 1, $pageName = 'page', int $perPage = 25) {
        $result = $this->makeCall('get','lists/'.$this->getListID().'/bounced',[
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
    
    public function getDetails(string $email) {
        return $this->makeCall('get','subscribers/'.$this->getListID(),[
            'query' => [
                'email' => $email,
                'includetrackingpreference' => true
            ],
            'stream' => true,
            'auth' => $this->getAuthInformation()
        ]);
    }
    
    //Create
    public function add(array $subscriber_data){
        $result = $this->makeCall('post','subscribers/'.$this->getListID(),[
                'json' => $subscriber_data,
            ]);
            if($result->get('code') != '201'){
                throw new Exception($result->get('body'));
            }
            return;
    }
    
    //Resubscribe
    public function resubscribe(string $email){
        $result = $this->makeCall('put','subscribers/'.$this->getListID(),[
            'query' => [
                'email' => $email
            ],
            'json' => [
                'Resubscribe' => true,
                'ConsentToTrack' => 'Yes'
            ]
        ]);
        if($result->get('code') == '200'){
            return true;
        }
        return false;
    }
    
    //Remove
    public function remove(string $email){
        $result = $this->makeCall('post','subscribers/'.$this->getListID().'/unsubscribe',[
            'json' => ['EmailAddress'=>$email],
        ]);
        //dd($result);
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        return;
    }
    
    //Update
    public function update(string $email, array $data) {
        $result = $this->makeCall('put','subscribers/'.$this->getListID(),[
            'query' => $email,
            'json' => [
                'EmailAddress' => $email,
                'Name' => $data['Name'],
                'RestartSubscriptionBasedAutoresponders' => true,
                'ConsentToTrack' => 'Unchanged',
            ]
        ]);
    }
    
    //Import
    public function import(Request $request, $field = 'excel') {
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
        //Set list ID
        $this->setListID($request->get('listID'));
        //Sync to CM
        $result = $this->makeCall('post','subscribers/'.$this->getListID().'/import',[
            'json' => $subscribers,
        ]);
        if($result->get('code') != '201'){
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }


    public function makeCall($method = 'get', $url, array $request_data){
        try{
            return $this->formatResult(
                $this->callApi()->{$method}($url.'.'.$this->getFormat(),
                $this->mergeRequestData($request_data)));
        } catch (RequestException $ex) {
            $response_body = $this->formatBody($ex->getResponse()->getBody());
            throw new Exception('Code '.$response_body->Code.': '.$response_body->Message);
        }
    }
    
}
