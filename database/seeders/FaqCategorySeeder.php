<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'sort_order' => 1,
                'translations' => [
                    'uz' => 'Umumiy ma\'lumotlar',
                    'kk' => 'Ulıwma mag\'lıwmatlar',
                    'ru' => 'Общая информация',
                    'en' => 'General Information',
                ]
            ],
            [
                'sort_order' => 2,
                'translations' => [
                    'uz' => 'Qulaylik va sayohat tajribasi',
                    'kk' => 'Qolaylıq ha\'m sayaxat ta\'jiriybesi',
                    'ru' => 'Комфорт и опыт путешествия',
                    'en' => 'Comfort & Travel Experience',
                ]
            ],
            [
                'sort_order' => 3,
                'translations' => [
                    'uz' => 'Turning asosiy nuqtalari',
                    'kk' => 'Turdın\' tiykarg\'ı noqatları',
                    'ru' => 'Основные моменты тура',
                    'en' => 'Highlights of the Tour',
                ]
            ],
            [
                'sort_order' => 4,
                'translations' => [
                    'uz' => 'Ovqatlanish va kiritilgan xizmatlar',
                    'kk' => 'Awqatlanıw ha\'m kiritilgen xizmetler',
                    'ru' => 'Питание и включенные услуги',
                    'en' => 'Meals & Inclusions',
                ]
            ],
            [
                'sort_order' => 5,
                'translations' => [
                    'uz' => 'Narxlar va qo\'shimcha xarajatlar',
                    'kk' => 'Bahalar ha\'m qosımsha qarejetler',
                    'ru' => 'Цены и дополнительные расходы',
                    'en' => 'Pricing & Additional Costs',
                ]
            ],
            [
                'sort_order' => 6,
                'translations' => [
                    'uz' => 'Yakka tartibdagi sayohatchilar',
                    'kk' => 'Yakka ta\'rtiptegi sayaxatshılar',
                    'ru' => 'Solo путешественники',
                    'en' => 'Solo Travelers',
                ]
            ],
            [
                'sort_order' => 7,
                'translations' => [
                    'uz' => 'Qo\'shimcha qiymat',
                    'kk' => 'Qosımsha qunlılıq',
                    'ru' => 'Дополнительная ценность',
                    'en' => 'Additional Value',
                ]
            ],
        ];

        foreach ($categories as $catData) {
            // Asosiy kategoriyani yaratish
            $categoryId = DB::table('faq_categories')->insertGetId([
                'sort_order' => $catData['sort_order'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Tarjimalarni yaratish
            foreach ($catData['translations'] as $lang => $name) {
                DB::table('faq_category_translations')->insert([
                    'faq_category_id' => $categoryId,
                    'lang_code' => $lang,
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
