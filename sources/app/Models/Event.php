<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'key',
        'name',
        'description',
        'image',
        'start_date',
        'start_time',
        'expiration_date',
        'expiration_time',
        'location',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
