<?php

namespace Database\Seeders;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvitedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $who_user_id = 2;
        foreach (User::where(['role' => 'athlete'])->limit(5)->get() as $athlete)
        {
            Invite::create([
                'who_user_id' => $who_user_id,
                'user_id' => $athlete->id
            ]);
        }
    }
}
