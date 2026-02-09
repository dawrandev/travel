<?php

namespace Database\Seeders;

use App\Models\ReviewBanner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = ReviewBanner::create([
            'is_active' => true,
        ]);

        $imageFiles = ['review-banner-1.jpg', 'review-banner-2.jpg', 'review-banner-3.jpg'];
        foreach ($imageFiles as $index => $imageFile) {
            $banner->images()->create([
                'image_path' => 'uploads/' . $imageFile,
                'sort_order' => $index,
            ]);
        }

        $translations = [
            'uz' => 'Mijozlarimiz fikrlari',
            'ru' => 'Отзывы наших клиентов',
            'en' => 'Customer Reviews',
            'kk' => 'Klientlerimizin\' pikirleri',
        ];

        foreach ($translations as $lang => $title) {
            $banner->translations()->create([
                'lang_code' => $lang,
                'title' => $title,
            ]);
        }
    }
}
