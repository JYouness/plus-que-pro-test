<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\TmbdApiContract;
use App\Services\Tmbd\TmbdApi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TmbdApiContract::class, TmbdApi::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
