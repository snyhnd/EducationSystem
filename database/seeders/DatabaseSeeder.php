<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClassesTableSeeder::class,
            CurriculumsTableSeeder::class,
            UsersTableSeeder::class,
            CurriculumProgressSeeder::class,
            ArticlesTableSeeder::class,
        ]);
    }
}