<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Collection;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

trait FindByUserIdQueryTrait
{
    public function userList(int $event_id): Collection
    {
        return $this->eloquentQuery()->where([FIELD_EVENT_ID => $event_id])->get();
    }
}
