<?php

namespace App\Http\Resources\Options;

use App\Http\Resources\Events\EventResource;
use App\Http\Resources\Participants\ParticipantResource;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

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
            FIELD_ID                => $this->id,
            FIELD_EVENT_KEY         => $this->event_key,
            FIELD_PARTICIPANT_KEY   => $this->participant_key,
            FIELD_ENTITY            => $this->entity,
            FIELD_NAME              => $this->name,
            FIELD_VALUE             => $this->value,
            FIELD_TYPE              => $this->type,
            FIELD_CREATED_AT        => $this->created_at,
            FIELD_UPDATED_AT        => $this->updated_at,
            FIELD_DELETED_AT        => $this->deleted_at,
        ];
    }
}
