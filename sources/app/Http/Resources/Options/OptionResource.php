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
            'event_key' => $this->event_key,
            'participant_key' => $this->participant_key,
            'entity' => $this->entity,
            'name' => $this->name,
            'value' => $this->value,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
