<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Contracts\TmbdApiContract;
use App\Models\MovieGenre;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class SyncMovieGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:movie-genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize the movie genres';

    /**
     * Execute the console command.
     *
     * @param TmbdApiContract $api
     *
     * @return int
     */
    public function handle(TmbdApiContract $api): int
    {
        $this->comment('Syncing the movie genres...');

        $success = DB::transaction(function () use ($api): bool {
            // Delete all the old movies records
            MovieGenre::query()->delete();

            try {
                // Import the new movies records
                $data = $api->getMovieGenres();

                $this->importMovieGenres($data['genres']);
            } catch (Throwable) {
                DB::rollBack();

                return false;
            }

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
     * Import the movie's genres.
     *
     * @param array $genres
     */
    private function importMovieGenres(array $genres): void
    {
        $query = MovieGenre::query();

        collect($genres)
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
