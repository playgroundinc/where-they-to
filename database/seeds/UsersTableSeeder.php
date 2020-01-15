<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
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
    DB::table('users')->insert([
      'username' => $faker->userName,
      'email' => $faker->email,
      'password' => $faker->password,
      'type' => '1',
    ]);
    DB::table('users')->insert([
      'username' => $faker->userName,
      'email' => $faker->email,
      'password' => $faker->password,
      'type' => '2',
    ]);
    DB::table('users')->insert([
      'username' => $faker->userName,
      'email' => $faker->email,
      'password' => $faker->password,
      'type' => '1',
    ]);
    DB::table('users')->insert([
      'username' => $faker->userName,
      'email' => $faker->email,
      'password' => $faker->password,
      'type' => '2',
    ]);
    DB::table('users')->insert([
      'username' => $faker->userName,
      'email' => $faker->email,
      'password' => $faker->password,
      'type' => '1',
    ]);
    DB::table('users')->insert([
      'username' => $faker->userName,
      'email' => $faker->email,
      'password' => $faker->password,
      'type' => '2',
    ]);    
  }
}
