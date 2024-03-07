<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Movies\CreateMovieRequest;
use App\Http\Requests\Movies\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MoviesController
{
    public function index(): Response
    {
        $movies = Movie::query()->paginate(12);

        return Inertia::render('Dashboard/Movies/Index', [
            'movies' => MovieResource::collection($movies),
        ]);
    }

    public function show(Movie $movie): Response
    {
        return Inertia::render('Dashboard/Movies/Show', [
            'movie' => $movie,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Movies/Create');
    }

    public function store(CreateMovieRequest $request): RedirectResponse
    {
        $movie = Movie::query()->create($request->validated());

        return redirect()
            ->route('dashboard.movies.show', ['movie' => $movie])
            ->with('message', 'Movie deleted successfully!');
    }

    public function edit(Movie $movie): Response
    {
        return Inertia::render('Dashboard/Movies/Edit', [
            'movie' => $movie,
        ]);
    }

    public function update(UpdateMovieRequest $request, Movie $movie): RedirectResponse
    {
        $movie->update($request->validated());

        return redirect()
            ->route('dashboard.movies.show', ['movie' => $movie])
            ->with('message', 'Movie updated successfully!');
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        $movie->delete();

        return redirect()
            ->route('dashboard.movies.index')
            ->with('message', 'Movie deleted successfully!');
    }
}
