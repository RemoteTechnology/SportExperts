<?php

namespace App\Http\Resources\Events;

use App\Http\Resources\Options\OptionCollection;
use App\Http\Resources\Users\UserResource;
use App\Models\Option;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'expiration_date' => $this->expiration_date,
            'expiration_time' => $this->expiration_time,
            'location' => $this->location,
            'owner' => new UserResource(User::find($this->user_id)),
//            'image' => new FileResource(File::where(['key' => $this->key])->first()),
            // TODO: Сделать нормально
            'options' => Option::where(['event_key' => '1ca9da2f-cfb2-499d-8473-2ca58f2120ed'])->get(),
            'participants' => [],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
