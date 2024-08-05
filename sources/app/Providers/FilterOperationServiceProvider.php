<?php

namespace App\Providers;

use App\Domain\Interfaces\Repositories\Filters\UserFilterRepositoryInterface;
use App\Domain\Interfaces\Repositories\Filters\Users\FindByEmailRepositoryInterface;
use App\Repository\Filter\Entities\Users\FindByEmailRepository;
use App\Repository\Filter\UserFilterRepository;
use Illuminate\Support\ServiceProvider;

class FilterOperationServiceProvider extends ServiceProvider
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
        FindByEmailRepositoryInterface::class => FindByEmailRepository::class,
    ];

    /**
     * @var array
     */
    public $singletons = [];
}
