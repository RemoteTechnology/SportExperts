<?php

namespace App\Repository\Filter;

use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

trait GetKeyQueryTrait
{
    /**
     * @param string $key
     * @return mixed<Model>
     */
    public function getKey(string $key): mixed
    {
        return $this->model::where(FIELD_KEY, $key)->first();
    }
}
