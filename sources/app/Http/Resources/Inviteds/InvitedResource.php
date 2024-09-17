<?php

namespace App\Http\Resources\Inviteds;

use App\Http\Resources\Events\EventCollection;
use App\Http\Resources\Events\EventResource;
use App\Http\Resources\Participants\ParticipantCollection;
use App\Http\Resources\Users\UserResource;
use App\Models\Event;
use App\Models\Option;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 3) . '/Domain/Constants/EntitiesConst.php';

class InvitedResource extends JsonResource
{
    private function setParticipants(array &$response, int $user_id): void
    {
        $response[TABLE_PARTICIPANTS] = Participant::where([FIELD_USER_ID => $user_id])->get();
        $response[TABLE_EVENTS] = [];
        foreach ($response[TABLE_PARTICIPANTS] as $participant)
        {
            $response[TABLE_EVENTS][] = Event::find($participant->event_id);
        }
    }

    private function setOptions(array &$response): void
    {
        $response[TABLE_OPTIONS] = [];
        foreach ($response[TABLE_EVENTS] as $event)
        {
            $response[TABLE_OPTIONS][] = Option::where([FIELD_EVENT_KEY => $event->key])->get();
        }
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): mixed
    {
        $response = [
            FIELD_ID            => $this->id,
            FIELD_WHO_USER_ID   => $this->who_user_id,
            FIELD_WHO_USER      => new UserResource(User::find($this->who_user_id)),
            TABLE_USERS          => new UserResource(User::find($this->user_id)),
        ];
        if (!is_null($response[TABLE_USERS])) $this->setParticipants($response, $this->user_id);
        if (key_exists(FIELD_ENABLE_EVENT, $request->toArray()) && (boolean)$request->toArray()[FIELD_ENABLE_EVENT])
        {
            if (!is_null($response[TABLE_USERS])) $this->setParticipants($response, $this->user_id);
        }
        $this->setOptions($response);
        return $response;
    }
}
