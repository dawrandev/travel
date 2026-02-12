<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        // Kategoriyalarni aniqlab olamiz
        $oneDayCat = DB::table('categories')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.lang_code', 'en')
            ->where('category_translations.name', 'One-day')
            ->first()->category_id ?? 1;

        $twoDayCat = DB::table('categories')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.lang_code', 'en')
            ->where('category_translations.name', 'Two-day')
            ->first()->category_id ?? 2;

        $extremeCat = DB::table('categories')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.lang_code', 'en')
            ->where('category_translations.name', 'Extreme')
            ->first()->category_id ?? 3;

        $expeditionCat = DB::table('categories')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.lang_code', 'en')
            ->where('category_translations.name', 'Expedition')
            ->first()->category_id ?? 4;


        $tours = [
            // 1. NUKUS MADANIY BIK KUNLIK TURI
            [
                'main' => [
                    'category_id' => $oneDayCat,
                    'price' => 150.00,
                    'phone' => '+998 99 999 99 99',
                    'rating' => 4.8,
                    'reviews_count' => 12,
                    'duration_days' => 1,
                    'duration_nights' => 0,
                    'min_age' => 0,
                    'max_people' => 15,
                    'is_active' => true
                ],
                'translations' => [
                    'uz' => [
                        'title' => 'Nukus madaniy bir kunlik turi',
                        'slogan' => 'Tarix, san’at va mahalliy hayot bo‘ylab sayohat',
                        'description' => 'Nukusning madaniy va tarixiy diqqatga sazovor joylarini sokin va qulay sur’atda o‘rganing.',
                        'routes' => 'Nukus – Mizdakhan – Gawir Qala – Savitskiy muzeyi – Mahalliy bozor',
                        'important_info' => 'Muzey chiptalari ($8) va ovqatlanish narxga kiritilmagan.'
                    ],
                    'ru' => [
                        'title' => 'Культурный однодневный тур по Нукусу',
                        'slogan' => 'Путешествие через историю, искусство и местную жизнь',
                        'description' => 'Исследуйте культурные и исторические достопримечательности Нукуса в спокойном и комфортном темпе.',
                        'routes' => 'Нукус – Миздахкан – Гяур Кала – Музей Савицкого – Местный базар',
                        'important_info' => 'Входные билеты в музеи ($8) и питание не включены.'
                    ],
                    'en' => [
                        'title' => 'Nukus Cultural One-Day Tour',
                        'slogan' => 'A journey through history, art and local life',
                        'description' => 'Explore the cultural and historical sights of Nukus at a calm and comfortable pace.',
                        'routes' => 'Nukus – Mizdakhan – Gyaur Qala – Savitsky Museum – Local Bazaar',
                        'important_info' => 'Museum tickets ($8) and meals are not included.'
                    ],
                    'kk' => [
                        'title' => 'No’kis ma’deniy bir ku’nlik turi',
                        'slogan' => 'Tariyx, ko’rkem-o’ner ha’m jergilikli turmıs boylap sayaxat',
                        'description' => 'No’kistin’ ma’deniy ha’m tariyxıy dıqqatqa ılayıqlı jerlerin tınısh ha’m qolaylı jaǵdayda u’yrenin’.',
                        'routes' => 'No’kis – Mizdakhan – Gawir Qala – Savitskiy muzeyi – Jergilikli bazar',
                        'important_info' => 'Muzey biletleri ($8) ha’m awqatlanıw naxqa kiritilmegen.'
                    ]
                ]
            ],

            // 2. QADIMGI XORAZM QAL’ALARI: NUKUS — HIVA
            [
                'main' => [
                    'category_id' => $oneDayCat,
                    'price' => 500.00,
                    'phone' => '+998888888888',
                    'rating' => 5.0,
                    'reviews_count' => 18,
                    'duration_days' => 1,
                    'duration_nights' => 0,
                    'min_age' => 5,
                    'max_people' => 10,
                    'is_active' => true
                ],
                'translations' => [
                    'uz' => [
                        'title' => 'Qadimgi Xorazm qal’alari: Nukus — Xiva',
                        'slogan' => 'Cho‘l qal’alari va qadimiy poytaxtlar bo‘ylab sayohat',
                        'description' => 'Nukus va Xivani Markaziy Osiyodagi eng ta’sirli cho‘l qal’alari orqali bog‘laydigan tarixiy yo‘nalish.',
                        'routes' => 'Mizdaxkan – Shilpiq – Qizil Qal’a – Tuproq Qal’a – Ayaz Qal’a',
                        'important_info' => 'Lanch-boks kiritilgan. Xivada gid xizmati kiritilmagan.'
                    ],
                    'ru' => [
                        'title' => 'Крепости Древнего Хорезма: Нукус — Хива',
                        'slogan' => 'Путешествие по пустынным крепостям и древним столицам',
                        'description' => 'Этот тур соединяет Нукус и Хиву через сердце Древнего Хорезма, посещая впечатляющие пустынные крепости.',
                        'routes' => 'Миздахкан – Шилпык – Кызыл Кала – Топрак Кала – Аяз Кала',
                        'important_info' => 'Ланч-бокс включен. Услуги гида в Хиве не включены.'
                    ],
                    'en' => [
                        'title' => 'Ancient Fortresses of Khorezm: Nukus — Khiva',
                        'slogan' => 'A journey through desert castles and ancient capitals',
                        'description' => 'This one-day trip connects Nukus and Khiva through the heart of Ancient Khorezm.',
                        'routes' => 'Mizdakhan – Chilpyk – Kyzyl Qala – Toprak Qala – Ayaz Qala',
                        'important_info' => 'Lunch-box is included. Guide services in Khiva are not included.'
                    ],
                    'kk' => [
                        'title' => 'A’yyemgi Xorezm qala’ları: No’kis — Xiva',
                        'slogan' => 'Sho’l qala’ları ha’m a’yyemgi paytaxtlar boylap sayaxat',
                        'description' => 'No’kis ha’m Xivanı A’yyemgi Xorezm ju’regi arqalı baylanıstıratug’ın tariyxıy bag’dar.',
                        'routes' => 'Mizdaxkan – Shilpiq – Qızıl Qala – Topraq Qala – Ayaz Qala',
                        'important_info' => 'Lanch-boks kiritilgen. Xivada gid xızmeti kiritilmegen.'
                    ]
                ]
            ],

            // 3. ARAL SADOSI: MOYNAQQA BIR KUNLIK SAYOHAT
            [
                'main' => [
                    'category_id' => $oneDayCat,
                    'price' => 300.00,
                    'phone' => '+998777777777',
                    'rating' => 4.7,
                    'reviews_count' => 35,
                    'duration_days' => 1,
                    'duration_nights' => 0,
                    'min_age' => 6,
                    'max_people' => 12,
                    'is_active' => true
                ],
                'translations' => [
                    'uz' => [
                        'title' => 'Aral sadosi: Moynaqqa bir kunlik sayohat',
                        'slogan' => 'Tarix, yo‘qotish va inson xotirasiga bag‘ishlangan safar',
                        'description' => 'Orol dengizi va Moynaq tarixini chuqurroq anglashni istaganlar uchun bir kunlik mazmunli safar.',
                        'routes' => 'Nukus — Mizdahkon — Moynaq (Kemalar qabristoni) — Muzey',
                        'important_info' => 'Victoria kafesida tushlik kiritilgan. Muzey chiptasi $3.'
                    ],
                    'ru' => [
                        'title' => 'Эхо Арала: однодневная поездка в Муйнак',
                        'slogan' => 'Путешествие, посвященное истории и человеческой памяти',
                        'description' => 'Для тех, кто хочет понять историю Аральского моря и Муйнака без ночевки.',
                        'routes' => 'Нукус — Миздахкан — Муйнак (Кладбище кораблей) — Музей',
                        'important_info' => 'Обед в кафе Victoria включен. Билет в музей $3.'
                    ],
                    'en' => [
                        'title' => 'Echo of Aral: One-day trip to Muynak',
                        'slogan' => 'A journey dedicated to history, loss, and human memory',
                        'description' => 'A meaningful one-day trip for those who want to understand the history of the Aral Sea and Muynak.',
                        'routes' => 'Nukus — Mizdakhan — Muynak (Ship Graveyard) — Museum',
                        'important_info' => 'Lunch at Victoria Cafe is included. Museum ticket $3.'
                    ],
                    'kk' => [
                        'title' => 'Aral hawazı: Moynaqqa bir ku’nlik sayaxat',
                        'slogan' => 'Tariyx, jog’altıw ha’m insan yadına bag’ıshlang’an sapar',
                        'description' => 'Aral ten’izi ha’m Moynaq tariyxın teren’irek tu’siniwdi qa’leytug’ınlar ushın mazmunlı sapar.',
                        'routes' => 'No’kis — Mizdaxkan — Moynaq (Kemeler qabristanı) — Muzey',
                        'important_info' => 'Victoria kafesinde tu’slik kiritilgen. Muzey bilet baha’sı $3.'
                    ]
                ]
            ],

            // 4. POTERYANNOYE MORE: 3-KUNLIK SAYOHAT
            [
                'main' => [
                    'category_id' => $extremeCat,
                    'price' => 900.00,
                    'phone' => '+998666666666',
                    'rating' => 4.9,
                    'reviews_count' => 24,
                    'duration_days' => 3,
                    'duration_nights' => 2,
                    'min_age' => 12,
                    'max_people' => 4,
                    'is_active' => true
                ],
                'translations' => [
                    'uz' => [
                        'title' => 'Yo‘qotilgan dengiz: 3 kunlik sayohat',
                        'slogan' => 'Tarix, cho‘l manzaralari va Orol dengizi qoldiqlari bo‘ylab sayohat',
                        'description' => '900 km dan ortiq masofani bosib o‘tuvchi, Ustyurt platosi va Orol dengizi qirg‘oqlarini o‘z ichiga olgan unutilmas ekspeditsiya.',
                        'routes' => 'Nukus – Xo‘jayli – Moynaq – Ustyurt platosi – Orol dengizi – Oqtumsuk kanoni – Nukus',
                        'important_info' => 'To‘liq pansion (6 mahal ovqat) kiritilgan. Yo‘ltanlamas avtomobillar taqdim etiladi.'
                    ],
                    'ru' => [
                        'title' => 'Потерянное море: 3-дневное путешествие',
                        'slogan' => 'Путешествие через историю, пустынные ландшафты и остатки Аральского моря',
                        'description' => 'Экспедиция протяженностью более 900 км, охватывающая плато Устюрт и побережье Аральского моря.',
                        'routes' => 'Нукус – Ходжейли – Муйнак – плато Устюрт – Аральское море – каньон Актумсук – Муйнак – Нукус',
                        'important_info' => 'Полный пансион (6 приёмов пищи) включен. Предоставляются внедорожники 4x4.'
                    ],
                    'en' => [
                        'title' => 'The Lost Sea: 3-Day Journey',
                        'slogan' => 'A journey through history, desert landscapes, and the remnants of the Aral Sea',
                        'description' => 'An expedition covering over 900 km, including the Ustyurt Plateau and the shores of the Aral Sea.',
                        'routes' => 'Nukus – Khodzheyli – Muynak – Ustyurt Plateau – Aral Sea – Aktumsuk Canyon – Nukus',
                        'important_info' => 'Full board (6 meals) included. 4x4 off-road vehicles provided.'
                    ],
                    'kk' => [
                        'title' => 'Jog’altılg’an ten’iz: 3 ku’nlik sayaxat',
                        'slogan' => 'Tariyx, sho’l landshaftları ha’m Aral ten’izi qaldıqları boylap sayaxat',
                        'description' => '900 km den artıq aralıqtı iyeleytug’ın, U’styurt platosi ha’m Aral ten’izi jag’alaların o’z ishine alg’an ekspeditsiya.',
                        'routes' => 'No’kis – Xojeli – Moynaq – U’styurt platosi – Aral ten’izi – Oqtumsıq kanoni – No’kis',
                        'important_info' => 'Tolıq pansion (6 mahal awqat) kiritilgen. Joltanlamas avtomobiller beriledi.'
                    ]
                ]
            ],
            [
                'main' => [
                    'category_id' => $expeditionCat,
                    'price' => 200.00,
                    'phone' => '+998555555555',
                    'rating' => 4.8,
                    'reviews_count' => 10,
                    'duration_days' => 2,
                    'duration_nights' => 1,
                    'min_age' => 8,
                    'max_people' => 4,
                    'is_active' => true
                ],
                'translations' => [
                    'kk' => [
                        'title' => 'Aral teńizi tiykarları: 2 kúnlik sayaxat',
                        'slogan' => 'Aral teńizi hám Ustyurt platosına qısqa ekspediciya',
                        'description' => 'Bul tur Aral teńizi hám onıń átrapın qısqaraq, biraq mazmunlı formatta seziwni qáleytuǵın sayaxatshılar ushın móljellengen.',
                        'routes' => 'Nukus – Mizdaxan – Gáwir qala – Moynaq – Ustyurt platosı – Aral teńizi – Aktumsuk kanyonı – Moynaq – Nukus',
                        'important_info' => 'Transport: Sedan + 4x4 Off-road. Turar joy: Yurt Camp. 4 mahal ovqat kiritilgan.',
                    ],
                    'uz' => [
                        'title' => 'Orol dengizi asoslari: 2 kunlik sayohat',
                        'slogan' => 'Orol dengizi va Ustyurt platosiga qisqa ekspeditsiya',
                        'description' => 'Ushbu tur Orol dengizi va uning atrofini qisqaroq, biroq mazmunli formatta his qilishni istagan sayohatchilar uchun mo‘ljallangan.',
                        'routes' => 'Nukus – Mizdaxan – Gavir Qala – Moynoq – Ustyurt platosi – Orol dengizi – Aktumsuk kanyoni – Moynoq – Nukus',
                        'important_info' => 'Transport: Sedan + 4x4 Off-road. Turar joy: Yurt lageri. 4 mahal ovqat kiritilgan.',
                    ],
                    'ru' => [
                        'title' => 'Основы Аральского моря: 2-дневное путешествие',
                        'slogan' => 'Краткая экспедиция на Аральское море и плато Устюрт',
                        'description' => 'Этот тур предназначен для путешественников, которые хотят ощутить Аральское море и его окрестности в более коротком, но содержательном формате.',
                        'routes' => 'Нукус – Миздахкан – Гаур Кала – Муйнак – плато Устюрт – Аральское море – каньон Актумсук – Муйнак – Нукус',
                        'important_info' => 'Транспорт: Седан + 4x4 Внедорожник. Проживание: Юртовый лагерь. 4-разовое питание.',
                    ],
                    'en' => [
                        'title' => 'Aral Sea Essentials: 2-Day Trip',
                        'slogan' => 'A short expedition to the Aral Sea and Ustyurt Plateau',
                        'description' => 'This tour is designed for travelers who want to experience the Aral Sea and its surroundings in a shorter but meaningful format.',
                        'routes' => 'Nukus – Mizdaxan – Gavir Qala – Moynoq – Ustyurt plateau – Aral Sea – Aktumsuk canyon – Moynoq – Nukus',
                        'important_info' => 'Transport: Sedan + 4x4 Off-road. Accommodation: Yurt Camp. 4 meals included.',
                    ],
                ]
            ],

        ];
        // Ma'lumotlarni bazaga kiritish
        foreach ($tours as $tourData) {
            $tourId = DB::table('tours')->insertGetId(array_merge($tourData['main'], [
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            foreach ($tourData['translations'] as $lang => $trans) {
                DB::table('tour_translations')->insert([
                    'tour_id' => $tourId,
                    'lang_code' => $lang,
                    'title' => $trans['title'],
                    'slogan' => $trans['slogan'],
                    'description' => $trans['description'],
                    'routes' => $trans['routes'],
                    'important_info' => $trans['important_info'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Sample waypoints for each tour
            DB::table('tour_waypoints')->insert([
                ['tour_id' => $tourId, 'latitude' => 41.2995, 'longitude' => 69.2401, 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['tour_id' => $tourId, 'latitude' => 41.3111, 'longitude' => 69.2803, 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['tour_id' => $tourId, 'latitude' => 41.3256, 'longitude' => 69.2987, 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}
