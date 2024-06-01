<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\Entities\InvitedRepositoryInterface;
use App\Models\Invited;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Model;

final class InvitedRepository implements InvitedRepositoryInterface
{
    use ListQueryTrait;
    use CreateQueryTrait;
    use ReadQueryTrait;
    use UpdateQueryTrait;
    use DestroyQueryTrait;

    protected Model $model;
    public function __construct(Invited $model = new Invited())
    {
        $this->model = $model;
    }
}
