<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //
      $faker = Faker\Factory::create();
      DB::table('events')->insert([
        'date' => Carbon::now()->format('Y-m-d'),
        'time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'event_type_id' => '1',
        'venue_id' => '2',
        'family_id' => '1'
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->format('Y-m-d'),
        'time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'date' => '2020-05-15',
        'event_type_id' => '1',
        'venue_id' => '1',
        'family_id' => '2'
      ]);
    }
}
