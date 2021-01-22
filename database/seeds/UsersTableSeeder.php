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
		'email' => 'ky.capstick@gmail.com',
		'password' => Hash::make('password'),
		'email_verified_at' => now(),
		'remember_token' => Str::random(10),
		'role' => '1',
		'province' => 'ON',
		'city' => 'Toronto',
    ]);
    DB::table('users')->insert([
		'email' => $faker->email,
		'password' => Hash::make('admin'),
		'email_verified_at' => now(),
		'remember_token' => Str::random(10),
		'role' => '2',
    ]);
    DB::table('users')->insert([
		'email' => $faker->email,
		'password' => Hash::make('admin'),
		'email_verified_at' => now(),
		'remember_token' => Str::random(10),
		'role' => '2',
    ]);
    DB::table('users')->insert([
		'email' => $faker->email,
		'password' => Hash::make('admin'),
		'email_verified_at' => now(),
		'remember_token' => Str::random(10),
		'role' => '2',
    ]);
    DB::table('users')->insert([
		'email' => $faker->email,
		'password' => Hash::make('admin'),
		'email_verified_at' => now(),
		'remember_token' => Str::random(10),
		'role' => '1',
    ]);
    DB::table('users')->insert([
		'email' => $faker->email,
		'password' => Hash::make('admin'),
		'email_verified_at' => now(),
		'remember_token' => Str::random(10),
		'role' => '2',
    ]);    
  }
}
