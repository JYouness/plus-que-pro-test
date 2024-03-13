<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Contracts\TmbdApiContract;
use App\Models\Movie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class SyncTrendingMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:trending-movies
        {pages=5 : The number of pages to be synced}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize the trending movies';

    /**
     * Execute the console command.
     *
     * @param TmbdApiContract $api
     *
     * @return int
     */
    public function handle(TmbdApiContract $api): int
    {
        $this->comment('Syncing the trending movies...');

        $pages = (int) $this->argument('pages');

        $success = DB::transaction(function () use ($api, $pages): bool {
            // Delete all the old movies records
            Movie::query()->delete();

            // Import the new movies records
            $bar = $this->getOutput()->createProgressBar($pages);
            $bar->start();

            try {
                foreach (range(1, $pages) as $page) {
                    $response = $api->getTrendingMovies(page: $page);
                    $this->importMovies($response['results']);

                    $bar->advance();
                }
            } catch (Throwable) {
                DB::rollBack();

                return false;
            }

            $bar->finish();
            $this->newLine();

            return true;
        });

        if ($success) {
            $this->info('Syncing was completed successfully!');

            return static::SUCCESS;
        }

        $this->error('Syncing was failed!');

        return static::FAILURE;
    }

    /**
     * Import the movies.
     *
     * @param array $movies
     */
    private function importMovies(array $movies): void
    {
        $query = Movie::query();

        collect($movies)
            ->transform(function ($item): array {
                $item['tmbd_id'] = $item['id'];
                unset($item['id']);

                return $item;
            })
            ->each(function ($item) use ($query): void {
                $query->create($item);
            });
    }
}
