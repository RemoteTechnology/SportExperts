<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Models\TournamentValue;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class TournamentValueRepository implements LCRUD_OperationInterface
{
    use ListQueryTrait;
    use CreateQueryTrait;
    use ReadQueryTrait;
    use UpdateQueryTrait;
    use DestroyQueryTrait;

    protected Model $model;

    public function __construct(TournamentValue $model = new TournamentValue())
    {
        $this->model = $model;
    }

    /**
     * @param string $tournamentKey
     * @return Model
     */
    public function findByTournamentValue(int $tournamentId): Collection
    {
        return $this->model::where(['tournament_id' => $tournamentId])->get();
    }
}
