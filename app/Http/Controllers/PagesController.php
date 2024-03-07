<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Foundation\Application;
use Inertia\Inertia;
use Inertia\Response;

class PagesController
{
    public function index(): Response
    {
        $movies = Movie::query()->paginate(12);

        return Inertia::render('Welcome', [
            'movies' => MovieResource::collection($movies),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function showMovie(Movie $movie): Response
    {
        return Inertia::render('Movies/Show', [
            'movie' => $movie,
        ]);
    }
}
