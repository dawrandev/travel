<?php

namespace Database\Seeders;

use App\Models\AboutBanner;
use App\Models\Language;
use Illuminate\Database\Seeder;

class AboutBannerSeeder extends Seeder
{
    public function run(): void
    {
        // Asosiy banner
        $banner = AboutBanner::create([
            'is_active' => true,
        ]);

        // Rasmlar
        $imageFiles = ['about-banner-1.jpg', 'about-banner-2.jpg', 'about-banner-3.jpg'];
        foreach ($imageFiles as $index => $imageFile) {
            $banner->images()->create([
                'image_path' => 'uploads/banners/' . $imageFile,
                'sort_order' => $index,
            ]);
        }

        // Tarjimalar (Title qismini tarjima bilan saqlash)
        $translations = [
            'uz' => 'Biz haqimizda',
            'ru' => 'О нас',
            'en' => 'About Us',
            'kk' => 'Biz haqqımızda',
        ];

        foreach ($translations as $lang => $title) {
            $banner->translations()->create([
                'lang_code' => $lang,
                'title'     => $title,
            ]);
        }
    }
}
