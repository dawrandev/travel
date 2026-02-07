<?php

namespace Database\Seeders;

use App\Models\ReviewBanner;
use App\Models\Language;
use Illuminate\Database\Seeder;

class ReviewBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = ReviewBanner::create([
            'is_active' => true,
        ]);

        // Create 3 images for the banner
        $imageFiles = ['review-banner-1.jpg', 'review-banner-2.jpg', 'review-banner-3.jpg'];
        foreach ($imageFiles as $index => $imageFile) {
            $banner->images()->create([
                'image_path' => 'uploads/banners/' . $imageFile,
                'sort_order' => $index,
            ]);
        }

        $languages = Language::all();
        foreach ($languages as $language) {
            $banner->translations()->create([
                'lang_code' => $language->code,
                'title' => 'Reviews - ' . $language->name,
            ]);
        }
    }
}
