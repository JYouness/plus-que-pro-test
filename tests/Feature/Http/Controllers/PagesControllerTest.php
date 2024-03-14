<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use Database\Factories\MovieFactory;
use Database\Factories\MovieGenreFactory;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Collection;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PagesControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_can_view_movies()
    {
        MovieGenreFactory::times(3)->create();
        MovieFactory::times(6)->create([
            'genre_ids' => [MovieGenreFactory::new()->create()->tmbd_id],
        ]);
        MovieFactory::times(4)->create([
            'genre_ids' => [MovieGenreFactory::new()->create()->tmbd_id],
        ]);

        $this->get('/')
            ->assertInertia(fn (Assert $page): Assert => $page
                ->component('Welcome')
                ->has('movies.data', 10)
                ->has('genres.data', 2));
    }

    public function test_can_view_a_movie_details()
    {
        $movie = MovieFactory::new()->create([
            'genre_ids' => [MovieGenreFactory::new()->create()->tmbd_id],
        ]);

        $movie->refresh();

        $this->get(route('public.movies.show', [$movie]))
            ->assertInertia(fn (Assert $page): Assert => $page
                ->component('Movies/Show')
                ->where('movie.data', function (Collection $data) use ($movie): bool {
                    static::assertSame($movie->id, $data->get('id'));
                    static::assertSame($movie->title, $data->get('title'));

                    return true; // If all the asserts passed without any issue
                }));
    }
}
