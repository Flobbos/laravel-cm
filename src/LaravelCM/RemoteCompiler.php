<?php

namespace Flobbos\LaravelCM;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RemoteCompiler {
    
    protected $client;
    
    public function __construct() {
        $this->client = new Client(['auth' => [config('laravel-cm.api_token'),null]]);
    }
    
    public function compile(string $html, array $file_list){
        $file_list[] = [
            'name' => 'html',
            'contents' => $html
        ];
        //Start up guzzle
        try{
            $response = $this->client->post(config('laravel-cm.api_url'),[
                'multipart' => $file_list
            ]);
            return $response->getBody();
        } catch (GuzzleException $ex) {
            return $ex->getResponse()->getBody(true);
        }
        
    }
}
