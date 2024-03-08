<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController
{
    public function index(): Response
    {
        $movies = Movie::query()->paginate(5);

        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'movies' => Movie::query()->count(),
            ],
        ]);
    }
}
