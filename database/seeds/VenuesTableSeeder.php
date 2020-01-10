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
        
      DB::table('venues')->insert([
        'name' => Str::random(10),
        'address' => Str::random(10),
        'city' => Str::random(10),
        'description' => Str::random(20),
        'user_id' => '1',
      ]);
      DB::table('venues')->insert([
        'name' => Str::random(10),
        'address' => Str::random(10),
        'city' => Str::random(10),
        'description' => Str::random(20),
        'user_id' => '2',
      ]);
    }
}
