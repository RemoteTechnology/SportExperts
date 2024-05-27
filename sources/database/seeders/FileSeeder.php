<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($ft=0; $ft < 300; $ft++)
        {
            File::create([
                'key' => Str::uuid()->toString(),
                'name' => 'team_image.png',
                'mime' => 'application/image',
                'size' => 100,
                'extension' => 'png',
            ]);
        }
        for ($fe=0; $fe < 15000; $fe++)
        {
            File::create([
                'key' => Str::uuid()->toString(),
                'name' => 'event_image.png',
                'mime' => 'application/image',
                'size' => 300,
                'extension' => 'png',
            ]);
        }
    }
}
