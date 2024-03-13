<?php

declare(strict_types=1);

namespace Models;

use App\Models\Movie;
use Database\Factories\MovieFactory;
use Database\Factories\MovieGenreFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Staudenmeir\EloquentJsonRelations\Relations\HasManyJson;
use Tests\TestCase;

/**
 * @see \App\Models\MovieGenre
 */
class MovieGenreTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_can_query_genre_relationship_as_a_json_column(): void
    {
        $genre = MovieGenreFactory::new()->create();

        static::assertInstanceOf(HasManyJson::class, $genre->movies());

        $movies = $genre->movies;

        static::assertInstanceOf(Collection::class, $movies);
        static::assertCount(0, $movies);
    }

    public function test_can_add_and_get_movies_records(): void
    {
        $genre = MovieGenreFactory::new()->create();

        static::assertSame(0, $genre->movies()->count());

        MovieFactory::times(10)->create(['genre_ids' => [$genre->tmbd_id]]);
        // Make sure this second one isn't included in results
        MovieFactory::times(10)->create(['genre_ids' => [MovieGenreFactory::new()->create()->tmbd_id]]);

        $movies = $genre->movies()->with(['genres'])->get();

        static::assertSame(10, $movies->count());

        $movies->each(function ($movie) use ($genre): void {
            static::assertInstanceOf(Movie::class, $movie);
            static::assertInstanceOf(Collection::class, $movie->genres);
            static::assertCount(1, $movie->genres);
            static::assertSame($genre->tmbd_id, $movie->genres->first()->tmbd_id);
        });

    }
}
