<?php

namespace Flobbos\LaravelCM;

use Flobbos\LaravelCM\Contracts\ListContract;
use Flobbos\LaravelCM\Contracts\ResultFormatContract;
use Flobbos\LaravelCM\BaseClient;
use Exception;

class Lists extends BaseClient implements ListContract, ResultFormatContract
{

    use Traits\ResultFormat;
    protected $skip_key = 'listID';
    /**
     * Get all lists for the current client
     * @return Collection
     */
    public function get()
    {
        $result = $this->makeCall('clients/' . $this->getClientID() . '/lists', []);
        return collect($result->get('body'));
    }

    /**
     * Get the details for a list
     * @param string $list_id
     * @return string
     * @throws Exception
     */
    public function details($list_id)
    {
        $result = $this->makeCall('lists/' . $list_id, []);
        if ($result->get('code') != '200') {
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }

    /**
     * Get the stats for a list
     * @param string $list_id
     * @return string
     * @throws Exception
     */
    public function stats($list_id)
    {
        $result = $this->makeCall('lists/' . $list_id . '/stats', []);
        if ($result->get('code') != '200') {
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }

    /**
     * Create a new list
     * @param array $list_options
     * @return string
     * @throws Exception
     */
    public function create(array $list_options)
    {
        $result = $this->makeCall('lists/' . $this->getClientID(), [
            'json' => $list_options,
        ], 'post');
        if ($result->get('code') != '201') {
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }

    /**
     * Update a list
     * @param string $list_id
     * @param array $list_options
     * @return string
     * @throws Exception
     */
    public function update(string $list_id, array $list_options)
    {
        $result = $this->makeCall('lists/' . $list_id, [
            'json' => $list_options
        ], 'put');
        if ($result->get('code') != '200') {
            throw new Exception($result->get('body'));
        }
        return $result->get('body');
    }

    /**
     * Delete a list
     * @param string $list_id
     * @return boolean
     * @throws Exception
     */
    public function delete($list_id)
    {
        $result = $this->makeCall('lists/' . $list_id, [], 'delete');
        if ($result->get('code') != '200') {
            throw new Exception($result->get('body'));
        }
        return true;
    }
}
