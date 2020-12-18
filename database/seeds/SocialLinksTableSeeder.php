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
      $faker = Faker\Factory::create();
      DB::table('social_links')->insert([
        'facebook' => $faker->word,
        'instagram' => $faker->word,
        'twitter' => $faker->word,
        'website' => $faker->word,
        'youtube' => $faker->word,
        'performer_id' => '1',
      ]);
      DB::table('social_links')->insert([
        'facebook' => $faker->word,
        'instagram' => $faker->word,
        'twitter' => $faker->word,
        'website' => $faker->word,
        'youtube' => $faker->word,
        'venue_id' => '2',
      ]);
      DB::table('social_links')->insert([
        'facebook' => $faker->word,
        'instagram' => $faker->word,
        'twitter' => $faker->word,
        'website' => $faker->word,
        'youtube' => $faker->word,
        'performer_id' => '2',
      ]);
      DB::table('social_links')->insert([
        'facebook' => $faker->word,
        'instagram' => $faker->word,
        'twitter' => $faker->word,
        'website' => $faker->word,
        'youtube' => $faker->word,
        'venue_id' => '1',
      ]);
    }
}
