<?php

namespace App\Repository;

use App\Domain\Interfaces\Repositories\Entities\InvitedRepositoryInterface;
use App\Models\Invite;
use App\Repository\Filter\Entities\Invites\InviteUserFilter;
use App\Repository\Traits\CreateQueryTrait;
use App\Repository\Traits\DestroyQueryTrait;
use App\Repository\Traits\ListQueryTrait;
use App\Repository\Traits\ReadQueryTrait;
use App\Repository\Traits\UpdateQueryTrait;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__) . '/Domain/Constants/FieldConst.php';

final class InvitedRepository extends InviteUserFilter implements
    InvitedRepositoryInterface
{
    use ListQueryTrait;
    use CreateQueryTrait;
    use ReadQueryTrait;
    use UpdateQueryTrait;
    use DestroyQueryTrait;

    protected Model $model;
    public function __construct(Invite $model = new Invite())
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function findByUserId(array $attributes): Model
    {
        return $this->model::where([FIELD_USER_ID => $attributes[FIELD_USER_ID]])->first();
    }
}
