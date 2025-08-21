<?php

namespace Flobbos\LaravelCM;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Exception\GuzzleException;

class RemoteCompiler
{

    protected $client;
    protected $url;
    protected $token;

    public function __construct()
    {
        $this->url = config('laravel-cm.api_url');
        $this->token = config('laravel-cm.api_token');
        $this->client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-cm.api_token'),
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function compile($mjml, $scss = null)
    {
        $multipart = [
            [
                'name' => 'html',
                'contents' => $mjml,
            ],
        ];

        if ($scss) {
            foreach ($scss as $file) {
                $stream = fopen('php://temp', 'r+');
                fwrite($stream, $file['contents']);
                rewind($stream);

                // Guess content type based on extension
                $ext = pathinfo($file['filename'], PATHINFO_EXTENSION);
                $contentType = match ($ext) {
                    'scss' => 'text/x-scss',
                    'css' => 'text/css',
                    'txt' => 'text/plain',
                    default => 'text/plain',  // Fallback to avoid octet-stream issues
                };

                $multipart[] = [
                    'name' => 'sass-files[]',  // Add [] to ensure array on server
                    'contents' => $stream,
                    'filename' => $file['filename'],
                    'headers' => [
                        'Content-Type' => $contentType,
                    ],
                ];
            }
        }

        try {
            $response = $this->client->request('POST', $this->url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ],
                'multipart' => $multipart,
            ]);

            return $response->getBody()->getContents();
        } catch (Exception $e) {
            Log::error('RemoteCompiler error: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
