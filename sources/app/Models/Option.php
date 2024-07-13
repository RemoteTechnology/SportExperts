<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_key',
        'user_id',
        'entity',
        'name',
        'value',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
