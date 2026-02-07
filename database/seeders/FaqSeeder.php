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
            // Asosiy FAQni yaratish (umumiy FAQ - tour_id = null)
            $faqId = DB::table('faqs')->insertGetId([
                'tour_id' => null,
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

        // Tour-specific FAQs for tour_id = 1
        $tourFaqs = [
            [
                'uz' => [
                    'question' => 'Nukus madaniy turi qancha vaqt davom etadi?',
                    'answer' => 'Tur 1 kun davom etadi va soat 09:00 dan 18:00 gacha boradi. Siz Nukusning barcha asosiy diqqatga sazovor joylarini ko\'rib chiqasiz.'
                ],
                'kk' => [
                    'question' => 'No\'kis ma\'deniy turi qansha waqıt dawam etedi?',
                    'answer' => 'Tur 1 ku\'n dawam etedi ha\'m sag\'at 09:00 dan 18:00 shekem baradı.'
                ],
                'ru' => [
                    'question' => 'Сколько длится культурный тур по Нукусу?',
                    'answer' => 'Тур длится 1 день с 09:00 до 18:00. Вы увидите все основные достопримечательности Нукуса.'
                ],
                'en' => [
                    'question' => 'How long does the Nukus cultural tour last?',
                    'answer' => 'The tour lasts 1 day from 09:00 to 18:00. You will see all the main sights of Nukus.'
                ],
            ],
            [
                'uz' => [
                    'question' => 'Turga ovqat kiritilganmi?',
                    'answer' => 'Yo\'q, muzey chiptalari va ovqatlanish narxga kiritilmagan. Siz mahalliy restoranlarda o\'zingiz ovqatlanishingiz mumkin.'
                ],
                'kk' => [
                    'question' => 'Turǵa awqat kiritilgenbe?',
                    'answer' => 'Joq, muzey biletleri ha\'m awqatlanıw naxqa kiritilmegen.'
                ],
                'ru' => [
                    'question' => 'Включено ли питание в тур?',
                    'answer' => 'Нет, входные билеты в музеи и питание не включены. Вы можете питаться в местных ресторанах.'
                ],
                'en' => [
                    'question' => 'Is food included in the tour?',
                    'answer' => 'No, museum tickets and meals are not included. You can eat at local restaurants.'
                ],
            ],
            [
                'uz' => [
                    'question' => 'Guruh nechta kishidan iborat?',
                    'answer' => 'Maksimal guruh hajmi 15 kishi. Bu qulay va shaxsiy tajriba uchun ideal hajm.'
                ],
                'kk' => [
                    'question' => 'Gurup neshten adam qatnasadı?',
                    'answer' => 'Maksimal gurup hajmı 15 adam.'
                ],
                'ru' => [
                    'question' => 'Сколько человек в группе?',
                    'answer' => 'Максимальный размер группы 15 человек. Это идеальный размер для комфортного и персонального опыта.'
                ],
                'en' => [
                    'question' => 'How many people are in the group?',
                    'answer' => 'The maximum group size is 15 people. This is the ideal size for a comfortable and personal experience.'
                ],
            ],
            [
                'uz' => [
                    'question' => 'Transport turi qanday?',
                    'answer' => 'Biz qulay havo konditsionerli transport bilan ta\'minlaymiz.'
                ],
                'kk' => [
                    'question' => 'Transport tu\'ri qanday?',
                    'answer' => 'Biz qolaylı hawa konditsionerlı transport penen ta\'minleymiz.'
                ],
                'ru' => [
                    'question' => 'Какой тип транспорта используется?',
                    'answer' => 'Мы предоставляем комфортабельный транспорт с кондиционером.'
                ],
                'en' => [
                    'question' => 'What type of transport is used?',
                    'answer' => 'We provide comfortable air-conditioned transport.'
                ],
            ],
            [
                'uz' => [
                    'question' => 'Savitskiy muzeyida qancha vaqt o\'tkazamiz?',
                    'answer' => 'Muzeyda taxminan 2-3 soat o\'tkazamiz. Bu eng yaxshi eksponatlarni ko\'rish uchun yetarli vaqt.'
                ],
                'kk' => [
                    'question' => 'Savitskiy muzeyinde qansha waqıt o\'tkezamiz?',
                    'answer' => 'Muzeyda shama menen 2-3 sag\'at o\'tkezamiz.'
                ],
                'ru' => [
                    'question' => 'Сколько времени проведём в музее Савицкого?',
                    'answer' => 'В музее проведём примерно 2-3 часа. Это достаточно времени, чтобы увидеть лучшие экспонаты.'
                ],
                'en' => [
                    'question' => 'How much time will we spend at the Savitsky Museum?',
                    'answer' => 'We will spend about 2-3 hours at the museum. This is enough time to see the best exhibits.'
                ],
            ],
        ];

        foreach ($tourFaqs as $index => $translations) {
            $faqId = DB::table('faqs')->insertGetId([
                'tour_id' => 1,
                'sort_order' => $index + 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

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
