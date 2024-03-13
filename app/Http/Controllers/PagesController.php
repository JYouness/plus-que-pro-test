<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
use App\Models\Movie;
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
        $term = $request->query('term');
        $movies = Movie::query()
            ->when(fn (Builder $query): Builder => $query->whereAny([
                'title',
                'original_title',
            ], 'LIKE', '%'.$term.'%'))
            ->paginate(12)
            ->appends(compact('term'));

        return Inertia::render('Welcome', [
            'movies' => MovieResource::collection($movies),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'term' => $term,
        ]);
    }

    /**
     * Show the details page for the specified movie.
     */
    public function showMovie(Movie $movie): Response
    {
        return Inertia::render('Movies/Show', [
            'movie' => $movie,
        ]);
    }
}
