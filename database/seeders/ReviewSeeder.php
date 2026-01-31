<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Bazadagi barcha mavjud turlarning ID-larini olamiz
        $tourIds = DB::table('tours')->pluck('id')->toArray();

        if (empty($tourIds)) {
            $this->command->error("Turlar topilmadi! Avval TourSeeder-ni ishga tushiring.");
            return;
        }

        $reviews = [
            [
                'user_name' => 'Елена',
                'rating' => 5.0,
                'video_url' => 'https://www.youtube.com/watch?v=sample1',
                // Birinchi mavjud turni biriktiramiz
                'tour_id' => $tourIds[0],
                'is_active' => true,
                'sort_order' => 1,
                'translations' => [
                    'ru' => ['city' => 'Москва', 'comment' => 'Я не ожидала такой красоты. Закат на берегу Арала — это лучший вид в моей жизни.'],
                    'uz' => ['city' => 'Moskva', 'comment' => 'Men bunday go‘zallikni kutmagandim. Orol qirg‘og‘idagi quyosh botishi — hayotimdagi eng go‘zal manzara.'],
                    'kk' => ['city' => 'Moskva', 'comment' => 'Men bunday gózzallıqtı kútpegen edim. Aral qırǵaǵındaǵı quyash batısı — ómirimdagi eń gózzal mánzara.'],
                    'en' => ['city' => 'Moscow', 'comment' => 'I did not expect such beauty. Sunset on the shores of the Aral Sea is the best view of my life.'],
                ]
            ],
            [
                'user_name' => 'Азиз',
                'rating' => 4.8,
                'video_url' => 'https://www.youtube.com/watch?v=sample2',
                // Agar ikkinchi tur bo'lsa shunga, bo'lmasa yana birinchisiga biriktiramiz
                'tour_id' => $tourIds[1] ?? $tourIds[0],
                'is_active' => true,
                'sort_order' => 2,
                'translations' => [
                    'ru' => ['city' => 'Ташкент', 'comment' => 'Отличная поездка! Каракалпакстан открылся для меня с новой стороны.'],
                    'uz' => ['city' => 'Toshkent', 'comment' => 'Ajoyib sayohat! Qoraqalpog‘iston men uchun yangi tomondan kashf etildi.'],
                    'kk' => ['city' => 'Toshkent', 'comment' => 'Ajoyıp sayaxat! Qaraqalpaqstan men ushın jańa tárepten ashıldı.'],
                    'en' => ['city' => 'Tashkent', 'comment' => 'Great trip! Karakalpakstan opened up to me from a new side.'],
                ]
            ],
        ];

        foreach ($reviews as $reviewData) {
            $reviewId = DB::table('reviews')->insertGetId([
                'tour_id' => $reviewData['tour_id'],
                'user_name' => $reviewData['user_name'],
                'rating' => $reviewData['rating'],
                'video_url' => $reviewData['video_url'],
                'is_active' => $reviewData['is_active'],
                'sort_order' => $reviewData['sort_order'],
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
