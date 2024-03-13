<?php

declare(strict_types=1);

namespace Models;

use App\Models\Movie;
use Database\Factories\MovieFactory;
use Database\Factories\MovieGenreFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;
use Tests\TestCase;

/**
 * @see \App\Models\Movie
 */
class MovieTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_can_set_and_get_poster_url(): void
    {
        $movie = MovieFactory::new()->make();

        static::assertNull($movie->poster_path);
        static::assertSame(url('assets/svg/default.svg'), $movie->poster_url);

        $movie->poster_path = $image = 'image/dummy-1234567890.jpg';

        static::assertSame($image, $movie->poster_path);
        static::assertSame("https://image.tmdb.org/t/p/w500/{$image}", $movie->poster_url);
    }

    public function test_can_set_and_get_backdrop_url(): void
    {
        $movie = MovieFactory::new()->make();

        static::assertNull($movie->backdrop_path);
        static::assertSame(url('assets/svg/default.svg'), $movie->backdrop_url);

        $movie->backdrop_path = $image = 'image/dummy-1234567890.jpg';

        static::assertSame($image, $movie->backdrop_path);
        static::assertSame("https://image.tmdb.org/t/p/w500/{$image}", $movie->backdrop_url);
    }

    public function test_can_query_genre_relationship_as_a_json_column(): void
    {
        $movie = MovieFactory::new()->create();

        static::assertInstanceOf(BelongsToJson::class, $movie->genres());

        $genres = $movie->genres;

        static::assertInstanceOf(Collection::class, $genres);
        static::assertCount(0, $genres);
    }

    public function test_can_add_and_get_genres_records(): void
    {
        $genres = MovieGenreFactory::times(5)->create();
        $genresIds = $genres->take(3)->pluck('tmbd_id')->toArray();

        $movie = MovieFactory::new()->create(['genre_ids' => $genresIds]);

        $movie->load('genres');

        static::assertInstanceOf(Collection::class, $movie->genres);
        static::assertCount(3, $movie->genres);
        static::assertEquals($genresIds, $movie->genres->pluck('tmbd_id')->toArray());
    }

    public function test_can_apply_a_scope_to_search_by_a_genre(): void
    {
        $genreOne = MovieGenreFactory::new()->create();
        $genreTwo = MovieGenreFactory::new()->create();
        $genreThree = MovieGenreFactory::new()->create(); // 3rd genre, shouldn't be in results

        MovieFactory::new()->create(['genre_ids' => [$genreOne->id]]);
        MovieFactory::new()->create(['genre_ids' => [$genreTwo->id]]);
        MovieFactory::new()->create(['genre_ids' => [$genreOne->id, $genreTwo->id]]);
        MovieFactory::new()->create(['genre_ids' => [$genreThree->id]]);

        foreach ([$genreOne, $genreTwo] as $genre) {
            /** @var \Illuminate\Database\Eloquent\Collection $results */
            $results = Movie::query()->searchByGenre($genre->id)->get();

            static::assertCount(2, $results);
            $results->each(function (Movie $movie) use ($genre, $genreThree): void {
                static::assertTrue(in_array($genre->id, $movie->genre_ids));
                static::assertFalse(in_array($genreThree->id, $movie->genre_ids));
            });
        }
    }

    public function test_can_apply_a_scope_to_search_by_a_term(): void
    {
        MovieFactory::times(5)->create();
        MovieFactory::new()->create(['title' => 'The Animatrix']);
        MovieFactory::new()->create(['original_title' => 'Akira']);

        static::assertSame(7, Movie::query()->count());

        // Search by title
        static::assertSame(1, Movie::query()->searchByTerm('Animatrix')->count());
        // Search by original title
        static::assertSame(1, Movie::query()->searchByTerm('Akira')->count());
    }
}
