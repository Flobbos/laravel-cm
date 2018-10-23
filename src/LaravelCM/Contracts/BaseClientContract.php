<?php

namespace Flobbos\LaravelCM\Contracts;

interface BaseClientContract{
    
    public function setOptions(array $options): \Flobbos\LaravelCM\BaseClient;
    
    public function getOptions(): array;
    
    /**
     * Set the client API Key
     * @param string $key
     */
    public function setClientApiKey(string $key = null): \Flobbos\LaravelCM\BaseClient;
    
    /**
     * Get the current client API Key
     */
    public function getClientApiKey(): string;
    
    /**
     * Set the client ID
     * @param string $client_id
     * @return \self
     */
    public function setClientID(string $client_id = null): \Flobbos\LaravelCM\BaseClient;
    
    /**
     * Get the current client ID
     * @return string
     */
    public function getClientID(): string;

    /**
     * Set the list ID to be used
     * @param string $list_id
     */
    public function setListID(string $list_id = null): \Flobbos\LaravelCM\BaseClient;
    
    /**
     * Get the current List ID
     */
    public function getListID(): string;
    
    /**
     * Set the format of the call
     * @param string $format json|xml
     */
    public function setFormat(string $format): \Flobbos\LaravelCM\BaseClient;
    
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
    public function initGuzzle($base_uri = null): \Flobbos\LaravelCM\BaseClient;
    
    /**
     * Retrieve basic Guzzle options for making an API call
     * @return array
     */
    public function getAuthInformation(): array;
    
    /**
     * Retrieve basic Guzzle options for making an API call
     * @return array
     */
    public function getBaseRequestData(): array;
    
    /**
     * Merge the request data with parameters provided by calling function
     * @param array $request_data
     * @return type
     */
    public function mergeRequestData(array $request_data): array;
    
    /**
     * Call the guzzle Client and provide optional validation key to skip
     * when validating options
     * @param type $skip_key
     * @return Guzzle\Client
     */
    public function callApi($skip_key = null): \GuzzleHttp\Client;
    
    /**
     * Make API call to retrieve data
     * @param type $method
     * @param type $url
     * @param array $request_data
     */
    public function makeCall($method = 'get', $url, array $request_data);
    
}