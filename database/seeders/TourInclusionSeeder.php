<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourInclusion;
use App\Models\TourInclusionTranslation;

class TourInclusionSeeder extends Seeder
{
    public function run()
    {
        // Birinchi turni olamiz (Aral dengizi turi)
        $tour = Tour::first();

        if (!$tour) return;

        $inclusions = [
            // Kiritilgan xizmatlar (is_included: true)
            [
                'icon' => 'fa-bus',
                'is_included' => true,
                'translations' => [
                    'ru' => ['title' => 'Транспорт', 'description' => 'Комфортабельный внедорожник с кондиционером'],
                    'uz' => ['title' => 'Transport', 'description' => 'Konditsionerli qulay yo\'ltanlamas avtomobil']
                ]
            ],
            [
                'icon' => 'fa-user-tie',
                'is_included' => true,
                'translations' => [
                    'ru' => ['title' => 'Услуги гида', 'description' => 'Водитель-гид, знающий историю и местность'],
                    'uz' => ['title' => 'Gid xizmati', 'description' => 'Tarix va hududni yaxshi biladigan haydovchi-gid']
                ]
            ],
            [
                'icon' => 'fa-utensils',
                'is_included' => true,
                'translations' => [
                    'ru' => ['title' => 'Питание', 'description' => 'Полный пансион (2 обеда, 1 ужин, 1 завтрак)'],
                    'uz' => ['title' => 'Ovqatlanish', 'description' => 'To\'liq pansion (2 tushlik, 1 kechki ovqat, 1 nonushta)']
                ]
            ],
            [
                'icon' => 'fa-bed',
                'is_included' => true,
                'translations' => [
                    'ru' => ['title' => 'Проживание', 'description' => 'Ночевка в юртовом лагере (постельное белье предоставляется)'],
                    'uz' => ['title' => 'Turar joy', 'description' => 'O\'tov lagerida tunash (yotoq choyshablari beriladi)']
                ]
            ],
            [
                'icon' => 'fa-ticket-alt',
                'is_included' => true,
                'translations' => [
                    'ru' => ['title' => 'Входные билеты', 'description' => 'Все сборы национальных парков и музеев'],
                    'uz' => ['title' => 'Kirish chiptalari', 'description' => 'Milliy bog\'lar va muzeylarning barcha to\'lovlari']
                ]
            ],

            // Kiritilmagan xizmatlar (is_included: false)
            [
                'icon' => 'fa-plane',
                'is_included' => false,
                'translations' => [
                    'ru' => ['title' => 'Авиа/ЖД билеты', 'description' => 'Билеты до Нукуса (Авиа/ЖД)'],
                    'uz' => ['title' => 'Avia/Temir yo\'l', 'description' => 'Nukusgacha bo\'lgan chiptalar (Avia/Xizmat)']
                ]
            ],
            [
                'icon' => 'fa-wallet',
                'is_included' => false,
                'translations' => [
                    'ru' => ['title' => 'Личные расходы', 'description' => 'Личные расходы и сувениры'],
                    'uz' => ['title' => 'Shaxsiy xarajatlar', 'description' => 'Shaxsiy xarajatlar va suvenirlar']
                ]
            ],
            [
                'icon' => 'fa-glass-martini-alt',
                'is_included' => false,
                'translations' => [
                    'ru' => ['title' => 'Алкоголь', 'description' => 'Алкогольные напитки'],
                    'uz' => ['title' => 'Alkogol', 'description' => 'Alkogolli ichimliklar']
                ]
            ],
        ];

        foreach ($inclusions as $item) {
            $inclusion = TourInclusion::create([
                'tour_id' => $tour->id,
                'icon' => $item['icon'],
                'is_included' => $item['is_included'],
            ]);

            foreach ($item['translations'] as $lang => $data) {
                TourInclusionTranslation::create([
                    'tour_inclusion_id' => $inclusion->id,
                    'lang_code' => $lang,
                    'title' => $data['title'],
                    'description' => $data['description'],
                ]);
            }
        }
    }
}
