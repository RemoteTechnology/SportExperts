<?php

namespace App\Repository\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

trait FilterTrait
{
    /**
     * @param mixed $attributes
     * @param bool $sorted
     * @param string $mode
     * @return Collection|Model|null
     */
    public function query(mixed $attributes, bool $sorted=false, string $mode='one'): Collection|Model|null
    {
        $user = $this->eloquentQuery()->where($attributes);
        return $mode === 'one' ? $user->first() : $user;
    }
}
