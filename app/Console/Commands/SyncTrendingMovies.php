<?php

namespace App\Console\Commands;

use App\Models\Movie;
use App\Services\Tmbd\TmbdApi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
     */
    public function handle(TmbdApi $api): int
    {
        $this->comment('Syncing the trending movies...');

        $pages = (int) $this->argument('pages');

        $success = DB::transaction(function () use ($api, $pages): bool {
            // Delete all the old movies records
            Movie::query()->delete();

            // Import the new movies records
            foreach (range(1, $pages) as $page) {
                $response = $api->getTrendingMovies(page: $page);
                $this->importMovies($response['results']);
            }

            return true;
        });

        if ($success) {
            $this->info('Syncing was completed successfully!');

            return static::SUCCESS;
        }

        $this->error('Syncing was failed!');

        return static::FAILURE;
    }

    private function importMovies($movies): void
    {
        $query = Movie::query();

        collect($movies)
            ->transform(function ($item): array {
                $item['tmbd_id'] = $item['id'];
                unset($item['id']);

                return $item;
            })
            ->each(function($item) use ($query): void {
                $query->create($item);
            });
    }
}
