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
      DB::table('performers')->insert([
        'name' => Str::random(10),
        'bio' => Str::random(20),
        'user_id' => '1',
        'type' => '0',
        'family_id' => '1',
      ]);
      DB::table('performers')->insert([
        'name' => Str::random(10),
        'bio' => Str::random(20),
        'type' => '0',
        'user_id' => '3',
        'family_id' => '2',
      ]);
      DB::table('performers')->insert([
        'name' => Str::random(10),
        'bio' => Str::random(20),
        'type' => '0',
        'user_id' => '5',
        'family_id' => '1',
      ]);
    }
}
