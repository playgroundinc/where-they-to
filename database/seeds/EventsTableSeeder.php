<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventsTableSeeder extends Seeder
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
      DB::table('events')->insert([
        'date' => Carbon::now(),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '2',
        'family_id' => '1',
        'user_id' => '1',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now(),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '2',
        'family_id' => '1',
        'user_id' => '1',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(2),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(2),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(2),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(2),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(3),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(3),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(3),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(3),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(4),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(4),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(4),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(5),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(5),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(5),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(5),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(6),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(6),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(6),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
      DB::table('events')->insert([
        'date' => Carbon::now()->addDay(7),
        'show_time' => '10:00pm',
        'name' => $faker->word,
        'description' => $faker->text,
        'venue_id' => '1',
        'family_id' => '2',
        'user_id' => '2',
      ]);
    }
}
