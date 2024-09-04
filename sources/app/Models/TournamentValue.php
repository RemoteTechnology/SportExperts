<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

require_once dirname(__DIR__, 2) . '/app/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 2) . '/app/Domain/Constants/EntitiesConst.php';

class TournamentValue extends Model
{
    use HasFactory;

    protected $table = TABLE_TOURNAMENT_VALUES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        FIELD_TOURNAMENT_ID,
        FIELD_PARTICIPANTS_A,
        FIELD_PARTICIPANTS_B,
        FIELD_PARTICIPANTS_PASSES,
        FIELD_CREATED_AT,
        FIELD_UPDATED_AT,
        FIELD_DELETED_AT,
    ];

    /**
     * @var string[]
     */
    protected $appends = ['recorded_in'];

    public function getRecordedInAttribute()
    {
        if ($this->participants_A === $this->attributes['participants_key']) {
            return 'participants_A';
        }
        if ($this->participants_B === $this->attributes['participants_key']) {
            return 'participants_B';
        }
        return null;
    }
}
