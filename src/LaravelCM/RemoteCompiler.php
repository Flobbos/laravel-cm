<?php

namespace Flobbos\LaravelCM;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class RemoteCompiler
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('laravel-cm.api_url'),
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-cm.api_token'),
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function compile(string $html, array $file_list = [])
    {
        $multipart = [
            [
                'name' => 'html',
                'contents' => stripslashes(trim($html)),
                'headers' => ['Content-Type' => 'text/plain']
            ]
        ];

        // Add files from file_list
        foreach ($file_list as $file) {
            if (!isset($file['name']) || !isset($file['filename']) || !isset($file['contents'])) {
                continue;
            }

            if ($file['name'] === 'sass-files[]') {
                $multipart[] = [
                    'name' => 'sass-files[]',
                    'contents' => stripslashes(trim($file['contents'])),
                    'filename' => $file['filename'],
                    'headers' => ['Content-Type' => 'text/plain']
                ];
            } else {
                // Skipping files
            }
        }

        try {
            $response = $this->client->post('/api/mjml/generate', [
                'multipart' => $multipart
            ]);

            return $response->getBody()->getContents();
        } catch (GuzzleException $ex) {
            $response = $ex->getResponse();
            $error = $response ? $response->getBody()->getContents() : $ex->getMessage();

            throw new \Exception('API request failed: ' . $error, $ex->getCode());
        }
    }
}
