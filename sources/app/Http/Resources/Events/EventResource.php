<?php

namespace App\Http\Resources\Events;

use App\Http\Resources\FileResource;
use App\Http\Resources\Participants\ParticipantCollection;
use App\Http\Resources\Participants\ParticipantResource;
use App\Http\Resources\TournamentAdmin\TournamentAdminResource;
use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\UserResource;
use App\Models\File;
use App\Models\Option;
use App\Models\Participant;
use App\Models\Tournament;
use App\Models\TournamentAdmin;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Js;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class EventResource extends JsonResource
{
    private function getParticipantCollection(int $eventId): array
    {
        $participants = [];
        foreach (Participant::where([FIELD_EVENT_ID => $this->id])->get() as $value)
        {
            $participants[] = User::find($value->user_id);
        }
        return $participants;
    }

    /**
     * @param Collection $attributes
     * @return array
     */
    private function getTournamentAdminUsers(Collection $attributes): array
    {
        foreach ($attributes as $item)
        {
            $collection[] = User::find($item->user_id);
        }
        return $collection ?? [];
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tournament = Tournament::where([FIELD_EVENT_KEY => $this->key])->first();
        $admins = $this->getTournamentAdminUsers(TournamentAdmin::where([FIELD_TOURNAMENT_ID => $tournament->id])->get());
        return [
            FIELD_ID                => $this->id,
            FIELD_KEY               => $this->key,
            FIELD_NAME              => $this->name,
            FIELD_DESCRIPTION       => $this->description,
            FIELD_START_DATE        => $this->start_date,
            FIELD_START_TIME        => $this->start_time,
            FIELD_EXPIRATION_DATE   => $this->expiration_date,
            FIELD_EXPIRATION_TIME   => $this->expiration_time,
            FIELD_LOCATION          => $this->location,
            FIELD_STATUS            => $this->status,
            FIELD_OWNER             => new UserResource(User::find($this->user_id)),
            FIELD_ADMINS            => $admins,
            FIELD_IMAGE             => new FileResource(File::where([FIELD_KEY => $this->image])->first()),
            FIELD_OPTIONS           => Option::where([FIELD_EVENT_KEY => $this->key])->get(),
            FIELD_PARTICIPANTS      => $this->getParticipantCollection($this->id),
            FIELD_CREATED_AT        => $this->created_at,
            FIELD_UPDATED_AT        => $this->updated_at,
        ];
    }
}
