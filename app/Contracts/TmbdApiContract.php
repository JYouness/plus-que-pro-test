<?php

declare(strict_types=1);

namespace App\Contracts;

interface TmbdApiContract
{
    /**
     * Get the trending movies.
     *
     * @param string $timeWindow
     * @param int    $page
     * @param string $language
     *
     * @return array
     */
    public function getTrendingMovies(
        string $timeWindow = 'day',
        int $page = 1,
        string $language = 'en-US'
    ): array;

    /**
     * Get the movie genres.
     *
     * @param string $language
     *
     * @return array
     */
    public function getMovieGenres(
        string $language = 'en-US'
    ): array;
}
