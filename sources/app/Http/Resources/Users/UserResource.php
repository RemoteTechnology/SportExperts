<?php

namespace App\Http\Resources\Users;

use App\Domain\Constants\EnumConstants\RoleEnum;
use App\Models\Option;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

require_once dirname(__DIR__, 3) . '/Domain/Constants/EntitiesConst.php';
require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = [
            FIELD_ID                => $this->id,
            FIELD_FIRST_NAME        => $this->first_name,
            FIELD_FIRST_NAME_ENG    => $this->first_name_eng,
            FIELD_LAST_NAME         => $this->last_name,
            FIELD_LAST_NAME_ENG     => $this->last_name_eng,
            FIELD_BIRTH_DATE        => $this->birth_date,
            FIELD_GENDER            => $this->gender,
            FIELD_EMAIL             => $this->email,
            FIELD_PHONE             => $this->phone,
            FIELD_LOCATION          => $this->location,
            FIELD_ROLE              => $this->role,
        ];

        if ($this->role === RoleEnum::ATHLETE->value)
        {
            $user[TABLE_OPTIONS] = Option::where([FIELD_USER_ID => $this->id])->get();
            $user[FIELD_AGE] = !is_null($user[FIELD_BIRTH_DATE]) ? Carbon::parse($user[FIELD_BIRTH_DATE])->age : null;
        }

        $user[FIELD_CREATED_AT] = $this->created_at;
        $user[FIELD_UPDATED_AT] = $this->updated_at;
        return $user;
    }
}
