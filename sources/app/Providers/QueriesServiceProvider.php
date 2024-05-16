<?php

namespace App\Providers;

use App\Domain\Interfaces\Repositories\Entities\EventRepositoryInterface;
use App\Domain\Interfaces\Repositories\Entities\EventUserRepositoryInterface;
use App\Domain\Interfaces\Repositories\Entities\ParametrRepositoryInterface;
use App\Domain\Interfaces\Repositories\Entities\TeamRepositoryInterface;
use App\Domain\Interfaces\Repositories\Entities\UserRepositoryInterface;
use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Repository\EventRepository;
use App\Repository\EventUserRepository;
use App\Repository\ParametrRepository;
use App\Repository\TeamRepository;
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
        UserRepositoryInterface::class => UserRepository::class,
        TeamRepositoryInterface::class => TeamRepository::class,
        EventRepositoryInterface::class => EventRepository::class,
        EventUserRepositoryInterface::class => EventUserRepository::class,
        ParametrRepositoryInterface::class => ParametrRepository::class,
    ];

    /**
     * @var array
     */
    public $singletons = [];
}
