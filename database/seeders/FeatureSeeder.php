<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            // Oldindan bor bo'lgan va yangi qo'shilgan barcha xizmatlar
            [
                'icon' => 'fas fa-bus',
                'translations' => [
                    'ru' => ['name' => 'Транспорт', 'description' => 'Комфортабельный внедорожник с кондиционером'],
                    'uz' => ['name' => 'Transport', 'description' => 'Konditsionerli qulay yo‘ltanlamas avtomobil'],
                    'kk' => ['name' => 'Transport', 'description' => 'Kondicionerli qolaylı joltanlamas avtomobil'],
                    'en' => ['name' => 'Transport', 'description' => 'Comfortable 4x4 vehicle with air conditioning'],
                ]
            ],
            [
                'icon' => 'fas fa-route',
                'translations' => [
                    'ru' => ['name' => 'Услуги гида', 'description' => 'Водитель-гид, знающий историю и местность'],
                    'uz' => ['name' => 'Gid xizmati', 'description' => 'Tarix va hududni yaxshi biladigan haydovchi-gid'],
                    'kk' => ['name' => 'Gid xızmeti', 'description' => 'Tariyx hám aymaqtı jaqsı biletuǵın ayrawshı-gid'],
                    'en' => ['name' => 'Guide services', 'description' => 'Driver-guide knowledgeable about history and the area'],
                ]
            ],
            [
                'icon' => 'fas fa-hotel', // SIZDA YETISHMAYOTGAN EDI
                'translations' => [
                    'ru' => ['name' => 'Отель', 'description' => 'Трансфер до вашего отеля'],
                    'uz' => ['name' => 'Mehmonxona', 'description' => 'Mehmonxonaga tushirib qo‘yish xizmati'],
                    'kk' => ['name' => 'Mıhmanxana', 'description' => 'Mıhmanxanaǵa túsirip qoyıw xızmeti'],
                    'en' => ['name' => 'Hotel', 'description' => 'Transfer and drop-off at your hotel'],
                ]
            ],
            [
                'icon' => 'fas fa-user-tie', // SIZDA YETISHMAYOTGAN EDI
                'translations' => [
                    'ru' => ['name' => 'Гид в городе', 'description' => 'Локальный гид для прогулок по городу'],
                    'uz' => ['name' => 'Shahar gidi', 'description' => 'Shahar ichidagi ekskursiyalar uchun mahalliy gid'],
                    'kk' => ['name' => 'Qala gidi', 'description' => 'Qala ishindegi ekskursiyalar ushın jergilikli gid'],
                    'en' => ['name' => 'City guide', 'description' => 'Local guide for city walking tours'],
                ]
            ],
            [
                'icon' => 'fas fa-wallet', // SIZDA YETISHMAYOTGAN EDI
                'translations' => [
                    'ru' => ['name' => 'Личные расходы', 'description' => 'Сувениры и другие личные траты'],
                    'uz' => ['name' => 'Shaxsiy xarajatlar', 'description' => 'Sovg‘alar, suvenirlar va boshqa shaxsiy xarajatlar'],
                    'kk' => ['name' => 'Jeke qárejetler', 'description' => 'Sawǵalar hám basqa jeke qárejetler'],
                    'en' => ['name' => 'Personal expenses', 'description' => 'Souvenirs and other personal spendings'],
                ]
            ],
            [
                'icon' => 'fas fa-utensils',
                'translations' => [
                    'ru' => ['name' => 'Питание', 'description' => 'Полный пансион согласно программе'],
                    'uz' => ['name' => 'Ovqatlanish', 'description' => 'Dastur bo‘yicha tushlik yoki kechki ovqat'],
                    'kk' => ['name' => 'Awqatlanıw', 'description' => 'Baǵdarlama boyınsha túslik yamasa keshki awqat'],
                    'en' => ['name' => 'Meals', 'description' => 'Full board or specific meals as per program'],
                ]
            ],
            [
                'icon' => 'fas fa-ticket-alt',
                'translations' => [
                    'ru' => ['name' => 'Входные билеты', 'description' => 'Билеты в музеи и парки'],
                    'uz' => ['name' => 'Kirish chiptalari', 'description' => 'Muzeylar va milliy bog‘larga kirish chiptalari'],
                    'kk' => ['name' => 'Kirisiw biletleri', 'description' => 'Muzeyler hám milliy baǵlarǵa kirisiw biletleri'],
                    'en' => ['name' => 'Entrance tickets', 'description' => 'All museum and park entrance fees'],
                ]
            ],
            [
                'icon' => 'fas fa-battery-full',
                'translations' => [
                    'ru' => ['name' => 'Пауэрбанк', 'description' => 'Внешний аккумулятор для зарядки устройств'],
                    'uz' => ['name' => 'Power bank', 'description' => 'Guruh uchun tashqi quvvat manbai'],
                    'kk' => ['name' => 'Power bank', 'description' => 'Topar ushın sırtqı quwat deregi'],
                    'en' => ['name' => 'Power Bank', 'description' => 'Power bank for charging mobile devices'],
                ]
            ],
            [
                'icon' => 'fas fa-video',
                'translations' => [
                    'ru' => ['name' => 'Видеоролик', 'description' => 'Монтированный видео-отчет из тура'],
                    'uz' => ['name' => 'Sayohat videosi', 'description' => 'Sayohatdan qisqa video (vlog)'],
                    'kk' => ['name' => 'Sayaxat videosı', 'description' => 'Sayaxattan qısqa video (vlog)'],
                    'en' => ['name' => 'Travel Video', 'description' => 'Short edited travel video (vlog)'],
                ]
            ],
            [
                'icon' => 'fas fa-tint',
                'translations' => [
                    'ru' => ['name' => 'Вода', 'description' => 'Питьевая вода включена'],
                    'uz' => ['name' => 'Ichimlik suvi', 'description' => 'Safar davomida ichimlik suvi'],
                    'kk' => ['name' => 'Ishiw suwı', 'description' => 'Sapar dawamında ishiw suwı'],
                    'en' => ['name' => 'Water', 'description' => 'Drinking water provided'],
                ]
            ],
            [
                'icon' => 'fas fa-box-open',
                'translations' => [
                    'uz' => ['name' => 'Lanch-boks', 'description' => 'Tayyor lanch-boks menyusi kiritilgan'],
                    'ru' => ['name' => 'Ланч-бокс', 'description' => 'Готовый ланч-бокс включен в стоимость'],
                    'kk' => ['name' => 'Lanch-boks', 'description' => 'Tayın lanch-boks menyusı kiritilgen'],
                    'en' => ['name' => 'Lunch-box', 'description' => 'Pre-packed lunch box included'],
                ]
            ],
            [
                'icon' => 'fas fa-map-marker-alt',
                'translations' => [
                    'uz' => ['name' => 'Xivada yakunlash', 'description' => 'Sayohat Xiva shahrida yakunlanadi'],
                    'ru' => ['name' => 'Финиш в Хиве', 'description' => 'Тур заканчивается в Хиве'],
                    'kk' => ['name' => 'Xiywada juwmaqlaw', 'description' => 'Sayaxat Xiywa qalasında juwmaqlanadı'],
                    'en' => ['name' => 'Finish in Khiva', 'description' => 'Tour ends with drop-off in Khiva'],
                ]
            ],

            [
                'icon' => 'fas fa-campground',
                'translations' => [
                    'uz' => ['name' => 'Yurt lageri', 'description' => 'Orol bo‘yidagi an’anaviy yurt lagerida tunash'],
                    'ru' => ['name' => 'Юртовый лагерь', 'description' => 'Ночевка в традиционном юртовом лагере на берегу Арала'],
                    'kk' => ['name' => 'Yurta lageri', 'description' => 'Aral boyındaǵı dástúrliy yurta lagerinde túnep qalıw'],
                    'en' => ['name' => 'Yurt Camp', 'description' => 'Overnight stay in a traditional yurt camp by the Aral Sea'],
                ]
            ],
            [
                'icon' => 'fas fa-wifi',
                'translations' => [
                    'uz' => ['name' => 'Internet aloqasi', 'description' => 'Orol hududida aloqa juda cheklangan'],
                    'ru' => ['name' => 'Интернет связь', 'description' => 'Связь в районе Арала очень ограничена'],
                    'kk' => ['name' => 'Internet baylanısı', 'description' => 'Aral aymaǵında baylanıs júdá sheklengen'],
                    'en' => ['name' => 'Internet Access', 'description' => 'Connection is very limited in the Aral Sea area'],
                ]
            ],
            [
                'icon' => 'fas fa-trash-alt', // Nam salfetkalar va axlat paketlari uchun
                'translations' => [
                    'uz' => ['name' => 'Gigiyena to‘plami', 'description' => 'Salfetkalar va axlat paketlari taqdim etiladi'],
                    'ru' => ['name' => 'Гигиенический набор', 'description' => 'Предоставляются салфетки и пакеты для мусора'],
                    'kk' => ['name' => 'Gigiyena toplamı', 'description' => 'Salfetkalar hám qalan dıńıslar ushın paketler beriledi'],
                    'en' => ['name' => 'Hygiene kit', 'description' => 'Wet wipes and trash bags provided'],
                ]
            ],
            [
                'icon' => 'fas fa-hand-holding-usd',
                'translations' => [
                    'uz' => ['name' => 'Choychaqa', 'description' => 'Gid va haydovchi uchun ixtiyoriy minnatdorchilik'],
                    'ru' => ['name' => 'Чаевые', 'description' => 'Добровольное вознаграждение для гида и водителя'],
                    'kk' => ['name' => 'Shoy-pul', 'description' => 'Gid hám aydaushı ushın ıqtıyarlı minnetdarshılıq'],
                    'en' => ['name' => 'Tips', 'description' => 'Optional gratuities for guide and driver'],
                ]
            ],
        ];

        foreach ($features as $featureData) {
            // updateOrInsert ishlatish xavfsizroq (qayta ishlatsa xato bermaydi)
            DB::table('features')->updateOrInsert(
                ['icon' => $featureData['icon']],
                ['updated_at' => now()]
            );

            $featureId = DB::table('features')->where('icon', $featureData['icon'])->value('id');

            foreach ($featureData['translations'] as $langCode => $content) {
                DB::table('feature_translations')->updateOrInsert(
                    ['feature_id' => $featureId, 'lang_code' => $langCode],
                    [
                        'name' => $content['name'],
                        'description' => $content['description'],
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
