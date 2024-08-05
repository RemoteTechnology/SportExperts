<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

require_once dirname(__DIR__,2) . '/app/Domain/Constants/PointSeeder.php';

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $i = 0;
        while ($i < TEAM)
        {
            $user = User::find($i+1);
            $file = File::find($i+1);
            Team::create([
                'user_id' => $user->id,
                'key' => Str::uuid()->toString(),
                'name' => fake('ru')->name(),
                'description' => fake('ru')->text(1000),
                'image' => $file->key,
                'location' => fake()->city()
            ]);
            $i++;
        }
    }
}
