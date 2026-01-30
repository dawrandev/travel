<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        $aboutId = DB::table('abouts')->insertGetId([
            'image' => 'uploads/about/main-team.jpg',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $translations = [
            'ru' => [
                'title' => 'Ваш надежный проводник в мире приключений',
                'description' => 'Мы организуем комфортные экспедиции по самым труднодоступным и живописным местам Каракалпакстана. В нашем арсенале — надежные внедорожники для покорения пустыни, опытные гиды-историки и собственный уютный хостел для отдыха после долгой дороги. Мы берем на себя все заботы: от трансфера и питания до выбора лучших локаций для фото, чтобы вы могли просто наслаждаться моментом.'
            ],
            'uz' => [
                'title' => 'Sarguzashtlar olamidagi ishonchli yo‘lboshchingiz',
                'description' => 'Biz Qoraqalpog‘istonning eng borish qiyin bo‘lgan va xushmanzara joylariga qulay ekspeditsiyalarni tashkil qilamiz. Bizning arsenalimizda sahroni zabt etish uchun ishonchli yo‘ltanlamaslar, tajribali gid-tarixchilar va uzoq yo‘ldan keyin dam olish uchun shinam xostel mavjud. Biz barcha tashvishlarni: transfer va ovqatlanishdan tortib, suratga olish uchun eng yaxshi joylarni tanlashgacha o‘z zimmamizga olamiz.'
            ],
            'kk' => [
                'title' => 'Sarguzashtlar dúnyasındaǵı isenimli jolbasshıńız',
                'description' => 'Biz Qaraqalpaqstannıń eń barıw qıyın hám xosh mánzilli orınlarına qolaylı ekspediciyalardı shulkemlestiremiz. Bizdiń arsenalımızda shólistanlıqtı baǵındırıw ushın isenimli joltanlamaslar, tájiriybeli gid-tariyxshılar hám uzaq joldan keyin dem alıw ushın shınnam xostel bar. Biz barlıq tásvishlerdi: transfer hám awqatlanıwdan baslap, súretke tusiw ushın eń jaqsı orınlardı tańlawǵa deyin óz moynımızǵa alamız.'
            ],
            'en' => [
                'title' => 'Your reliable guide in the world of adventures',
                'description' => 'We organize comfortable expeditions to the most inaccessible and picturesque places of Karakalpakstan. Our arsenal includes reliable off-road vehicles for conquering the desert, experienced historical guides, and our own cozy hostel for relaxing after a long journey. We take care of everything: from transfer and meals to choosing the best locations for photos, so you can just enjoy the moment.'
            ],
        ];

        foreach ($translations as $lang => $data) {
            DB::table('about_translations')->insert([
                'about_id' => $aboutId,
                'title' => $data['title'],
                'description' => $data['description'],
                'lang_code' => $lang,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $galleryImages = [
            ['path' => 'uploads/about/gallery-1.jpg', 'order' => 1],
            ['path' => 'uploads/about/gallery-2.jpg', 'order' => 2],
            ['path' => 'uploads/about/gallery-3.jpg', 'order' => 3],
        ];

        foreach ($galleryImages as $img) {
            DB::table('about_images')->insert([
                'about_id' => $aboutId,
                'image_path' => $img['path'],
                'sort_order' => $img['order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
