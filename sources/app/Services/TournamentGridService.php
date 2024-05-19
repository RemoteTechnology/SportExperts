<?php

namespace App\Services;

use App\Domain\Interfaces\Repositories\Entities\TournamentRepositoryInterface;
use App\Domain\Interfaces\Repositories\Entities\TournamentValueRepositoryInterface;
use App\Domain\Interfaces\Services\Tournament\TournamentServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class TournamentGridService implements TournamentServiceInterface
{
    protected TournamentRepositoryInterface $tournamentRepository;
    protected TournamentValueRepositoryInterface $tournamentValueRepository;
    public function __construct(
        TournamentRepositoryInterface $tournamentRepository,
        TournamentValueRepositoryInterface $tournamentValueRepository
    )
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->tournamentValueRepository = $tournamentValueRepository;
    }
    public function aOlympicDraw(Collection $participants): Collection
    {
        // TODO: Implement aOlympicDraw() method.
    }

    public function aCustomDraw(Collection $participants): Collection
    {
        // TODO: Implement aCustomDraw() method.
    }

    public function init(string $schema): array
    {
        // TODO: Implement init() method.
    }

    public function builder(): Collection
    {
        // TODO: Implement builder() method.
    }
}
