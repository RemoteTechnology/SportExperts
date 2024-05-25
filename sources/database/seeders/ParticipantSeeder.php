<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $i = 0;
        $userAdminCount = $i+1;
        while ($i < 10000)
        {
            $y = 400;
            $event = Event::find($i+1);
            $user = User::find($userAdminCount);
            $team = Team::find($y);
            $invitedUser = User::find($y);
             Participant::create([
                 'event_id' => $event->id,
                 'user_id' => $user->id,
                 'invited_user_id' => $invitedUser->id,
                 'team_key' => $team->key,
                 'key' => Str::uuid()->toString(),
             ]);
            $userAdminCount = $userAdminCount === 400 ? 1 : $userAdminCount + 1;
            $i++;
            $y++;
        }
    }
}
