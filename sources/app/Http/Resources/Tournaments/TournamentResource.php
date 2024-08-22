<?php

namespace App\Http\Resources\Tournaments;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'key'           => $this->key,
            'event_key'     => $this->event_key,
            'event'         => Event::where(['key' => $this->event_key])->first(),
            'stage'         => $this->stage,
            'admins'        => [/* TODO: реализовать админов */],
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
