<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/app/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 2) . '/app/Domain/Constants/EntitiesConst.php';

class Leads extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = TABLE_LEADS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        FIELD_KEY,
        FIELD_ENTITY,
        FIELD_STATUS,
        FIELD_DATA,
        FIELD_CREATED_AT,
        FIELD_UPDATED_AT
    ];
}
