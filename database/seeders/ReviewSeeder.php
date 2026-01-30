<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'user_name' => 'Елена',
                'rating' => 5,
                'video_url' => 'https://www.youtube.com/watch?v=sample1',
                'tour_id' => 1,
                'translations' => [
                    'ru' => [
                        'city' => 'Москва',
                        'comment' => 'Я не ожидала такой красоты. Закат на берегу Арала — это лучший вид в моей жизни. Спасибо Токтарбай-ага и команде, организация на высшем уровне!'
                    ],
                    'uz' => [
                        'city' => 'Moskva',
                        'comment' => 'Men bunday go‘zallikni kutmagandim. Orol qirg‘og‘idagi quyosh botishi — hayotimdagi eng go‘zal manzara bo‘ldi. To‘xtarboy og‘a va jamoasiga rahmat, tashkilotchilik yuqori darajada!'
                    ],
                    'kk' => [
                        'city' => 'Moskva',
                        'comment' => 'Men bunday gózzallıqtı kútpegen edim. Aral qırǵaǵındaǵı quyash batısı — ómirimdagi eń gózzal mánzara boldı. Toqtaybay aǵa hám komandasına raxmet, shólkemlestiriw joqarı dárejede!'
                    ],
                    'en' => [
                        'city' => 'Moscow',
                        'comment' => 'I did not expect such beauty. Sunset on the shores of the Aral Sea is the best view of my life. Thanks to Toktarbay-aga and the team, the organization is top-notch!'
                    ],
                ]
            ],
            [
                'user_name' => 'Азиз',
                'rating' => 4,
                'video_url' => 'https://www.youtube.com/watch?v=sample2',
                'tour_id' => 2,
                'translations' => [
                    'ru' => [
                        'city' => 'Ташкент',
                        'comment' => 'Отличная поездка! Каракалпакстан открылся для меня с новой стороны. Пустыня и каньоны впечатляют.'
                    ],
                    'uz' => [
                        'city' => 'Toshkent',
                        'comment' => 'Ajoyib sayohat! Qoraqalpog‘iston men uchun yangi tomondan kashf etildi. Sahro va kanyonlar juda hayratlanarli.'
                    ],
                    'kk' => [
                        'city' => 'Toshkent',
                        'comment' => 'Ajoyıp sayaxat! Qaraqalpaqstan men ushın jańa tárepten ashıldı. Shól hám kanyonlar júdá hayratlanarlı.'
                    ],
                    'en' => [
                        'city' => 'Tashkent',
                        'comment' => 'Great trip! Karakalpakstan opened up to me from a new side. The desert and canyons are impressive.'
                    ],
                ]
            ],
        ];

        foreach ($reviews as $reviewData) {
            $reviewId = DB::table('reviews')->insertGetId([
                'tour_id' => $reviewData['tour_id'],
                'user_name' => $reviewData['user_name'],
                'rating' => $reviewData['rating'],
                'video_url' => $reviewData['video_url'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($reviewData['translations'] as $langCode => $content) {
                DB::table('review_translations')->insert([
                    'review_id' => $reviewId,
                    'lang_code' => $langCode,
                    'city' => $content['city'],
                    'comment' => $content['comment'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
