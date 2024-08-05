<?php

namespace App\Providers;

use App\Domain\Interfaces\Services\LoggingServiceInterface;
use App\Services\LoggingService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(LoggingServiceInterface::class, function (Application $app) {
            return new LoggingService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
