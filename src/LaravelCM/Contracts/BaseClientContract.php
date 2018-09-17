<?php

namespace Flobbos\LaravelCM\Contracts;

interface BaseClientContract{
    
    /**
     * Set the client API Key
     * @param string $key
     */
    public function setClientApiKey(string $key = null): \App\Guzzler\BaseClient;
    
    /**
     * Get the current client API Key
     */
    public function getClientApiKey(): string;
    
    /**
     * Set the client ID
     * @param string $client_id
     * @return \self
     */
    public function setClientID(string $client_id = null):\App\Guzzler\BaseClient;
    
    /**
     * Get the current client ID
     * @return string
     */
    public function getClientID(): string;

    /**
     * Set the list ID to be used
     * @param string $list_id
     */
    public function setListID(string $list_id = null): \App\Guzzler\BaseClient;
    
    /**
     * Get the current List ID
     */
    public function getListID(): string;
    
    /**
     * Set the format of the call
     * @param string $format json|xml
     */
    public function setFormat(string $format): \App\Guzzler\BaseClient;
    
    /**
     * Get the current format in use
     */
    public function getFormat(): string;
    
    /**
     * Get a clean guzzle client object
     */
    public function getGuzzle(): \GuzzleHttp\Client;
    
    /**
     * Initialize guzzle with a base_uri called by the constructor
     * @param type $base_uri
     */
    public function initGuzzle($base_uri = null): \App\Guzzler\BaseClient;
    
    public function getAuthInformation();
    
    public function makeCall($method = 'get', $url, array $request_data);
    
}