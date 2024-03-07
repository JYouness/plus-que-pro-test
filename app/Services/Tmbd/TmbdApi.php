<?php

namespace App\Services\Tmbd;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class TmbdApi
{
    private PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::baseUrl('https://api.themoviedb.org/3')
            ->withToken(config('services.tmbd.token'))
            ->accept('application/json');
    }

    public function getTrendingMovies(
        string $timeWindow = 'day',
        int $page = 1,
        string $language = 'en-US'
    ) {
        $response = $this->client->get("/trending/movie/{$timeWindow}", [
            'page' => $page,
            'language' => $language,
        ]);

        return $response->json();
    }
}
