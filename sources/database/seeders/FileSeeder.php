<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

require_once dirname(__DIR__,2) . '/app/Domain/Constants/PointSeeder.php';

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
        for ($fe=0; $fe < FILE; $fe++)
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
