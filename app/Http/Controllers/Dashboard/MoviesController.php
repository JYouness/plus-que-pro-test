<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Movies\CreateMovieRequest;
use App\Http\Requests\Movies\UpdateMovieRequest;
use App\Http\Resources\MovieGenreResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Models\MovieGenre;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class MoviesController
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
        $genre = $request->query('movie_genre', '');
        $term = $request->query('term');

        $movies = Movie::query()
            ->when(is_numeric($genre), fn (Builder $q): Builder => $q->searchByGenre((int) $genre))
            ->unless(empty($term), fn (Builder $q): Builder => $q->searchByTerm($term))
            ->paginate(12)
            ->appends(['movie_genre' => $genre, 'term' => $term]);

        $genres = MovieGenre::query()->has('movies')->get();

        return Inertia::render('Dashboard/Movies/Index', [
            'movies' => MovieResource::collection($movies),
            'genres' => MovieGenreResource::collection($genres),
            'movieGenre' => $genre,
            'term' => $term,
        ]);
    }

    /**
     * Show the details page for the specified movie.
     *
     * @param Movie $movie
     */
    public function show(Movie $movie): InertiaResponse
    {
        $movie->load(['genres']);

        return Inertia::render('Dashboard/Movies/Show', [
            'movie' => new MovieResource($movie),
        ]);
    }

    /**
     * Show the form for creating a new movie.
     */
    public function create(): InertiaResponse
    {
        $genres = MovieGenre::query()->get();
        $languages = $this->getMovieLanguages();

        return Inertia::render('Dashboard/Movies/Create', [
            'genres' => MovieGenreResource::collection($genres),
            'languages' => $languages,
        ]);
    }

    /**
     * Store a newly created movie.
     *
     * @param CreateMovieRequest $request
     */
    public function store(CreateMovieRequest $request): RedirectResponse
    {
        sleep(1); // Just to simulate the processing time

        $data = array_merge($request->validated(), [
            // Default data
            'tmbd_id' => rand(10000, 99999),
            'original_title' => $request->get('original_title') ?: $request->get('title'),
            'media_type' => 'movie',
        ]);

        $movie = Movie::query()->create($data);

        return redirect()
            ->route('dashboard.movies.show', ['movie' => $movie])
            ->with('message', 'New movie added successfully!');
    }

    /**
     * Show the form for editing the specified movie.
     *
     * @param Movie $movie
     */
    public function edit(Movie $movie): InertiaResponse
    {
        $movie->load('genres');
        $genres = MovieGenre::query()->get();
        $languages = $this->getMovieLanguages();

        return Inertia::render('Dashboard/Movies/Edit', [
            'movie' => new MovieResource($movie),
            'genres' => MovieGenreResource::collection($genres),
            'languages' => $languages,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMovieRequest $request
     * @param Movie              $movie
     */
    public function update(UpdateMovieRequest $request, Movie $movie): RedirectResponse
    {
        sleep(1); // Just to simulate the processing time

        $data = array_merge($request->validated(), [
            // Default data
            'original_title' => $request->get('original_title') ?: $request->get('title'),
        ]);

        $movie->update($data);

        return redirect()
            ->route('dashboard.movies.show', ['movie' => $movie])
            ->with('message', 'Movie updated successfully!');
    }

    /**
     * Delete the specified movie.
     *
     * @param Movie $movie
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        $movie->delete();

        return redirect()
            ->route('dashboard.movies.index')
            ->with('message', 'Movie deleted successfully!');
    }

    /**
     * Get the movie's languages.
     *
     * @return array<string, string>
     */
    private function getMovieLanguages(): array
    {
        return [
            'en' => 'English',
            'fr' => 'French',
            'es' => 'Spanish',
            'ar' => 'Arabic',
            //...
        ];
    }
}
