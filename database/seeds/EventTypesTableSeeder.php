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
      $faker = Faker\Factory::create();
      DB::table('event_types')->insert([
        'name' => $faker->word,
      ]);
      DB::table('event_types')->insert([
        'name' => $faker->word,
      ]);
    }
}
