<?php

declare(strict_types=1);

namespace Commands;

use App\Contracts\TmbdApiContract;
use App\Models\Movie;
use Database\Factories\MovieFactory;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * @see \App\Console\Commands\SyncTrendingMovies
 */
class SyncTrendingMoviesTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_can_sync_data(): void
    {
        $this->mockApi();

        $this
            ->artisan('sync:trending-movies')
            ->expectsOutput('Syncing the trending movies...')
            ->expectsOutput('Syncing was completed successfully!')
            ->assertOk();
    }

    public function test_can_sync_data_with_pages_argument(): void
    {
        $this->mockApi(pages: 1);

        $this
            ->artisan('sync:trending-movies', ['pages' => 1])
            ->expectsOutput('Syncing the trending movies...')
            ->expectsOutput('Syncing was completed successfully!')
            ->assertOk();
    }

    public function test_can_handle_failed_sync(): void
    {
        $this->instance(
            TmbdApiContract::class,
            $this->mock(TmbdApiContract::class, function (MockInterface $mock): void {
                $mock->shouldReceive('getTrendingMovies')->once()->andReturn([]);
            })
        );

        $this
            ->artisan('sync:trending-movies')
            ->expectsOutput('Syncing the trending movies...')
            ->expectsOutput('Syncing was failed!')
            ->assertFailed();
    }

    /**
     * Mock the API Service.
     *
     * @param int $pages
     */
    private function mockApi(int $pages = 5): void
    {
        $this->instance(
            TmbdApiContract::class,
            $this->mock(TmbdApiContract::class, function (MockInterface $mock) use ($pages): void {
                $mock->shouldReceive('getTrendingMovies')->times($pages)->andReturn([
                    'results' => MovieFactory::times(10)->make()
                        ->transform(fn (Movie $movie): array => array_merge($movie->toArray(), ['id' => $movie->tmbd_id]))
                        ->toArray(),
                ]);
            })
        );
    }
}
