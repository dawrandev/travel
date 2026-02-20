<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $tourIds = DB::table('tours')->pluck('id')->toArray();

        if (count($tourIds) < 5) {
            $this->command->error("Bazada kamida 5 ta tur bo'lishi kerak!");
            return;
        }

        $reviews = [
            [
                'user_name' => 'Noriyuki',
                'rating' => 10,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/noriyuki_review',
                'tour_id' => $tourIds[0],
                'translations' => [
                    'ru' => ['city' => 'Япония', 'comment' => 'Это очень хорошее жилье. За эту цену я смог спать в кровати в теплой комнате. Весь персонал очень любезный.'],
                    'uz' => ['city' => 'Yaponiya', 'comment' => 'Bu juda yaxshi turar joy. Ushbu narxga men issiq xonada, toza karavotda uxlay oldim. Xodimlar juda xushmuomala.'],
                    'kk' => ['city' => 'Yaponiya', 'comment' => 'Bul júdá jaqsı jay. Bul bahada men jıllı bólmede, taza krovatta uyqlay aldım. Personallar júdá xoshpıyıl.'],
                    'en' => ['city' => 'Japan', 'comment' => 'This is very good accommodation. For this price, I could sleep in a bed in a warm room. All staff are very kind.'],
                ]
            ],
            [
                'user_name' => 'Sarah-lena',
                'rating' => 8,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/sarah_review',
                'tour_id' => $tourIds[0],
                'translations' => [
                    'ru' => ['city' => 'Германия', 'comment' => 'Очень чисто, лучший напор воды в душе в Узбекистане. Сотрудники организовали такси и дали советы.'],
                    'uz' => ['city' => 'Germaniya', 'comment' => 'Juda toza, O‘zbekistondagi eng yaxshi dush bosimi. Xodimlar taksi tashkil qilib berishdi va ko‘plab maslahatlar berishdi.'],
                    'kk' => ['city' => 'Germaniya', 'comment' => 'Júdá taza, Ózbekstandaǵı eń jaqsı dush basımı. Xızmetkerler taksi shólkemlestirip berdi hám kóp másláhatler berdi.'],
                    'en' => ['city' => 'Germany', 'comment' => 'Very clean, best water pressure in the shower in Uzbekistan. Staff were very kind and organized a taxi for us.'],
                ]
            ],

            // TOUR 2 uchun (Strigoica va Barbara)
            [
                'user_name' => 'Strigoica',
                'rating' => 9,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/strigoica_review',
                'tour_id' => $tourIds[1],
                'translations' => [
                    'en' => ['city' => 'USA', 'comment' => 'Very speedy check-in process. The whole place is super clean. Food in the restaurant was excellent!'],
                    'ru' => ['city' => 'США', 'comment' => 'Очень быстрый процесс регистрации. Везде супер чисто. Еда в ресторане была превосходной!'],
                    'uz' => ['city' => 'AQSH', 'comment' => 'Ro‘yxatdan o‘tish juda tez bo‘ldi. Hamma joy juda toza. Restorandagi ovqatlar ajoyib edi!'],
                    'kk' => ['city' => 'AQSH', 'comment' => 'Dizimge alıw júdá tez boldı. Hámmeyaq júdá taza. Restorandaǵı awqatlar ájoyıp edi!'],
                ]
            ],
            [
                'user_name' => 'Barbara',
                'rating' => 8,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/barbara_review',
                'tour_id' => $tourIds[1],
                'translations' => [
                    'ru' => ['city' => 'Италия', 'comment' => 'Хорошее и недорогое место. Отличное соотношение цены и качества. Персонал помог с трансфером до Хивы.'],
                    'uz' => ['city' => 'Italiya', 'comment' => 'Yaxshi va arzon joy. Narx va sifat mutanosibligi ajoyib. Xodimlar Xivagacha transferga yordam berishdi.'],
                    'kk' => ['city' => 'Italiya', 'comment' => 'Jaqsı hám arzan jay. Baha hám sapalanıń sáykesligi ájoyıp. Personallar Xivaǵa shekem transferge járdem berdi.'],
                    'en' => ['city' => 'Italy', 'comment' => 'Good and inexpensive place. Excellent value for money. Staff helped organize a transfer to Khiva.'],
                ]
            ],

            // TOUR 3 uchun (Elizaveta va Angelin)
            [
                'user_name' => 'Elizaveta',
                'rating' => 10,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/elizaveta_review',
                'tour_id' => $tourIds[2],
                'translations' => [
                    'ru' => ['city' => 'Россия', 'comment' => 'Очень уютный новый хостел, тихо, чисто. Жасмина и Атабек очень помогли!'],
                    'uz' => ['city' => 'Rossiya', 'comment' => 'Juda shinam yangi hostel, tinch, toza. Jasmina va Otabek juda yordam berishdi!'],
                    'kk' => ['city' => 'Rossiya', 'comment' => 'Júdá shınam jańa hostel, tınısh, taza. Jasmina hám Atabek júdá járdem berdi!'],
                    'en' => ['city' => 'Russia', 'comment' => 'Very cozy new hostel, quiet, clean. Jasmina and Atabek were very helpful!'],
                ]
            ],
            [
                'user_name' => 'Angelin',
                'rating' => 9,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/angelin_review',
                'tour_id' => $tourIds[2],
                'translations' => [
                    'en' => ['city' => 'Singapore', 'comment' => 'This hostel can arrange day trips at very good price. Their staff, Asko, is very helpful.'],
                    'ru' => ['city' => 'Сингапур', 'comment' => 'Этот хостел может организовать поездки по очень хорошей цене. Аско очень помог.'],
                    'uz' => ['city' => 'Singapur', 'comment' => 'Bu hostel juda yaxshi narxlarda sayohatlar tashkil qila oladi. Asko ismli xodim juda yordam berdi.'],
                    'kk' => ['city' => 'Singapur', 'comment' => 'Bul hostel júdá jaqsı bahalarda sayaxatlar shólkemlestire aladı. Asko isimli xızmetker júdá járdem berdi.'],
                ]
            ],

            // TOUR 4 uchun (Yisha va Christopher va Marcelo)
            [
                'user_name' => 'Yisha',
                'rating' => 8,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/yisha_review',
                'tour_id' => $tourIds[3],
                'translations' => [
                    'en' => ['city' => 'Germany', 'comment' => 'Everything was offered, like day trips and a restaurant. Very caring staff.'],
                    'ru' => ['city' => 'Германия', 'comment' => 'Было предложено всё: экскурсии, ресторан и прочее. Очень заботливый персонал.'],
                    'uz' => ['city' => 'Germaniya', 'comment' => 'Hamma narsa taklif qilindi: ekskursiyalar, restoran va boshqalar. Juda g‘amxo‘r xodimlar.'],
                    'kk' => ['city' => 'Germaniya', 'comment' => 'Hámmeyaq usınıs etildi: ekskursiyalar, restoran hám basqalar. Júdá miymanisker personallar.'],
                ]
            ],
            [
                'user_name' => 'Christopher',
                'rating' => 7,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/chris_review',
                'tour_id' => $tourIds[3],
                'translations' => [
                    'en' => ['city' => 'USA', 'comment' => 'Nice staff, fine hotel. Room clean and comfortable enough. Offers tours to Aral sea.'],
                    'ru' => ['city' => 'США', 'comment' => 'Хороший персонал, нормальный отель. В номере чисто и уютно. Предлагают туры на Арал.'],
                    'uz' => ['city' => 'AQSH', 'comment' => 'Yaxshi xodimlar, tuzuk ota-hostel. Xonalar toza va yetarlicha qulay. Orolga turlar taklif qilishadi.'],
                    'kk' => ['city' => 'AQSH', 'comment' => 'Jaqsı xızmetkerler. Xanalar taza hám qolaylı. Aralǵa sayaxatlar usınıs etedi.'],
                ]
            ],
            [
                'user_name' => 'Marcelo',
                'rating' => 10,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_id' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/marcelo_review',
                'tour_id' => $tourIds[3],
                'translations' => [
                    'ru' => ['city' => 'Испания', 'comment' => 'В хостеле о нас очень хорошо заботились. Совершили две экскурсии на Аральское море.'],
                    'uz' => ['city' => 'Ispaniya', 'comment' => 'Hostelda bizga juda yaxshi qarashdi. Orol dengiziga ikkita ajoyib ekskursiya qildik.'],
                    'kk' => ['city' => 'Ispaniya', 'comment' => 'Hostelde bizge júdá jaqsı qaradı. Aral teńizine eki ájoyıp ekskursiya qıldıq.'],
                    'en' => ['city' => 'Spain', 'comment' => 'The hostel took very good care of us. We did two excursions to the Aral Sea.'],
                ]
            ],

            // TOUR 5 uchun (Alina, Philippe, Liubov, Matt, Miriam)
            [
                'user_name' => 'Alina',
                'rating' => 10,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/alina_review',
                'tour_id' => $tourIds[4],
                'translations' => [
                    'ru' => ['city' => 'Россия', 'comment' => 'Чисто, комфортно, уютно. Помогли с транспортом до Хивы. Всем рекомендую.'],
                    'uz' => ['city' => 'Rossiya', 'comment' => 'Toza, qulay, shinam. Xivaga borish uchun transport bilan yordam berishdi. Hammaga tavsiya qilaman.'],
                    'kk' => ['city' => 'Rossiya', 'comment' => 'Taza, qolaylı, shınam. Xivaǵa barıw ushın transport penen járdem berdi. Hámmge usınıs etemen.'],
                    'en' => ['city' => 'Russia', 'comment' => 'Clean, comfortable, cozy. Helped with transport to Khiva. Recommend to everyone.'],
                ]
            ],
            [
                'user_name' => 'Liubov',
                'rating' => 10,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/liubov_review',
                'tour_id' => $tourIds[4],
                'translations' => [
                    'ru' => ['city' => 'Россия', 'comment' => 'Поражены этими молодыми ребятами, администратором Абдуллой. Сделали всё для нашего отдыха.'],
                    'uz' => ['city' => 'Rossiya', 'comment' => 'Bu yosh yigitlar, ayniqsa administrator Abdulladan hayratdamiz. Dam olishimiz uchun hamma narsa qilishdi.'],
                    'kk' => ['city' => 'Rossiya', 'comment' => 'Bul jas jigitler, ásirese administrator Abdulla bizdi tań qaldırdı. Dem alıwımız ushın hámmeyaqtı qılıp berdi.'],
                    'en' => ['city' => 'Russia', 'comment' => 'Amazed by these young people, especially Abdullah. They did everything for our holiday.'],
                ]
            ],
            [
                'user_name' => 'Matt',
                'rating' => 10,
                'video_url' => 'https://www.youtube.com/watch?v=3nYnfYJAkao',
                'review_url' => 'https://maps.app.goo.gl/matt_review',
                'tour_id' => $tourIds[4],
                'translations' => [
                    'en' => ['city' => 'USA', 'comment' => 'Nice hostel for money. Friendly people. Organized transfer to Khiva no problem.'],
                    'ru' => ['city' => 'США', 'comment' => 'Хороший хостел за свои деньги. Дружелюбные люди. Без проблем организовали трансфер.'],
                    'uz' => ['city' => 'AQSH', 'comment' => 'Pulingizga arziydigan hostel. Xushmuomala odamlar. Xivaga transferni muammosiz hal qilishdi.'],
                    'kk' => ['city' => 'AQSH', 'comment' => 'Pulıńızǵa arzıytugın hostel. Xoshpıyıl adamlar. Xivaǵa transferdi mashqalası qılıp berdi.'],
                ]
            ]
        ];

        foreach ($reviews as $index => $data) {
            $reviewId = DB::table('reviews')->insertGetId([
                'tour_id' => $data['tour_id'],
                'user_name' => $data['user_name'],
                'rating' => $data['rating'],
                'video_url' => $data['video_url'],
                'review_url' => $data['review_url'],
                'is_active' => true,
                'sort_order' => $index + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($data['translations'] as $lang => $trans) {
                DB::table('review_translations')->insert([
                    'review_id' => $reviewId,
                    'lang_code' => $lang,
                    'city' => $trans['city'],
                    'comment' => $trans['comment'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
