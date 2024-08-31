<?php

namespace App\Http\Resources\Events;

use App\Http\Resources\FileResource;
use App\Http\Resources\Participants\ParticipantCollection;
use App\Http\Resources\Participants\ParticipantResource;
use App\Http\Resources\Users\UserResource;
use App\Models\File;
use App\Models\Option;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Js;

class EventResource extends JsonResource
{
    private function getParticipantCollection(int $eventId): array
    {
        $participants = [];
        foreach (Participant::where(['event_id' => $this->id])->get() as $value)
        {
            $participants[] = User::find($value->user_id);
        }
        return $participants;
    }
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
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'expiration_date' => $this->expiration_date,
            'expiration_time' => $this->expiration_time,
            'location' => $this->location,
            'status' => $this->status,
            'owner' => new UserResource(User::find($this->user_id)),
            'image' => new FileResource(File::where(['key' => $this->image])->first()),
            'options' => Option::where(['event_key' => $this->key])->get(),
            'participants' => $this->getParticipantCollection($this->id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
