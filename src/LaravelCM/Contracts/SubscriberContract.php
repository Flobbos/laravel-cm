<?php

namespace Flobbos\LaravelCM\Contracts;
use Flobbos\LaravelCM\Contracts\BaseClientContract;;

interface SubscriberContract extends BaseClientContract {
    
    //Getters
    public function getActive(int $page = 1, $pageName = 'page',int $perPage = 25);
    
    public function getUnsubscribed(int $page = 1, $pageName = 'page', int $perPage = 25);
    
    public function getUnconfirmed(int $page = 1, $pageName = 'page', int $perPage = 25);
    
    public function getDeleted(int $page = 1, $pageName = 'page', int $perPage = 25);
    
    public function getBounced(int $page = 1, $pageName = 'page', int $perPage = 25);
    
    public function getDetails(string $email);
    
    //Create
    public function add(array $subscriber_data);
    
    //Resubscribe
    public function resubscribe(string $email);
    
    //Remove
    public function remove(string $email);
    
    //Import
    public function import(\Illuminate\Http\Request $request, $field = 'excel');
    
    public function formatSubscribers($result_body, $paginated = false);
    
}