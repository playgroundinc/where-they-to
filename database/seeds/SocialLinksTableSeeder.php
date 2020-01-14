<?php

use Illuminate\Database\Seeder;

class SocialLinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //
      DB::table('social_links')->insert([
        'facebook' => Str::random(10),
        'instagram' => Str::random(10),
        'twitter' => Str::random(10),
        'website' => Str::random(20),
        'youtube' => Str::random(20),
        'user_id' => '1',
        'event_id' => '1'
      ]);
      DB::table('social_links')->insert([
        'facebook' => Str::random(10),
        'instagram' => Str::random(10),
        'twitter' => Str::random(10),
        'website' => Str::random(20),
        'youtube' => Str::random(20),
        'user_id' => '2',
      ]);
      DB::table('social_links')->insert([
        'facebook' => Str::random(10),
        'instagram' => Str::random(10),
        'twitter' => Str::random(10),
        'website' => Str::random(20),
        'youtube' => Str::random(20),
        'user_id' => '3',
      ]);
      DB::table('social_links')->insert([
        'facebook' => Str::random(10),
        'instagram' => Str::random(10),
        'twitter' => Str::random(10),
        'website' => Str::random(20),
        'youtube' => Str::random(20),
        'user_id' => '4',
      ]);
    }
}
