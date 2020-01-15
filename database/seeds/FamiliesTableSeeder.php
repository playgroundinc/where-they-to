<?php

use Illuminate\Database\Seeder;

class FamiliesTableSeeder extends Seeder
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
      DB::table('families')->insert([
        'name' => $faker->lastName,
        'description' => $faker->text,
      ]);
      DB::table('families')->insert([
        'name' => $faker->lastName,
        'description' => $faker->text,
      ]);
    }
}
