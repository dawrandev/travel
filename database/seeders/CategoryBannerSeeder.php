<?php

namespace Database\Seeders;

use App\Models\CategoryBanner;
use Illuminate\Database\Seeder;

class CategoryBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = CategoryBanner::create([
            'is_active' => true,
        ]);

        $imageFiles = ['category-banner-1.jpg', 'category-banner-2.jpg', 'category-banner-3.jpg'];
        foreach ($imageFiles as $index => $imageFile) {
            $banner->images()->create([
                'image_path' => 'uploads/' . $imageFile,
                'sort_order' => $index,
            ]);
        }

        $translations = [
            'uz' => 'Kategoriyalar',
            'ru' => 'Категории',
            'en' => 'Categories',
            'kk' => 'Kategoriyalar',
        ];

        foreach ($translations as $lang => $title) {
            $banner->translations()->create([
                'lang_code' => $lang,
                'title'     => $title,
            ]);
        }
    }
}
