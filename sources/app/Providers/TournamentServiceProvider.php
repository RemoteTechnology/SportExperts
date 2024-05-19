<?php

namespace App\Providers;

use App\Domain\Interfaces\Services\Tournament\TournamentServiceInterface;
use App\Services\TournamentGridService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class TournamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TournamentServiceInterface::class, function (Application $app) {
            return new TournamentGridService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * @return \class-string[]
     */
    public function provides(): array
    {
        return [TournamentGridService::class];
    }
}
