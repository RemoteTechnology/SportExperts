<?php

namespace App\Http\Resources\Inviteds;

use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvitedResource extends JsonResource
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
            'who_user_id' => $this->who_user_id,
            'who_user' => new UserResource(User::find($this->who_user_id)),
            'user' => new UserResource(User::find($this->user_id)),
        ];
    }
}
