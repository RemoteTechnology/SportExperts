<?php

namespace App\Repository\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

trait ToFieldsSearchQueryTrait
{
    /**
     * @param array $attributes
     * @return Model|Exception
     */
    public function search(array $attributes): Model|Exception
    {
        return $this->model->where($attributes)->get();
    }
}
