<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AdminNavigationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Navigasi admin sekarang dihandle oleh Blade + MenuHelper (layouts/sidebar)
    }
}
