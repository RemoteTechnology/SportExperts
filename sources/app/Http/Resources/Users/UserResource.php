<?php

namespace App\Http\Resources\Users;

use App\Models\Option;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'first_name_eng' => $this->first_name_eng,
            'last_name' => $this->last_name,
            'last_name_eng' => $this->last_name_eng,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => $this->location,
            'role' => $this->role,
        ];

        if ($this->role === 'athlete')
        {
            $user['options'] = Option::where(['user_id' => $this->id])->get();
            $user['age'] = !is_null($user['birth_date']) ? Carbon::parse($user['birth_date'])->age : null;
        }

        $user['created_at'] = $this->created_at;
        $user['updated_at'] = $this->updated_at;
        return $user;
    }
}
