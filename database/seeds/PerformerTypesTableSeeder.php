<?php

use Illuminate\Database\Seeder;

class PerformerTypesTableSeeder extends Seeder
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
      DB::table('performer_types')->insert([
        'name' => $faker->word,
      ]);
      DB::table('performer_types')->insert([
        'name' => $faker->word,
      ]);
    }
}
