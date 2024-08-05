<?php

namespace App\Domain\Interfaces\Repositories\Entities;

use Illuminate\Database\Eloquent\Model;

interface EventStatusRepositoryInterface
{
    public function updateStatus(array $attributes, string $status): Model;
}
