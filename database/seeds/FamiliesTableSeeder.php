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
      DB::table('families')->insert([
        'name' => Str::random(10),
        'description' => Str::random(20),
      ]);
      DB::table('families')->insert([
        'name' => Str::random(10),
        'description' => Str::random(20),
      ]);
    }
}
