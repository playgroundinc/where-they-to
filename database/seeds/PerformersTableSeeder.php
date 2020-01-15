<?php

use Illuminate\Database\Seeder;

class PerformersTableSeeder extends Seeder
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
      DB::table('performers')->insert([
        'name' => $faker->firstName,
        'bio' => $faker->text,
        'user_id' => '1',
        'family_id' => '1',
      ]);
      DB::table('performers')->insert([
        'name' => $faker->firstName,
        'bio' => $faker->text,
        'user_id' => '3',
        'family_id' => '2',
      ]);
      DB::table('performers')->insert([
        'name' => $faker->firstName,
        'bio' => $faker->text,
        'user_id' => '5',
        'family_id' => '1',
      ]);
    }
}
