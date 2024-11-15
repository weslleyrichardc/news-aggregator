<?php

namespace App\Services\NewsApiService;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * News API Service
 * https://newsapi.org/v2/everything
 */
class NewsApiService
{
    public PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->baseUrl('https://newsapi.org/v2');
    }

    public function news(array $options): PromiseInterface|Response
    {
        return $this->api->get('/everything', [
            'q' => $options['q'] ?? null,
            'from' => $options['from'] ?? now()->subMonth()->toDateString(),
            'to' => $options['to'] ?? now()->toDateString(),
            'sortBy' => $options['sortBy'] ?? 'popularity',
            'apiKey' => env('NEWSAPI_KEY'),
        ]);
    }
}
