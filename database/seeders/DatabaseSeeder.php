<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            UserSeeder::class,
            HeroSlideSeeder::class,
            FaqSeeder::class,
            AboutSeeder::class,
            ContactSeeder::class,
            CategorySeeder::class,
            TourSeeder::class,
            ReviewSeeder::class,
            // FeatureSeeder::class,
        ]);
    }
}
