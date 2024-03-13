<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\MovieGenreResource;
use App\Models\MovieGenre;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class MovieGenresController
{
    /**
     * Display a listing of the movies.
     *
     * @param Request $request
     *
     * @return InertiaResponse
     */
    public function index(Request $request): InertiaResponse
    {
        $genres = MovieGenre::query()->withCount(['movies'])->get();

        return Inertia::render('Dashboard/MovieGenres/Index', [
            'genres' => MovieGenreResource::collection($genres),
        ]);
    }
}
