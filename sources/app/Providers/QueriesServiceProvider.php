<?php

namespace App\Providers;

use App\Domain\Interfaces\Repositories\Entities\EventRepositoryInterface;
use App\Domain\Interfaces\Repositories\Entities\ParticipantRepositoryInterface;
use App\Domain\Interfaces\Repositories\Entities\OptionRepositoryInterface;
use App\Domain\Interfaces\Repositories\Entities\TeamRepositoryInterface;
use App\Domain\Interfaces\Repositories\Entities\UserRepositoryInterface;
use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Repository\EventRepository;
use App\Repository\ParticipantRepository;
use App\Repository\OptionRepository;
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
        ParticipantRepositoryInterface::class => ParticipantRepository::class,
        OptionRepositoryInterface::class => OptionRepository::class,
    ];

    /**
     * @var array
     */
    public $singletons = [];
}
