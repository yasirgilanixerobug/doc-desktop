<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Config::set('database.default', 'sqlite');
        // Config::set('database.connections.sqlite.database', database_path('database.sqlite'));
        // \Log::info('DB IN BOOT: ' . Config::get('database.connections.sqlite.database'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require_once app_path('Helpers/Helper.php');
    }
}
