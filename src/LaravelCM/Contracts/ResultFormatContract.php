<?php

namespace Flobbos\LaravelCM\Contracts;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ResultFormatContract
{
    public function formatResult(Response $result, bool $raw_body = false): Collection;

    public function formatBody($body);

    public function formatSubscribers($result_body, string $pageName = 'page'): LengthAwarePaginator;
}