<?php

namespace Flobbos\LaravelCM\Contracts;
use Flobbos\LaravelCM\Contracts\BaseClientContract;

interface ListContract extends BaseClientContract{
    
    /**
     * Get all lists for the current client
     * @return Collection
     */
    public function get();
    
    /**
     * Get the details for a list
     * @param string $list_id
     * @return string
     * @throws Exception
     */
    public function details($list_id);
    
    /**
     * Get the stats for a list
     * @param string $list_id
     * @return string
     * @throws Exception
     */
    public function stats($list_id);
    
    /**
     * Create a new list
     * @param array $list_options
     * @return string
     * @throws Exception
     */
    public function create(array $list_options);
    
    /**
     * Update a list
     * @param string $list_id
     * @param array $list_options
     * @return string
     * @throws Exception
     */
    public function update(string $list_id, array $list_options);
    
    /**
     * Delete a list
     * @param string $list_id
     * @return boolean
     * @throws Exception
     */
    public function delete($list_id);
    
}