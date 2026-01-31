<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        // Kategoriyani aniqlab olamiz (Kategoriyalar mavjud bo'lishi shart)
        $categoryId = DB::table('categories')->first()->id ?? 1;

        // 1. Asosiy tur ma'lumotlarini yaratish
        $tourId = DB::table('tours')->insertGetId([
            'category_id'     => $categoryId,
            'price'           => 1200000.00,
            'rating'          => 4.9,
            'reviews_count'   => 24,
            'duration_days'   => 2,
            'duration_nights' => 1,
            'min_age'         => 6,
            'max_people'      => 12,
            'is_active'       => true,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // 2. Tarjimalar massivi
        $translations = [
            'ru' => [
                'title' => 'Экспедиция к Аральскому морю и кладбищу кораблей',
                'description' => 'Уникальный тур по дну высохшего океана, посещение легендарного кладбища кораблей и ночевка в юртовом лагере.',
                'routes' => 'Нукус — Муйнак — Плато Устюрт — Аральское море',
                'important_info' => 'Возьмите с собой удобную обувь, солнцезащитные очки и теплую одежду для ночевки.'
            ],
            'uz' => [
                'title' => 'Orol dengizi va kemalar qabristoniga ekspeditsiya',
                'description' => 'Qurigan okean tubi bo‘ylab noyob sayohat, afsonaviy kemalar qabristonini ziyorat qilish va o‘tov lagerida tunash.',
                'routes' => 'Nukus — Mo‘ynoq — Ustyurt platosi — Orol dengizi',
                'important_info' => 'O‘zingiz bilan qulay poyabzal, quyoshdan saqlovchi ko‘zoynak va tunash uchun issiq kiyim oling.'
            ],
            'kk' => [
                'title' => 'Aral teńizi hám kemeler qabristanına ekspediciya',
                'description' => 'Qurıǵan okean túbi boylap kemeler qabristanına sayaxat hám otaw lagerinde túnep qalıw.',
                'routes' => 'Nókis — Moynaq — Ústirt platoso — Aral teńizi',
                'important_info' => 'Ózińiz benen qolaylı ayaq kiyim, quyashtan qorǵawshı kózáynek hám túnep qalıw ushın jıllı kiyim alıń.'
            ],
            'en' => [
                'title' => 'Expedition to the Aral Sea and Ship Graveyard',
                'description' => 'A unique tour across the bottom of a dried-up ocean, visiting the legendary ship graveyard and staying in a yurt camp.',
                'routes' => 'Nukus — Muynak — Ustyurt Plateau — Aral Sea',
                'important_info' => 'Bring comfortable shoes, sunglasses, and warm clothes for the overnight stay.'
            ],
        ];

        foreach ($translations as $lang => $data) {
            DB::table('tour_translations')->insert([
                'tour_id'        => $tourId,
                'lang_code'      => $lang,
                'title'          => $data['title'],
                'description'    => $data['description'],
                'routes'         => $data['routes'],
                'important_info' => $data['important_info'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
