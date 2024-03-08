<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Movies\CreateMovieRequest;
use App\Http\Requests\Movies\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class MoviesController
{
    public function index(Request $request): InertiaResponse
    {
        $term = $request->query('term');
        $movies = Movie::query()
            ->when(fn (Builder $query): Builder => $query->whereAny([
                'title',
                'original_title',
            ], 'LIKE', '%'.$term.'%'))
            ->paginate(12)
            ->appends(compact('term'));

        return Inertia::render('Dashboard/Movies/Index', [
            'movies' => MovieResource::collection($movies),
            'term' => $term,
        ]);
    }

    public function show(Movie $movie): InertiaResponse
    {
        return Inertia::render('Dashboard/Movies/Show', [
            'movie' => $movie,
        ]);
    }

    public function create(): InertiaResponse
    {
        $languages = $this->getMovieLanguages();

        return Inertia::render('Dashboard/Movies/Create', [
            'languages' => $languages,
        ]);
    }

    public function store(CreateMovieRequest $request): RedirectResponse
    {
        sleep(1); // Just to simulate the processing time

        $data = array_merge($request->validated(), [
            // Default data
            'tmbd_id' => rand(10000, 99999),
            'original_title' => $request->get('original_title') ?: $request->get('title'),
            'media_type' => 'movie',
            'genre_ids' => [],
        ]);

        $movie = Movie::query()->create($data);

        return redirect()
            ->route('dashboard.movies.show', ['movie' => $movie])
            ->with('message', 'New movie added successfully!');
    }

    public function edit(Movie $movie): InertiaResponse
    {
        $languages = $this->getMovieLanguages();

        return Inertia::render('Dashboard/Movies/Edit', [
            'movie' => $movie,
            'languages' => $languages,
        ]);
    }

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

    public function destroy(Movie $movie): RedirectResponse
    {
        $movie->delete();

        return redirect()
            ->route('dashboard.movies.index')
            ->with('message', 'Movie deleted successfully!');
    }

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
