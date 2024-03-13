<?php

declare(strict_types=1);

namespace Commands;

use App\Contracts\TmbdApiContract;
use App\Models\MovieGenre;
use Database\Factories\MovieGenreFactory;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * @see \App\Console\Commands\SyncMovieGenres
 */
class SyncMovieGenresTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_can_sync_data(): void
    {
        $this->instance(
            TmbdApiContract::class,
            $this->mock(TmbdApiContract::class, function (MockInterface $mock): void {
                $mock->shouldReceive('getMovieGenres')->once()->andReturn([
                    'genres' => MovieGenreFactory::times(10)->make()
                        ->transform(fn (MovieGenre $genre): array => array_merge($genre->toArray(), ['id' => $genre->tmbd_id]))
                        ->toArray(),
                ]);
            })
        );

        $this
            ->artisan('sync:movie-genres')
            ->expectsOutput('Syncing the movie genres...')
            ->expectsOutput('Syncing was completed successfully!')
            ->assertOk();
    }

    public function test_can_handle_failed_sync(): void
    {
        $this->instance(
            TmbdApiContract::class,
            $this->mock(TmbdApiContract::class, function (MockInterface $mock): void {
                $mock->shouldReceive('getMovieGenres')->once()->andReturn([]);
            })
        );

        $this
            ->artisan('sync:movie-genres')
            ->expectsOutput('Syncing the movie genres...')
            ->expectsOutput('Syncing was failed!')
            ->assertFailed();
    }
}
