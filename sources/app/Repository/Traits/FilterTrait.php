<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

trait FilterTrait
{
    /**
     * @param mixed $attributes
     * @param bool $sorted
     * @param string $mode
     * @return Collection|Model
     */
    public function query(mixed $attributes, bool $sorted=false, string $mode='one'): Collection|Model
    {
        $user = $this->eloquentQuery()->where($attributes);
        return $mode === 'one' ? $user->first() : $user;
    }
}
