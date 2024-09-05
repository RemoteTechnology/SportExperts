<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/app/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 2) . '/app/Domain/Constants/EntitiesConst.php';

class Logs extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = TABLE_LOGS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        FIELD_CURRENT_DATE,
        FIELD_CURRENT_TIME,
        FIELD_METHOD,
        FIELD_STATUS,
        FIELD_REQUEST_DATA,
        FIELD_MESSAGE,
    ];
}
