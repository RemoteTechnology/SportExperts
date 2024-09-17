<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

// TODO: использовать ToFieldsSearchQueryTrait, больше не использовать GetByKeyTrait, вырезать его
trait GetByKeyTrait
{
    /**
     * @param string $key
     * @return Model
     */
    public function findByKey(string $key): Model
    {
        return $this->model::where([FIELD_KEY => $key])->first();
    }
}
