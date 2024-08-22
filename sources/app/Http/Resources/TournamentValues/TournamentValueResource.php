<?php

namespace App\Http\Resources\TournamentValues;

use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $participants_A = Participant::where(['key' => $this->participants_A])->first();
        $participants_B = Participant::where(['key' => $this->participants_B])->first();
        return [
            'id'                    => $this->id,
            'tournament_id'         => $this->tournament_id,
            'participants_A'        => $participants_A,
            'participants_B'        => $participants_B,
            'participants_passes'   => $this->participants_passes,
            'users'                 => [
                $participants_A ? User::find($participants_A->user_id) : null,
                $participants_B ? User::find($participants_B->user_id) : null,
            ],
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
        ];
    }
}
