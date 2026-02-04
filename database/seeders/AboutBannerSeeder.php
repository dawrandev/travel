<?php

namespace Database\Seeders;

use App\Models\AboutBanner;
use App\Models\Language;
use Illuminate\Database\Seeder;

class AboutBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = AboutBanner::create([
            'image' => 'about-banner.jpg',
            'is_active' => true,
        ]);

        $languages = Language::all();
        foreach ($languages as $language) {
            $banner->translations()->create([
                'lang_code' => $language->code,
                'title' => 'About Us - ' . $language->name,
            ]);
        }
    }
}
