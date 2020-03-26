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
      'email' => $faker->email,
      'password' => Hash::make('admin'),
      'email_verified_at' => now(),
      'remember_token' => Str::random(10),
      'type' => '1',
      'role' => '1',
    ]);
    DB::table('users')->insert([
      'email' => $faker->email,
      'password' => Hash::make('admin'),
      'email_verified_at' => now(),
      'remember_token' => Str::random(10),
      'type' => '2',
      'role' => '2',
    ]);
    DB::table('users')->insert([
      'email' => $faker->email,
      'password' => Hash::make('admin'),
      'email_verified_at' => now(),
      'remember_token' => Str::random(10),
      'type' => '1',
      'role' => '2',
    ]);
    DB::table('users')->insert([
      'email' => $faker->email,
      'password' => Hash::make('admin'),
      'email_verified_at' => now(),
      'remember_token' => Str::random(10),
      'type' => '2',
      'role' => '2',
    ]);
    DB::table('users')->insert([
      'email' => $faker->email,
      'password' => Hash::make('admin'),
      'email_verified_at' => now(),
      'remember_token' => Str::random(10),
      'type' => '1',
      'role' => '1',
    ]);
    DB::table('users')->insert([
      'email' => $faker->email,
      'password' => Hash::make('admin'),
      'email_verified_at' => now(),
      'remember_token' => Str::random(10),
      'type' => '2',
      'role' => '2',
    ]);    
  }
}
