<?php

namespace Database\Seeders;

use App\Models\User;
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
            AboutSeeder::class,
            AboutBannerSeeder::class,
            ContactSeeder::class,
            ContactBannerSeeder::class,
            CategorySeeder::class,
            TourSeeder::class,
            FaqCategorySeeder::class,
            FaqSeeder::class,
            TourItinerarySeeder::class,
            ReviewSeeder::class,
            ReviewBannerSeeder::class,
            FeatureSeeder::class,
            TourInclusionSeeder::class,
        ]);
    }
}
