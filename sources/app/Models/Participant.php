<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'events_id',
        'users_id',
        'team_key',
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'phone',
        'gender',
        'location',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
