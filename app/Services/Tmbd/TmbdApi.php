<?php

namespace App\Services\Tmbd;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class TmbdApi
{
    /**
     * TMDB API constructor.
     */
    public function __construct(
        private PendingRequest $client
    ) {
        $this->client = Http::baseUrl('https://api.themoviedb.org/3')
            ->withToken(config('services.tmbd.token'))
            ->accept('application/json');
    }

    /**
     * Get the trending movies.
     */
    public function getTrendingMovies(
        string $timeWindow = 'day',
        int $page = 1,
        string $language = 'en-US'
    ): array {
        $response = $this->client->get("/trending/movie/{$timeWindow}", [
            'page' => $page,
            'language' => $language,
        ]);

        return $response->json();
    }

    public function getMovieGenres(
        string $language = 'en-US'
    ): array {
        $response = $this->client->get('/genre/movie/list', [
            'language' => $language,
        ]);

        return $response->json();
    }
}
