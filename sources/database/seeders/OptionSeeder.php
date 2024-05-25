<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Option;
use App\Models\Participant;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $i = 0;
        while ($i < 10000)
        {
            $event = Event::find($i+1);
            $participant = Participant::find($i+1);
            Option::create([
                'event_key' => $i < 5000 ? $event->key : null,
                'participant_key' => $i > 5000 ? $participant->key : null,
                'entity' => ['event', 'event_user'][array_rand(['event', 'event_user'])],
                'name' => fake()->name(),
                'value' => fake()->name(),
                'type' => ['string', 'integer', 'boolean'][array_rand(['string', 'integer', 'boolean'])],
            ]);
            $i++;
        }
    }
}
