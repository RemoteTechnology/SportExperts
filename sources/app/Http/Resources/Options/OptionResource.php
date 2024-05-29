<?php

namespace App\Http\Resources\Options;

use App\Http\Resources\Events\EventResource;
use App\Http\Resources\Participants\ParticipantResource;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
            'entity' => $this->entity,
            'name' => $this->name,
            'value' => $this->value,
            'type' => $this->type,
            'event' => new EventResource(Event::where(['key' => $this->event_key])->first()),
            'participant' => new ParticipantResource(Participant::where(['key' => $this->participant_key])->first()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
