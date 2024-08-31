<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/app/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 2) . '/app/Domain/Constants/EntitiesConst.php';


class Event extends Model
{
    use HasFactory;

    protected $table = TABLE_EVENTS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        FIELD_USER_ID,
        FIELD_KEY,
        FIELD_NAME,
        FIELD_DESCRIPTION,
        FIELD_IMAGE,
        FIELD_START_DATE,
        FIELD_START_TIME,
        FIELD_EXPIRATION_DATE,
        FIELD_EXPIRATION_TIME,
        FIELD_LOCATION,
        FIELD_STATUS,
        FIELD_CREATED_AT,
        FIELD_UPDATED_AT,
        FIELD_DELETED_AT,
    ];
}
