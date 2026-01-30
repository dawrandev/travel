<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'uz' => ['question' => 'Orolga borish uchun eng maqbul vaqt qachon?', 'answer' => 'Bizda iqlim keskin kontinental. Sayohat uchun eng ideal vaqt — bahor (aprel-may) va kuz (sentyabr-oktyabr) oylaridir.'],
                'kk' => ['question' => 'Aralǵa barıw ushın eń qolaylı waqıt qashan?', 'answer' => 'Bizde ıqlım keskin kontinental. Sayaxat ushın eń ideal waqıt — báhár (aprel-may) hám gúz (sentyabr-oktyabr) ayları esaplanadı.'],
                'ru' => ['question' => 'Когда лучше всего ехать на Арал?', 'answer' => 'Климат у нас резко континентальный. Идеальное время для тура - это весна (апрель-май) и осень (сентябрь-октябрь).'],
                'en' => ['question' => 'When is the best time to visit the Aral Sea?', 'answer' => 'The climate is sharply continental. The ideal time for a tour is spring (April-May) and autumn (September-October).'],
            ],
            [
                'uz' => ['question' => 'Yo‘l qanchalik qiyin? Bolalar bilan borish mumkinmi?', 'answer' => 'Yo‘l charchatib qo‘yishi mumkin, ammo maxsus tayyorlangan yo‘ltanlamaslarda uni bosib o‘tsa bo’ladi. Bolalar bilan borish mumkin.'],
                'kk' => ['question' => 'Jol qanshelli qıyın? Balalar menen barıwǵa bolama?', 'answer' => 'Jol sharshatıwı múmkin, biraq arnawlı tayarlanǵan joldan júretuǵın mashinalarda barıwǵa boladı. Balalar menen barıw múmkin.'],
                'ru' => ['question' => 'Насколько тяжелая дорога? Можно ли с детьми?', 'answer' => 'Дорога может быть утомительной, но вполне преодолима на внедорожниках. Поездка с детьми возможна.'],
                'en' => ['question' => 'How difficult is the road? Is it possible to go with children?', 'answer' => 'The road can be tiring, but it is manageable in specially prepared off-road vehicles. Trips with children are possible.'],
            ],
            [
                'uz' => ['question' => 'Sahroda yashash sharoitlari qanday (tualet/dush)?', 'answer' => 'Yurt lagerlarida odatda asosiy sharoitlar, jumladan, yozgi dush va tualet mavjud.'],
                'kk' => ['question' => 'Shólistanlıqta jasaw sharayatları qanday (tualet/dush)?', 'answer' => ' тирме (yurt) lagerlerinde ádette tiykarǵı sharayatlar, sonday-aq jazǵı dush hám tualet bar.'],
                'ru' => ['question' => 'Какие условия проживания в пустыне (туалет/душ)?', 'answer' => 'В юртовых лагерях обычно предусмотрены базовые удобства, включая летний душ и туалет.'],
                'en' => ['question' => 'What are the living conditions in the desert (toilet/shower)?', 'answer' => 'Yurt camps usually provide basic facilities, including a summer shower and a toilet.'],
            ],
            [
                'uz' => ['question' => 'O‘zim bilan qanday kiyimlar olishim kerak?', 'answer' => 'Qulay yopiq kiyim, bosh kiyim va quyoshdan saqlaydigan ko‘zoynak olish tavsiya etiladi.'],
                'kk' => ['question' => 'Ózim menen qanday kiyimler alıwım kerek?', 'answer' => 'Qolaylı jabıq kiyim, bas kiyim hám quyashtan qorǵaytuǵın kózáynek alıw usınıs etiledi.'],
                'ru' => ['question' => 'Какую одежду брать с собой?', 'answer' => 'Рекомендуется брать удобную закрытую одежду, головной убор и солнцезащитные очки.'],
                'en' => ['question' => 'What clothes should I bring with me?', 'answer' => 'It is recommended to bring comfortable closed clothing, a hat, and sunglasses.'],
            ],
            [
                'uz' => ['question' => 'Orolda internet va aloqa bormi?', 'answer' => 'Aholi punktlaridan uzoqda mobil aloqa va internet deyarli ishlamaydi.'],
                'kk' => ['question' => 'Aralda internet hám baylanıs bama?', 'answer' => 'Xalıq jasaytuǵın orınlardan alısta mobil baylanıs hám internet derlik islemeydi.'],
                'ru' => ['question' => 'Есть ли интернет и связь на Арале?', 'answer' => 'Вдали от населенных пунктов мобильная связь и интернет практически отсутствуют.'],
                'en' => ['question' => 'Is there internet and communication at the Aral Sea?', 'answer' => 'Mobile communication and the internet are practically unavailable far from settlements.'],
            ],
            [
                'uz' => ['question' => 'Turni qanday to‘lash mumkin?', 'answer' => 'To‘lov naqd pul, bank o‘tkazmasi yoki elektron to‘lov tizimlari orqali qabul qilinadi.'],
                'kk' => ['question' => 'Turdı qalay tólewge boladı?', 'answer' => 'Tólew naq pul, bank otkazbası yamasa elektron tólew sistemaları arqalı qabıl etiledi.'],
                'ru' => ['question' => 'Как можно оплатить тур?', 'answer' => 'Оплата принимается наличными, банковским переводом или через электронные платежные системы.'],
                'en' => ['question' => 'How can I pay for the tour?', 'answer' => 'Payment is accepted in cash, by bank transfer, or via electronic payment systems.'],
            ],
        ];

        foreach ($faqs as $index => $translations) {
            // Asosiy FAQni yaratish
            $faqId = DB::table('faqs')->insertGetId([
                'sort_order' => $index + 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Har bir til uchun tarjimalarni kiritish
            foreach ($translations as $langCode => $content) {
                DB::table('faq_translations')->insert([
                    'faq_id' => $faqId,
                    'question' => $content['question'],
                    'answer' => $content['answer'],
                    'lang_code' => $langCode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
