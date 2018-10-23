<?php

namespace Flobbos\LaravelCM;
use Flobbos\LaravelCM\Contracts\CampaignContract;
use Flobbos\LaravelCM\BaseClient;
use Exception;

class Campaigns extends BaseClient implements CampaignContract{
    
    use Traits\ResultFormat;
    
    public function createDraft(array $options) {
        $options['SegmentIDs'] = [];
        $data = ['json' => $options];
        $result = $this->makeCall('post','campaigns/'.$this->getClientID(),$data);
        if($result->get('code') != '200'){
            throw new Exception($result->get('body'));
        }
        //Return formatted list
        return $result->get('body');
    }
    
    public function makeCall($method = 'get', $url, array $request_data) {
        //dd($this->mergeRequestData($request_data));
        return $this->formatResult(
                $this->guzzle->{$method}($url.'.'.$this->getFormat(),
                $this->mergeRequestData($request_data)));
    }
    
}