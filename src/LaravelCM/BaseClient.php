<?php

namespace Flobbos\LaravelCM;
use Flobbos\LaravelCM\Contracts\BaseClientContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class BaseClient implements BaseClientContract{
    
    protected $guzzle,$clientID,$clientApiKey,$listID,$format,$base_uri;

    public function __construct() {
        //Initialize Guzzle
        $this->initGuzzle();
        //Set the Client ID
        $this->setClientApiKey();
        //Set default List ID
        $this->setListID();
        //Set the default client ID
        $this->setClientID();
        //Set the default format
        $this->setFormat(config('laravel-cm.format'));
    }
    
    /**
     * Set the client API Key
     * @param string $key
     */
    public function setClientApiKey(string $key = null): self{
        if(!is_null($key)){
            $this->clientApiKey = $key;
        }
        else{
            $this->clientApiKey = config('laravel-cm.client_api_key');
        }
        return $this;
    }
    
    /**
     * Get the current client API Key
     */
    public function getClientApiKey(): string{
        return $this->clientApiKey;
    }
    
    /**
     * Set the client ID
     * @param string $client_id
     * @return \self
     */
    public function setClientID(string $client_id = null): self{
        if(!is_null($client_id)){
            $this->clientID = $client_id;
        }
        else{
            $this->clientID = config('laravel-cm.client_id');
        }
        return $this;
    }
    
    /**
     * Get the current client ID
     * @return string
     */
    public function getClientID(): string {
        return $this->clientID;
    }

    /**
     * Set the list ID to be used
     * @param string $list_id
     */
    public function setListID(string $list_id = null): self{
        if(!is_null($list_id)){
            $this->listID = $list_id;
        }
        else{
            $this->listID = config('laravel-cm.default_list_id');
        }
        return $this;
    }
    
    /**
     * Get the current List ID
     */
    public function getListID(): string{
        return $this->listID;
    }
    
    /**
     * Set the format of the call
     * @param string $format json|xml
     */
    public function setFormat(string $format): self{
        $this->format = $format;
        return $this;
    }
    
    /**
     * Get the current format in use
     */
    public function getFormat(): string{
        return $this->format;
    }
    
    /**
     * Get a clean guzzle client object
     */
    public function getGuzzle(): Client{
        return new Client;
    }
    
    /**
     * Initialize guzzle with a base_uri called by the constructor
     * @param type $base_uri
     */
    public function initGuzzle($base_uri = null): self{
        if(!is_null($base_uri)){
            $this->guzzle = new Client(['base_uri'=>config('laravel-cm.base_uri')]);
        }
        $this->guzzle = new Client(['base_uri'=>config('laravel-cm.base_uri')]);
        return $this;
    }
    
    public function getAuthInformation() {
        return [$this->getClientApiKey(),''];
    }
    
    public function getBaseRequestData(){
        return [
            'stream' => true,
            'auth' => $this->getAuthInformation(),
        ];
    }
    
    public function mergeRequestData(array $request_data){
        return array_merge($request_data,$this->getBaseRequestData());
    }
    
    abstract public function makeCall($method = 'get', $url, array $request_data);
    
}