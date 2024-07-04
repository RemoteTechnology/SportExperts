<?php

namespace App\Repository\Filter\Entities\Participants;

use App\Domain\Abstracts\Repositories\AbstractEloquentRepository;
use App\Models\Invited;
use App\Repository\Traits\FindByUserIdQueryTrait;
use Illuminate\Database\Eloquent\Model;

class ParticipantIsUserFilter extends AbstractEloquentRepository
{
    use FindByUserIdQueryTrait;
    protected function eloquentQuery(): Model
    {
        return new Invited();
    }
}
