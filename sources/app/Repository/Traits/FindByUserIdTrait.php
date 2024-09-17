<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

trait FindByUserIdTrait
{
    /**
     * @param int $user_id
     * @return Model|Collection
     */
    public function findByUserId(int $user_id): Model|Collection
    {
        return $this->model::where([FIELD_USER_ID => $user_id])->get();
    }
}
