<?php

use Illuminate\Database\Seeder;

class VenuesTableSeeder extends Seeder
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
      DB::table('venues')->insert([
        'name' => $faker->company,
        'address' => $faker->address,
        'city' => $faker->city,
        'description' => $faker->text,
        'user_id' => '2',
      ]);
      DB::table('venues')->insert([
        'name' => $faker->company,
        'address' => $faker->address,
        'city' => $faker->city,
        'description' => $faker->text,
        'user_id' => '4',
      ]);
    }
}
