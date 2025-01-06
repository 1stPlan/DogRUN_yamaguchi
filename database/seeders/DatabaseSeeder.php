<?php

namespace Database\Seeders;

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
        $this->call([
            UsersTableSeeder::class,
            AdminsTableSeeder::class,
            PlacesTableSeeder::class,
            QuestionSetTableSeeder::class,
            QuestionsTableSeeder::class,
            QuestionTextTableSeeder::class,
            EventTableSeeder::class,
            EventSearchCategoryTableSeeder::class,
            EventSearchTableSeeder::class,
            EventPostTableSeeder::class,
        ]);
    }
}
