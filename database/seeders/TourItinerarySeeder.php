<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourItinerary;
use App\Models\TourItineraryTranslation;

class TourItinerarySeeder extends Seeder
{
    public function run()
    {
        // Mavjud birinchi turni olamiz
        $tour = Tour::first();

        if (!$tour) return;

        $itineraries = [
            // 08:00
            [
                'day_number' => 1,
                'event_time' => '08:00:00',
                'translations' => [
                    'ru' => ['activity_title' => 'Выезд из Нукуса', 'activity_description' => 'Забираем вас из отеля или аэропорта на комфортабельном джипе.'],
                    'uz' => ['activity_title' => 'Nukusdan chiqish', 'activity_description' => 'Sizni mehmonxona yoki aeroportdan qulay jipda olib ketamiz.'],
                    'kk' => ['activity_title' => 'Nókisdan shıǵıw', 'activity_description' => 'Sizdi mıhmanxana yamasa aeroporttan qolaylı jipte alıp ketemiz.'],
                    'en' => ['activity_title' => 'Departure from Nukus', 'activity_description' => 'We pick you up from the hotel or airport in a comfortable 4x4 vehicle.']
                ]
            ],
            // 11:30
            [
                'day_number' => 1,
                'event_time' => '11:30:00',
                'translations' => [
                    'ru' => ['activity_title' => 'Муйнак', 'activity_description' => 'Посещение «Кладбища кораблей» и музея истории Аральского моря.'],
                    'uz' => ['activity_title' => 'Mo\'ynoq', 'activity_description' => '"Kemalar qabristoni" va Orol dengizi tarixi muzeyiga tashrif.'],
                    'kk' => ['activity_title' => 'Moynaq', 'activity_description' => '"Kemeler qabristanı" hám Aral teńizi tariyxı muzeyine sayaxat.'],
                    'en' => ['activity_title' => 'Muynak', 'activity_description' => 'Visiting the "Ship Graveyard" and the Aral Sea History Museum.']
                ]
            ],
            // 13:00
            [
                'day_number' => 1,
                'event_time' => '13:00:00',
                'translations' => [
                    'ru' => ['activity_title' => 'Обед', 'activity_description' => 'Традиционный обед в доме рыбака в Муйнаке (свежая рыба).'],
                    'uz' => ['activity_title' => 'Tushlik', 'activity_description' => 'Mo\'ynoqdagi baliqchi xonadonida an\'anaviy tushlik (yangi baliq).'],
                    'kk' => ['activity_title' => 'Túslik awqat', 'activity_description' => 'Moynaqtaǵı balıqshı shańaraǵında dástúriy túslik awqat (jańa balıq).'],
                    'en' => ['activity_title' => 'Lunch', 'activity_description' => 'Traditional lunch at a fisherman\'s house in Muynak (fresh fish).']
                ]
            ],
            // 16:00
            [
                'day_number' => 1,
                'event_time' => '16:00:00',
                'translations' => [
                    'ru' => ['activity_title' => 'Плато Устюрт', 'activity_description' => 'Остановка на панорамной точке. Здесь заканчивается равнина и начинаются каньоны.'],
                    'uz' => ['activity_title' => 'Ustyurt platosi', 'activity_description' => 'Panoramik nuqtada to\'xtash. Bu yerda tekislik tugab, kanyonlar boshlanadi.'],
                    'kk' => ['activity_title' => 'Ústirt platoso', 'activity_description' => 'Panoramalıq noqatta toqtaw. Bul jerde tegislik tawısılıp, kanyonlar baslanadı.'],
                    'en' => ['activity_title' => 'Ustyurt Plateau', 'activity_description' => 'Stop at a panoramic viewpoint. This is where the plains end and canyons begin.']
                ]
            ],
            // 18:00
            [
                'day_number' => 1,
                'event_time' => '18:00:00',
                'translations' => [
                    'ru' => ['activity_title' => 'Прибытие к морю', 'activity_description' => 'Размещение в Юртовом лагере на берегу Арала.'],
                    'uz' => ['activity_title' => 'Dengizga yetib kelish', 'activity_description' => 'Orol bo\'yidagi O\'tov lageriga joylashish.'],
                    'kk' => ['activity_title' => 'Teńizge jetip keliw', 'activity_description' => 'Aral boyındaǵı Otaw lagerine jaylasıw.'],
                    'en' => ['activity_title' => 'Arrival at the Sea', 'activity_description' => 'Settling into the Yurt camp on the shores of the Aral Sea.']
                ]
            ],
            // 20:00
            [
                'day_number' => 1,
                'event_time' => '20:00:00',
                'translations' => [
                    'ru' => ['activity_title' => 'Ужин и костер', 'activity_description' => 'Горячий ужин, душевные беседы у костра и наблюдение за звездами.'],
                    'uz' => ['activity_title' => 'Kechki ovqat va gulxan', 'activity_description' => 'Issiq kechki ovqat, gulxan atrofida suhbat va yulduzlarni kuzatish.'],
                    'kk' => ['activity_title' => 'Keshki awqat hám gúlxan', 'activity_description' => 'Issı keshki awqat, gúlxan átrapında sáwbbet hám juldızlardı gúzetiw.'],
                    'en' => ['activity_title' => 'Dinner and Campfire', 'activity_description' => 'Hot dinner, cozy chats by the campfire, and stargazing.']
                ]
            ],
            // Day 2
            [
                'day_number' => 2,
                'event_time' => '08:00:00',
                'translations' => [
                    'ru' => ['activity_title' => 'Завтрак', 'activity_description' => 'Завтрак в юртовом лагере и выезд обратно в сторону Нукуса.'],
                    'uz' => ['activity_title' => 'Nonushta', 'activity_description' => 'O\'tov lagerida nonushta va Nukus tomon yo\'lga chiqish.'],
                    'kk' => ['activity_title' => 'Azanǵı awqat', 'activity_description' => 'Otaw lagerinde azanǵı awqat hám Nókis tárepke jolǵa shıǵıw.'],
                    'en' => ['activity_title' => 'Breakfast', 'activity_description' => 'Breakfast in the yurt camp and departure back towards Nukus.']
                ]
            ],
        ];

        foreach ($itineraries as $item) {
            $itinerary = TourItinerary::create([
                'tour_id' => $tour->id,
                'day_number' => $item['day_number'],
                'event_time' => $item['event_time'],
            ]);

            foreach ($item['translations'] as $lang => $data) {
                TourItineraryTranslation::create([
                    'tour_itenerary_id' => $itinerary->id,
                    'lang_code' => $lang,
                    'activity_title' => $data['activity_title'],
                    'activity_description' => $data['activity_description'],
                ]);
            }
        }
    }
}
