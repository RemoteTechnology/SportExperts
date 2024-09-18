<?php

namespace App\Http\Resources\Teams;

use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 3) . '/Domain/Constants/EntitiesConst.php';

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            FIELD_ID            => $this->id,
            FIELD_KEY           => $this->key,
            FIELD_NAME          => $this->name,
            FIELD_DESCRIPTION   => $this->description,
            FIELD_LOCATION      => $this->location,
            TABLE_USERS         => new UserResource(User::find($this->user_id)),
//            'image' => new FileResource(File::where(['key' => $this->key])->first()),
            FIELD_CREATED_AT    => $this->created_at,
            FIELD_UPDATED_AT    => $this->updated_at,
        ];
    }
}
