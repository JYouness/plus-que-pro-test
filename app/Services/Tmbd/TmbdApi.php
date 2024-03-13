<?php

declare(strict_types=1);

namespace App\Services\Tmbd;

use App\Contracts\TmbdApiContract;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class TmbdApi implements TmbdApiContract
{
    private PendingRequest $client;

    /**
     * TMDB API constructor.
     */
    public function __construct()
    {
        $this->client = Http::baseUrl('https://api.themoviedb.org/3')
            ->withToken(config('services.tmbd.token'))
            ->accept('application/json');
    }

    /**
     * Get the trending movies.
     *
     * @param string $timeWindow
     * @param int $page
     * @param string $language
     *
     * @return array
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

    /**
     * Get the movie genres.
     *
     * @param string $language
     *
     * @return array
     */
    public function getMovieGenres(
        string $language = 'en-US'
    ): array {
        $response = $this->client->get('/genre/movie/list', [
            'language' => $language,
        ]);

        return $response->json();
    }
}
