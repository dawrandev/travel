<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'uz' => 'Bir kunlik',
                'kk' => 'Bir kúnlik',
                'ru' => 'Однодневные',
                'en' => 'One-day',
            ],
            [
                'uz' => 'Ikki kunlik',
                'kk' => 'Eki kúnlik',
                'ru' => 'Двухдневные',
                'en' => 'Two-day',
            ],
            [
                'uz' => 'Ekstremal',
                'kk' => 'Ekstremal',
                'ru' => 'Экстремальные',
                'en' => 'Extreme',
            ],
            [
                'uz' => 'Oilaviy',
                'kk' => 'Shańaraqlıq',
                'ru' => 'Семейные',
                'en' => 'Family',
            ],
            [
                'uz' => 'Ekspeditsiya',
                'kk' => 'Ekspediciya',
                'ru' => 'Экспедиция',
                'en' => 'Expedition',
            ],
        ];

        foreach ($categories as $index => $translations) {
            // 1. Asosiy kategoriyani yaratish
            $categoryId = DB::table('categories')->insertGetId([
                'sort_order' => $index + 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Tarjimalarni yaratish
            foreach ($translations as $langCode => $name) {
                DB::table('category_translations')->insert([
                    'category_id' => $categoryId,
                    'lang_code' => $langCode,
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
