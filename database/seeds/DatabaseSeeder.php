<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
          UsersTableSeeder::class,
          VenuesTableSeeder::class,
          FamiliesTableSeeder::class,
          PerformerTypesTableSeeder::class,
          EventTypesTableSeeder::class,
          EventsTableSeeder::class,
          PerformersTableSeeder::class,
          SocialLinksTableSeeder::class,
        ]);
    }
}
