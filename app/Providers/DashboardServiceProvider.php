<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the dashboard service as a singleton
        $this->app->singleton(\App\Services\DashboardService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Make sure translations are properly loaded
        $this->loadTranslationsFrom(lang_path('en/dashboard.php'), 'dashboard');
        $this->loadTranslationsFrom(lang_path('ar/dashboard.php'), 'dashboard');
    }
}
