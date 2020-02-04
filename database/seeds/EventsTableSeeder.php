<?php

use Illuminate\Database\Seeder;

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
        'name' => $faker->word,
        'description' => $faker->text,
        'date' => '2020-01-15',
        'event_type_id' => '1',
        'venue_id' => '2',
        'family_id' => '1',
        'user_id' => '1',
      ]);
      DB::table('events')->insert([
        'name' => $faker->word,
        'description' => $faker->text,
        'date' => '2020-05-15',
        'event_type_id' => '1',
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
    }
}
