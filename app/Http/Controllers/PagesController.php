<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieGenreResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Models\MovieGenre;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PagesController
{
    /**
     * Display a listing of the movies.
     */
    public function index(Request $request): Response
    {
        $genre = $request->query('movie_genre', '');
        $term = $request->query('term');

        $movies = Movie::query()
            ->when(is_numeric($genre), fn (Builder $q): Builder => $q->searchByGenre((int) $genre))
            ->unless(empty($term), fn (Builder $q): Builder => $q->searchByTerm($term))
            ->paginate(12)
            ->appends(['movie_genre' => $genre, 'term' => $term]);

        $genres = MovieGenre::query()->has('movies')->get();

        return Inertia::render('Welcome', [
            'movies' => MovieResource::collection($movies),
            'genres' => MovieGenreResource::collection($genres),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'movie_genre' => $genre,
            'term' => $term,
        ]);
    }

    /**
     * Show the details page for the specified movie.
     */
    public function showMovie(Movie $movie): Response
    {
        $movie->load(['genres']);

        return Inertia::render('Movies/Show', [
            'movie' => new MovieResource($movie),
        ]);
    }
}
