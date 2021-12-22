<?php

namespace Flobbos\LaravelCM;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Flobbos\LaravelCM\Contracts\BaseClientContract;
use Flobbos\LaravelCM\Exceptions\ConfigKeyNotSetException;

abstract class BaseClient implements BaseClientContract
{

    protected $guzzle, $base_uri, $skip_key;
    protected $options = [];

    public function __construct()
    {
        //Initialize Guzzle
        $this->initGuzzle();
        //Set options
        $this->setOptions([
            'format' => config('laravel-cm.format'),
            'clientApiKey' => config('laravel-cm.client_api_key'),
            'clientID' => config('laravel-cm.client_id'),
            'listID' => config('laravel-cm.default_list_id')
        ]);
    }


    /**
     * @inheritDoc
     *
     * @param array $options
     * @return self
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set the client API Key
     * @param string $key
     */
    public function setClientApiKey(string $key = null): self
    {
        $this->options['clientApiKey'] = $key;
        return $this;
    }

    /**
     * Get the current client API Key
     */
    public function getClientApiKey(): string
    {
        return $this->options['clientApiKey'];
    }

    /**
     * Set the client ID
     * @param string $client_id
     * @return \self
     */
    public function setClientID(string $client_id = null): self
    {
        $this->options['clientID'] = $client_id;
        return $this;
    }

    /**
     * Get the current client ID
     * @return string
     */
    public function getClientID(): string
    {
        return $this->options['clientID'];
    }

    /**
     * Set the list ID to be used
     * @param string $list_id
     */
    public function setListID(string $list_id = null): self
    {
        $this->options['listID'] = $list_id ?: $this->getListID();
        return $this;
    }

    /**
     * Get the current List ID
     */
    public function getListID(): string
    {
        return $this->options['listID'];
    }

    /**
     * Set the format of the call
     * @param string $format json|xml
     */
    public function setFormat(string $format): self
    {
        $this->options['format'] = $format;
        return $this;
    }

    /**
     * Get the current format in use
     */
    public function getFormat(): string
    {
        return $this->options['format'];
    }

    /**
     * Get a clean guzzle client object
     */
    public function getGuzzle(): Client
    {
        return new Client;
    }

    /**
     * Initialize guzzle with a base_uri called by the constructor
     * @param type $base_uri
     */
    public function initGuzzle($base_uri = null): self
    {
        if (!is_null($base_uri)) {
            $this->guzzle = new Client(['base_uri' => config('laravel-cm.base_uri')]);
        }
        $this->guzzle = new Client(['base_uri' => config('laravel-cm.base_uri')]);
        return $this;
    }

    /**
     * Retrieve auth information for API Call
     * @return array
     */
    public function getAuthInformation(): array
    {
        return [$this->getClientApiKey(), ''];
    }

    /**
     * Retrieve basic Guzzle options for making an API call
     * @return array
     */
    public function getBaseRequestData(): array
    {
        return [
            'stream' => true,
            'auth' => $this->getAuthInformation(),
            'headers' => [
                'Accept' => 'application/json'
            ]
        ];
    }

    /**
     * Merge the request data with parameters provided by calling function
     * @param array $request_data
     * @return type
     */
    public function mergeRequestData(array $request_data): array
    {
        return array_merge($request_data, $this->getBaseRequestData());
    }

    /**
     * Check api options and skip optional values
     * @return Guzzle client
     */
    private function checkOptions(): void
    {
        foreach ($this->options as $k => $v) {
            if (empty($v) && $this->skip_key != $k) {
                throw new ConfigKeyNotSetException('No ' . $k . ' found. Please update your settings or generate a resource');
            }
        }
        return;
    }

    /**
     * Call the guzzle Client and provide optional validation key to skip
     * when validating options
     * @return Guzzle\Client
     */
    public function callApi(): \GuzzleHttp\Client
    {
        $this->checkOptions();
        return $this->guzzle;
    }

    public function makeCall($url, array $request_data, $method = 'get')
    {
        try {
            return $this->formatResult(
                $this->callApi()->{$method}(
                    $url . '.' . $this->getFormat(),
                    $this->mergeRequestData($request_data)
                )
            );
        } catch (RequestException $ex) {
            $response_body = $this->formatBody($ex->getResponse()->getBody());
            throw new Exception('Code ' . $response_body->Code . ': ' . $response_body->Message);
        } catch (ClientException $ex) {
            $response_body = $this->formatBody($ex->getResponse()->getBody());
            throw new Exception('Code ' . $response_body->Code . ': ' . $response_body->Message);
        }
    }
}
