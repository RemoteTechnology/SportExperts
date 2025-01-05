<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

require_once dirname(__DIR__, 2) . '/app/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 2) . '/app/Domain/Constants/EntitiesConst.php';

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = TABLE_USERS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        FIELD_GOOGLE_ID,
        FIELD_FIRST_NAME,
        FIELD_FIRST_NAME_ENG,
        FIELD_LAST_NAME,
        FIELD_LAST_NAME_ENG,
        FIELD_BIRTH_DATE,
        FIELD_GENDER,
        FIELD_EMAIL,
        FIELD_PHONE,
        FIELD_LOCATION,
        FIELD_ROLE,
        FIELD_PASSWORD,
        FIELD_CREATED_AT,
        FIELD_UPDATED_AT,
        FIELD_DELETED_AT,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        FIELD_PASSWORD,
    ];

    public function setBirthDateAttribute($value)
    {
        // Преобразуем формат "DD.MM.YYYY" в "YYYY-MM-DD"
        $this->attributes[FIELD_BIRTH_DATE] = Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
    }
}
