<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'image_path' => 'uploads/hero/aral-sea-1.jpg',
                'translations' => [
                    'uz' => [
                        'subtitle' => 'Orol dengizi',
                        'title' => 'Yo‘qolgan okean qirg‘og‘idagi sarguzashtlar',
                    ],
                    'kk' => [
                        'subtitle' => 'Aral teńizi',
                        'title' => 'Joq bolǵan okean qırǵaǵındaǵı sarguzashtlar',
                    ],
                    'ru' => [
                        'subtitle' => 'Аральское море',
                        'title' => 'Приключение на берегу исчезнувшего океана',
                    ],
                    'en' => [
                        'subtitle' => 'Aral Sea',
                        'title' => 'Adventure on the shores of a vanished ocean',
                    ],
                ]
            ],
            // Agar yana slaydlar bo'lsa shu yerga qo'shish mumkin
        ];

        foreach ($slides as $index => $slide) {
            // 1. Asosiy slaydni yaratish
            $slideId = DB::table('hero_slides')->insertGetId([
                'image_path' => $slide['image_path'],
                'sort_order' => $index + 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Tarjimalarni yaratish
            foreach ($slide['translations'] as $langCode => $content) {
                DB::table('hero_slide_translations')->insert([
                    'hero_slide_id' => $slideId,
                    'title' => $content['title'],
                    'subtitle' => $content['subtitle'],
                    'lang_code' => $langCode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
