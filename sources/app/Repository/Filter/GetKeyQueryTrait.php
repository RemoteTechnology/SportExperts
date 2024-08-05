<?php

namespace App\Repository\Filter;

use Illuminate\Database\Eloquent\Model;

trait GetKeyQueryTrait
{
    /**
     * @param string $key
     * @return mixed<Model>
     */
    public function getKey(string $key): mixed
    {
        return $this->model::where('key', $key)->first();
    }
}
