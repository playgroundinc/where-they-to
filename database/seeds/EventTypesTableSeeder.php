<?php

use Illuminate\Database\Seeder;

class EventTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //      
      DB::table('event_types')->insert([
        'name' => Str::random(10),
      ]);
      DB::table('event_types')->insert([
        'name' => Str::random(10),
      ]);
    }
}
