<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

trait InviteUserQueryTrait
{
    public function filter(int $user_id): Model
    {
        return $this->eloquentQuery()->where([FIELD_USER_ID => $user_id])->first();
    }
}
