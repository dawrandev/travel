<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        view()->composer('components.sidebar', function ($view) {
            $pendingBookingsCount = \App\Models\Booking::where('status', 'pending')->count();
            $view->with('pendingBookingsCount', $pendingBookingsCount);
        });

        Paginator::useBootstrapFive();
    }
}
