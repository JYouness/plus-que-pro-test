<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController
{
    /**
     * Display a listing of the movies.
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'movies' => Movie::query()->count(),
            ],
        ]);
    }
}
