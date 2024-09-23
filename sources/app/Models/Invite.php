<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/app/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 2) . '/app/Domain/Constants/EntitiesConst.php';

class InviteModel extends Model
{
    use HasFactory;

    protected $table = TABLE_INVITES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        FIELD_WHO_USER_ID,
        FIELD_USER_ID,
        FIELD_CREATED_AT,
        FIELD_UPDATED_AT,
        FIELD_DELETED_AT,
    ];
}
