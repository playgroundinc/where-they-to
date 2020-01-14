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
      DB::table('events')->insert([
        'name' => Str::random(10),
        'description' => Str::random(20),
        'date' => Str::random(10),
        'type' => '1',
        'venue_id' => '2',
        'family_id' => '1'
      ]);
      DB::table('events')->insert([
        'name' => Str::random(10),
        'description' => Str::random(20),
        'date' => Str::random(10),
        'type' => '1',
        'venue_id' => '1',
        'family_id' => '2'
      ]);
    }
}
