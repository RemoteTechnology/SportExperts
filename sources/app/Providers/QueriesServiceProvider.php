<?php

namespace App\Providers;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class QueriesServiceProvider extends ServiceProvider
{
//    /**
//     * Register services.
//     */
//    public function register(): void
//    {
//        //
//    }
//
//    /**
//     * Bootstrap services.
//     */
//    public function boot(): void
//    {
//        //
//    }

    /**
     *
     * @var array
     */
    public $bindings = [
        LCRUD_OperationInterface::class => UserRepository::class,
    ];

    /**
     * @var array
     */
    public $singletons = [];
}
