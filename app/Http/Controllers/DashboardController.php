<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieGenre;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class DashboardController
{
    /**
     * Display a listing of the movies.
     */
    public function index(): InertiaResponse
    {
        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'movies' => Movie::query()->count(),
                'genres' => MovieGenre::query()->count(),
            ],
        ]);
    }
}
