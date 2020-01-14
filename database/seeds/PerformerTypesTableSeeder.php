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
      DB::table('performer_types')->insert([
        'name' => Str::random(10),
      ]);
      DB::table('performer_types')->insert([
        'name' => Str::random(10),
      ]);
    }
}
