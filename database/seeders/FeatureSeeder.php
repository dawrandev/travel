<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            [
                'icon' => 'fas fa-bus', // Transport ikonka
                'translations' => [
                    'ru' => ['name' => 'Транспорт', 'description' => 'Комфортабельный внедорожник с кондиционером'],
                    'uz' => ['name' => 'Transport', 'description' => 'Konditsionerli qulay yo‘ltanlamas avtomobil'],
                    'kk' => ['name' => 'Transport', 'description' => 'Kondicionerli qolaylı joltanlamas avtomobil'],
                    'en' => ['name' => 'Transport', 'description' => 'Comfortable 4x4 vehicle with air conditioning'],
                ]
            ],
            [
                'icon' => 'fas fa-route', // Yo'l/Gid ikonka
                'translations' => [
                    'ru' => ['name' => 'Услуги гида', 'description' => 'Водитель-гид, знающий историю и местность'],
                    'uz' => ['name' => 'Gid xizmati', 'description' => 'Tarix va hududni yaxshi biladigan haydovchi-gid'],
                    'kk' => ['name' => 'Gid xızmeti', 'description' => 'Tariyx hám aymaqtı jaqsı biletuǵın ayrawshı-gid'],
                    'en' => ['name' => 'Guide services', 'description' => 'Driver-guide knowledgeable about history and the area'],
                ]
            ],
            [
                'icon' => 'fas fa-utensils', // Ovqat ikonka
                'translations' => [
                    'ru' => ['name' => 'Питание', 'description' => 'Полный пансион (2 обеда, 1 ужин, 1 завтрак)'],
                    'uz' => ['name' => 'Ovqatlanish', 'description' => 'To‘liq pansion (2 tushlik, 1 kechki ovqat, 1 nonushta)'],
                    'kk' => ['name' => 'Awqatlanıw', 'description' => 'Tolıq pansion (2 túslik, 1 keshki awqat, 1 azanǵı awqat)'],
                    'en' => ['name' => 'Meals', 'description' => 'Full board (2 lunches, 1 dinner, 1 breakfast)'],
                ]
            ],
            [
                'icon' => 'fas fa-bed', // Yashash ikonka
                'translations' => [
                    'ru' => ['name' => 'Проживание', 'description' => 'Ночевка в юртовом лагере (постельное белье предоставляется)'],
                    'uz' => ['name' => 'Yashash', 'description' => 'O‘tov lagerida tunash (yotoq anjomlari beriladi)'],
                    'kk' => ['name' => 'Jasaw', 'description' => 'Otaw lagerinde túnep qalıw (jataq buyımları beriledi)'],
                    'en' => ['name' => 'Accommodation', 'description' => 'Overnight stay in a yurt camp (bedding provided)'],
                ]
            ],
            [
                'icon' => 'fas fa-ticket-alt', // Chipta ikonka
                'translations' => [
                    'ru' => ['name' => 'Входные билеты', 'description' => 'Все сборы национальных парков и музеев'],
                    'uz' => ['name' => 'Kirish chiptalari', 'description' => 'Milliy bog‘lar va muzeylarning barcha to‘lovlari'],
                    'kk' => ['name' => 'Kirisiw biletleri', 'description' => 'Milliy baǵlar hám muzeylerdiń barlıq tólemleri'],
                    'en' => ['name' => 'Entrance tickets', 'description' => 'All national park and museum fees'],
                ]
            ],
        ];

        foreach ($features as $featureData) {
            $featureId = DB::table('features')->insertGetId([
                'icon' => $featureData['icon'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($featureData['translations'] as $langCode => $content) {
                DB::table('feature_translations')->insert([
                    'feature_id' => $featureId,
                    'lang_code' => $langCode,
                    'name' => $content['name'],
                    'description' => $content['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
