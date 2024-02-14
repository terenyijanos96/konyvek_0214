<?php

namespace App\Providers;

use App\Models\Lending;
use App\Observers\LendingObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Lending::observe(LendingObserver::class);
    }
}
