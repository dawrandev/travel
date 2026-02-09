<?php

namespace Database\Seeders;

use App\Models\ContactBanner;
use Illuminate\Database\Seeder;

class ContactBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = ContactBanner::create([
            'is_active' => true,
        ]);

        $imageFiles = ['contact-banner-1.jpg', 'contact-banner-2.jpg', 'contact-banner-3.jpg'];
        foreach ($imageFiles as $index => $imageFile) {
            $banner->images()->create([
                'image_path' => 'uploads/' . $imageFile,
                'sort_order' => $index,
            ]);
        }

        $translations = [
            'uz' => 'Biz bilan bog‘laning',
            'ru' => 'Свяжитесь с нами',
            'en' => 'Contact Us',
            'kk' => 'Biz benen baylanısıń',
        ];

        foreach ($translations as $lang => $title) {
            $banner->translations()->create([
                'lang_code' => $lang,
                'title'     => $title,
            ]);
        }
    }
}
