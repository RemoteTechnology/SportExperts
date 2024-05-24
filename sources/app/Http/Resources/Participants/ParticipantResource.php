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
            'id' => $this->id,
            'key' => $this->key,
            'event' => new EventResource(Event::first($this->event_id)),
            'user' => new UserResource(User::first($this->user_id)),
            'team' => new TeamResource(Team::where(['key' => $this->team_key])->first()),
            'invited_user' => new UserResource(User::first($this->invited_user_id)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
