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

class InvitedResource extends JsonResource
{
    private function setParticipants(array &$response, int $user_id): void
    {
        $response['participants'] = Participant::where(['user_id' => $user_id])->get();
        $response['events'] = [];
        foreach ($response['participants'] as $participant)
        {
            $response['events'][] = Event::find($participant->event_id);
        }
    }

    private function setOptions(array &$response): void
    {
        $response['options'] = [];
        foreach ($response['events'] as $event)
        {
            $response['options'][] = Option::where(['event_key' => $event->key])->get();
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
            'id' => $this->id,
            'who_user_id' => $this->who_user_id,
            'who_user' => new UserResource(User::find($this->who_user_id)),
            'user' => new UserResource(User::find($this->user_id)),
        ];
        if (!is_null($response['user'])) $this->setParticipants($response, $this->user_id);
        if (key_exists('enable_events', $request->toArray()) && (boolean)$request->toArray()['enable_events'])
        {
            if (!is_null($response['user'])) $this->setParticipants($response, $this->user_id);
        }
        $this->setOptions($response);
        return $response;
    }
}
