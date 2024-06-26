<?php

namespace App\Domain\Interfaces\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;

interface SearchRepositoryInterface
{
    public function search(array $attributes): Model|Exception;
}
