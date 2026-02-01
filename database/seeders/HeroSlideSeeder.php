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
                        'title' => 'Yoqolgan okean qirgogidagi sarguzashtlar',
                        'description' => 'Orol dengizining o\'ziga xos tabiati va ajoyib manzaralarini kashf eting. Noyob sayohat tajribasini boshdan kechiring.',
                    ],
                    'kk' => [
                        'subtitle' => 'Aral teńizi',
                        'title' => 'Joq bolǵan okean qırǵaǵındaǵı sarguzashtlar',
                        'description' => 'Aral teńiziniń ózimnnen tábiyaatı jáne ajayıp körinisin asharıńız. Noyób sayaxat tájiribesi jasań.',
                    ],
                    'ru' => [
                        'subtitle' => 'Аральское море',
                        'title' => 'Приключение на берегу исчезнувшего океана',
                        'description' => 'Откройте для себя уникальную природу и удивительные пейзажи Аральского моря. Испытайте незабываемое путешествие.',
                    ],
                    'en' => [
                        'subtitle' => 'Aral Sea',
                        'title' => 'Adventure on the shores of a vanished ocean',
                        'description' => 'Discover the unique nature and amazing landscapes of the Aral Sea. Experience an unforgettable journey.',
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
                    'description' => $content['description'] ?? null,
                    'lang_code' => $langCode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
