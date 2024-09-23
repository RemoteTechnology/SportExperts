<?php

namespace App\Repository\Filter\Entities\Invites;

use App\Domain\Abstracts\Repositories\AbstractEloquentRepository;
use App\Models\InviteModel;
use App\Repository\Traits\InviteUserQueryTrait;
use Illuminate\Database\Eloquent\Model;

class InviteUserFilter extends AbstractEloquentRepository
{
    use InviteUserQueryTrait;
    protected function eloquentQuery(): Model
    {
        return new InviteModel();
    }
}
