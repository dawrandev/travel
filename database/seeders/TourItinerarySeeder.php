<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourItinerary; // Model nomi jadvalga mos bo'lishi kerak
use App\Models\TourItineraryTranslation;

class TourItinerarySeeder extends Seeder
{
    public function run()
    {
        // Mavjud birinchi turni olamiz
        $tour = Tour::first();

        if (!$tour) return;

        $itineraries = [
            // 1-KUN
            [
                'day_number' => 1,
                'event_time' => '08:00:00',
                'translations' => [
                    'ru' => [
                        'activity_title' => 'Выезд из Нукуса',
                        'activity_description' => 'Забираем вас из отеля или аэропорта на комфортабельном джипе.'
                    ],
                    'uz' => [
                        'activity_title' => 'Nukusdan chiqish',
                        'activity_description' => 'Sizni mehmonxona yoki aeroportdan qulay jipda olib ketamiz.'
                    ]
                ]
            ],
            [
                'day_number' => 1,
                'event_time' => '11:30:00',
                'translations' => [
                    'ru' => [
                        'activity_title' => 'Муйнак',
                        'activity_description' => 'Посещение «Кладбища кораблей» и музея истории Аральского моря.'
                    ],
                    'uz' => [
                        'activity_title' => 'Mo\'ynoq',
                        'activity_description' => '"Kemalar qabristoni" va Orol dengizi tarixi muzeyiga tashrif.'
                    ]
                ]
            ],
            [
                'day_number' => 1,
                'event_time' => '13:00:00',
                'translations' => [
                    'ru' => [
                        'activity_title' => 'Обед',
                        'activity_description' => 'Традиционный обед в доме рыбака в Муйнаке (свежая рыба).'
                    ],
                    'uz' => [
                        'activity_title' => 'Tushlik',
                        'activity_description' => 'Mo\'ynoqdagi baliqchi xonadonida an\'anaviy tushlik (yangi baliq).'
                    ]
                ]
            ],
            [
                'day_number' => 1,
                'event_time' => '16:00:00',
                'translations' => [
                    'ru' => [
                        'activity_title' => 'Плато Устюрт',
                        'activity_description' => 'Остановка на панорамной точке. Здесь заканчивается равнина и начинаются каньоны.'
                    ],
                    'uz' => [
                        'activity_title' => 'Ustyurt platosi',
                        'activity_description' => 'Panoramik nuqtada to\'xtash. Bu yerda tekislik tugab, kanyonlar boshlanadi.'
                    ]
                ]
            ],
            [
                'day_number' => 1,
                'event_time' => '18:00:00',
                'translations' => [
                    'ru' => [
                        'activity_title' => 'Прибытие к морю',
                        'activity_description' => 'Размещение в Юртовом лагере на берегу Арала.'
                    ],
                    'uz' => [
                        'activity_title' => 'Dengizga yetib kelish',
                        'activity_description' => 'Orol bo\'yidagi O\'tov lageriga joylashish.'
                    ]
                ]
            ],
            [
                'day_number' => 1,
                'event_time' => '20:00:00',
                'translations' => [
                    'ru' => [
                        'activity_title' => 'Ужин и костер',
                        'activity_description' => 'Горячий ужин, душевные беседы у костра и наблюдение за звездами.'
                    ],
                    'uz' => [
                        'activity_title' => 'Kechki ovqat va gulxan',
                        'activity_description' => 'Issiq kechki ovqat, gulxan atrofida suhbat va yulduzlarni kuzatish.'
                    ]
                ]
            ],
            // 2-KUN (Dizaynda ko'rinmagan bo'lsa ham mantiqan qo'shildi)
            [
                'day_number' => 2,
                'event_time' => '08:00:00',
                'translations' => [
                    'ru' => [
                        'activity_title' => 'Завтрак',
                        'activity_description' => 'Завтрак в юртовом лагере и выезд обратно в сторону Нукуса.'
                    ],
                    'uz' => [
                        'activity_title' => 'Nonushta',
                        'activity_description' => 'O\'tov lagerida nonushta va Nukus tomon yo\'lga chiqish.'
                    ]
                ]
            ],
        ];

        foreach ($itineraries as $item) {
            // Asosiy jadvalga yozish
            $itinerary = TourItinerary::create([
                'tour_id' => $tour->id,
                'day_number' => $item['day_number'],
                'event_time' => $item['event_time'],
            ]);

            // Tarjimalarni yozish
            foreach ($item['translations'] as $lang => $data) {
                TourItineraryTranslation::create([
                    'tour_itenerary_id' => $itinerary->id, // Schema dagi typo ga moslab
                    'lang_code' => $lang,
                    'activity_title' => $data['activity_title'],
                    'activity_description' => $data['activity_description'],
                ]);
            }
        }
    }
}
