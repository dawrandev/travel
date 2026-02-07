<?php

namespace Database\Seeders;

use App\Models\ContactBanner;
use App\Models\Language;
use Illuminate\Database\Seeder;

class ContactBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = ContactBanner::create([
            'is_active' => true,
        ]);

        // Create 3 images for the banner
        $imageFiles = ['contact-banner-1.jpg', 'contact-banner-2.jpg', 'contact-banner-3.jpg'];
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
                'title' => 'Contact Us - ' . $language->name,
            ]);
        }
    }
}
