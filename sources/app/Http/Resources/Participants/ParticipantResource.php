<?php

namespace App\Http\Resources\Participants;

use App\Http\Resources\Events\EventResource;
use App\Http\Resources\Teams\TeamResource;
use App\Http\Resources\Users\UserResource;
use App\Models\Event;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 3) . '/Domain/Constants/EntitiesConst.php';

class ParticipantResource extends JsonResource
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
            TABLE_EVENTS        => new EventResource(Event::find($this->event_id)),
            TABLE_USERS         => new UserResource(User::find($this->user_id)),
            TABLE_TEAMS         => new TeamResource(Team::where([FIELD_KEY => $this->team_key])->first()),
            TABLE_INVITES       => new UserResource(User::find($this->invited_user_id)),
            FIELD_CREATED_AT    => $this->created_at,
            FIELD_UPDATED_AT    => $this->updated_at,
        ];
    }
}
