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
    private function setParticipants(array &$response): void
    {
        $response['participants'] = Participant::where(['user_id' => $response['user']['id']])->get();
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
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'who_user_id' => $this->who_user_id,
            'who_user' => new UserResource(User::find($this->who_user_id)),
            'user' => new UserResource(User::find($this->user_id)),
        ];
        if ((boolean)$request->toArray()['enable_events'])
        {
            $this->setParticipants($response);
        }
        $this->setOptions($response);
        return $response;
    }
}
