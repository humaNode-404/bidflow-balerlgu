<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use App\Http\Controllers\BackupController;

class AuthServiceProvider extends ServiceProvider
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
        RateLimiter::for('backup-run', function () {
            return Limit::perDay(BackupController::getMaxAttempts())->by('backup-run');
        });
    }
}
