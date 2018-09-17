<?php

namespace Flobbos\LaravelCM\Contracts;
use GuzzleHttp\Psr7\Response;

interface ResultFormatContract {
    
    public function formatResult(Response $result, $raw_body = false);
    
    public function formatBody($body);
    
    public function formatSubscribers($result_body, $paginated = false);
    
}