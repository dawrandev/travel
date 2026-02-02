<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourTranslation;
use App\Models\TourItinerary;
use App\Models\TourItineraryTranslation;
use Illuminate\Support\Facades\DB;

class TourItinerarySeeder extends Seeder
{
    public function run()
    {
        // 1. NUKUS MADANIY TURI UCHUN MA'LUMOTLAR
        $nukusTour = TourTranslation::where('title', 'like', '%Nukus madaniy%')->first();

        if ($nukusTour) {
            $nukusItineraries = [
                [
                    'day_number' => 1,
                    'event_time' => '09:00:00',
                    'translations' => [
                        'ru' => ['activity_title' => 'Выезд из Нукуса', 'activity_description' => 'Встреча с гидом и начало путешествия по истории Каракалпакстана.'],
                        'uz' => ['activity_title' => 'Nukusdan jo‘nab ketish', 'activity_description' => 'Gid bilan uchrashuv va Qoraqalpog‘iston tarixi bo‘ylab sayohat boshlanishi.'],
                        'kk' => ['activity_title' => 'Nókisden shıǵıw', 'activity_description' => 'Gid penen ushırasıw hám Qaraqalpaqstan tariyxı boyınsha sayaxat baslanıwı.'],
                        'en' => ['activity_title' => 'Departure from Nukus', 'activity_description' => 'Meeting with the guide and starting the journey through the history of Karakalpakstan.'],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '10:00:00',
                    'translations' => [
                        'ru' => ['activity_title' => 'Миздахкан и Гяур Кала', 'activity_description' => 'Посещение древнего некрополя и руин крепости Гяур Кала (2 часа).'],
                        'uz' => ['activity_title' => 'Mizdaxon va Gavur Qala', 'activity_description' => 'Mizdaxon nekropoli va Gavur Qala qadimiy qal’a xarobalariga tashrif.'],
                        'kk' => ['activity_title' => 'Mizdaxan hám Gawir Qala', 'activity_description' => 'Mizdaxan nekropoli hám Gawir Qala qal’a xarabalıqlarına sayaxat.'],
                        'en' => ['activity_title' => 'Mizdakhan & Gyaur Qala', 'activity_description' => 'Visiting the ancient necropolis and the ruins of Gyaur Qala fortress.'],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '13:00:00',
                    'translations' => [
                        'ru' => ['activity_title' => 'Музей Савицкого', 'activity_description' => 'Экскурсия по всемирно известному музею авангарда (2 часа).'],
                        'uz' => ['activity_title' => 'Savitskiy muzeyi', 'activity_description' => 'Savitskiy nomidagi Davlat san’at muzeyiga gid hamrohligida tashrif.'],
                        'kk' => ['activity_title' => 'Savitskiy muzeyi', 'activity_description' => 'Savitskiy atındaǵı mámleketlik kórkem-óner muzeyine gid penen sayaxat.'],
                        'en' => ['activity_title' => 'Savitsky Museum', 'activity_description' => 'Guided tour of the world-famous avant-garde art museum.'],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '15:00:00',
                    'translations' => [
                        'ru' => ['activity_title' => 'Местный базар', 'activity_description' => 'Прогулка по местному рынку для знакомства с повседневной жизнью города.'],
                        'uz' => ['activity_title' => 'Mahalliy bozor', 'activity_description' => 'Nukusning kundalik hayoti va an’anaviy muhitini ko‘rish uchun bozorga tashrif.'],
                        'kk' => ['activity_title' => 'Jergilikli bazar', 'activity_description' => 'Nókistiń kúndelikli turmısı hám dástúriy ortalıǵı menen tanıısıw.'],
                        'en' => ['activity_title' => 'Local Bazaar', 'activity_description' => 'Visit to the local market to experience the daily life and traditional atmosphere.'],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '16:00:00',
                    'translations' => [
                        'ru' => ['activity_title' => 'Завершение тура', 'activity_description' => 'Трансфер в отель. Окончание культурной программы.'],
                        'uz' => ['activity_title' => 'Tur yakuni', 'activity_description' => 'Mehmonxonaga olib borish va dasturning yakunlanishi.'],
                        'kk' => ['activity_title' => 'Tur juwmaǵı', 'activity_description' => 'Miymanxanaǵa alıp barıw hám baǵdarlamanıń juwmaqlanıwı.'],
                        'en' => ['activity_title' => 'End of Tour', 'activity_description' => 'Transfer to the hotel and conclusion of the program.'],
                    ]
                ],
            ];

            $this->saveItineraries($nukusTour->tour_id, $nukusItineraries);
        }

        $aralItinerary = [
            [
                'day_number' => 1,
                'event_time' => '09:00:00',
                'translations' => [
                    'uz' => ['activity_title' => 'Nukusdan jo‘nab ketish', 'activity_description' => 'Gid bilan uchrashuv va Nukusdan yo‘lga chiqish.'],
                    'ru' => ['activity_title' => 'Выезд из Нукуса', 'activity_description' => 'Встреча с гидом и выезд из города.'],
                    'en' => ['activity_title' => 'Departure from Nukus', 'activity_description' => 'Meeting with the guide and departure from Nukus.'],
                    'kk' => ['activity_title' => 'Nókisten jóneп ketiw', 'activity_description' => 'Gid penen ushırasıw hám Nókisten jolǵa shıǵıw.']
                ]
            ],
            [
                'day_number' => 1,
                'event_time' => '10:00:00',
                'translations' => [
                    'uz' => ['activity_title' => 'Mizdahkon nekropoli', 'activity_description' => 'Mizdahkon — sirli tarixiy majmua va maqbaralar.'],
                    'ru' => ['activity_title' => 'Некрополь Миздахкан', 'activity_description' => 'Древний комплекс мавзолеев и святых мест.'],
                    'en' => ['activity_title' => 'Mizdakhan Necropolis', 'activity_description' => 'An ancient complex of mausoleums and sacred sites.'],
                    'kk' => ['activity_title' => 'Mizdaxan nekropoli', 'activity_description' => 'Mizdaxan — sırlı tariyxiy kompleks hám keseneler.']
                ]
            ],
            [
                'day_number' => 1,
                'event_time' => '15:00:00',
                'translations' => [
                    'uz' => ['activity_title' => 'Tushlik (Moynaq)', 'activity_description' => 'Victoria kafesida tushlik.'],
                    'ru' => ['activity_title' => 'Обед в Муйнаке', 'activity_description' => 'Обед в кафе Victoria.'],
                    'en' => ['activity_title' => 'Lunch in Muynak', 'activity_description' => 'Lunch at the Victoria cafe.'],
                    'kk' => ['activity_title' => 'Moynaqta túslik', 'activity_description' => 'Victoria kafesinde túslik.']
                ]
            ],
            [
                'day_number' => 1,
                'event_time' => '16:00:00',
                'translations' => [
                    'uz' => ['activity_title' => 'Kemalar qabristoni', 'activity_description' => 'Aral dengizi ramzi bo‘lgan tashlab ketilgan kemalar.'],
                    'ru' => ['activity_title' => 'Кладбище кораблей', 'activity_description' => 'Заброшенные корабли, ставшие символом Арала.'],
                    'en' => ['activity_title' => 'Ship Graveyard', 'activity_description' => 'Abandoned ships that became a symbol of the Aral Sea.'],
                    'kk' => ['activity_title' => 'Kemeler qabristanı', 'activity_description' => 'Aral teńizi simvolına aylanǵan taslap ketilgen kemeler.']
                ]
            ],
            [
                'day_number' => 1,
                'event_time' => '20:00:00',
                'translations' => [
                    'uz' => ['activity_title' => 'Nukusga qaytish', 'activity_description' => 'Sayohat yakunlanib Nukusga yetib kelish.'],
                    'ru' => ['activity_title' => 'Возвращение в Нукус', 'activity_description' => 'Завершение тура и прибытие в Нукус.'],
                    'en' => ['activity_title' => 'Return to Nukus', 'activity_description' => 'End of the tour and arrival in Nukus.'],
                    'kk' => ['activity_title' => 'Nókiske qaytıw', 'activity_description' => 'Sayaxat juwmaqlanıp Nókiske jetip keliw.']
                ]
            ],
        ];

        // Tour ID ni ishonchliroq topish:
        $tour = DB::table('tour_translations')
            ->where('title', 'like', '%Эхо Арала%')
            ->orWhere('title', 'like', '%Orol sadosi%')
            ->first();

        if ($tour) {
            $this->saveItineraries($tour->tour_id, $aralItinerary);
        }

        // 3. QADIMGI XORAZM QAL'ALARI: NUKUS - XIVA
        $khorezmTour = TourTranslation::where('title', 'like', '%Xorazm%')
            ->orWhere('title', 'like', '%Хорезм%')
            ->orWhere('title', 'like', '%Khorezm%')
            ->first();

        if ($khorezmTour) {
            $khorezmItineraries = [
                [
                    'day_number' => 1,
                    'event_time' => '09:00:00',
                    'translations' => [
                        'uz' => [
                            'activity_title' => 'Nukusdan jo‘nab ketish',
                            'activity_description' => 'Yo‘lboshchi bilan uchrashuv va Nukusdan jo‘nab ketish. Qisqa tanishtiruvdan so‘ng hududning qadimiy tarixiga sayohat boshlanadi.'
                        ],
                        'ru' => [
                            'activity_title' => 'Выезд из Нукуса',
                            'activity_description' => 'Встреча с гидом и выезд из Нукуса. После краткого знакомства начинается путешествие по древней истории региона.'
                        ],
                        'kk' => [
                            'activity_title' => 'Nókisden shıǵıw',
                            'activity_description' => 'Jolbasshı penen ushırasıw hám Nókisden shıǵıw. Qısqa tanıstırıwdan soń aymaqtıń áyyemgi tariyxına sayaxat baslanadı.'
                        ],
                        'en' => [
                            'activity_title' => 'Departure from Nukus',
                            'activity_description' => 'Meeting with the guide and departure from Nukus. After a brief introduction, the journey through the ancient history of the region begins.'
                        ],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '10:00:00',
                    'translations' => [
                        'uz' => [
                            'activity_title' => 'Mizdaxon nekropoli',
                            'activity_description' => 'Tashrif davomiyligi: taxminan 2 soat. Qoraqalpog‘istondagi eng muhim tarixiy va ma’naviy majmualardan biri. Ekskursiya Buyuk Ipak yo‘li bilan bog‘liq qadimiy e’tiqodlar, afsonalar va dafn marosimlari bilan tanishtiradi.'
                        ],
                        'ru' => [
                            'activity_title' => 'Некрополь Миздахкан',
                            'activity_description' => 'Продолжительность визита: около 2 часов. Один из важнейших исторических и духовных комплексов Каракалпакстана. Экскурсия знакомит с древними верованиями, легендами и погребальными обрядами, связанными с Великим шелковым путем.'
                        ],
                        'kk' => [
                            'activity_title' => 'Mizdaxan nekropoli',
                            'activity_description' => 'Barıw dawamıylıǵı: tákriyben 2 saǵat. Qaraqalpaqstandaǵı eń áhmiyetli tariyxiy hám ruwxıy komplekslerden biri. Baǵdarlamalı sayaxat Ullı Jipek jolı menen baylanıslı áyyemgi isenimler, ápsanalar hám jerlew dástúrleri menen tanıstıradı.'
                        ],
                        'en' => [
                            'activity_title' => 'Mizdakhkan Necropolis',
                            'activity_description' => 'Visit duration: approximately 2 hours. One of the most important historical and spiritual complexes in Karakalpakstan. The guided tour introduces ancient beliefs, legends, and burial rituals associated with the Great Silk Road.'
                        ],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '12:00:00',
                    'translations' => [
                        'uz' => [
                            'activity_title' => 'Shilpiq tomon yo‘l olish',
                            'activity_description' => 'Mizdaxondan Shilpiq daxmasiga yo‘l olish. Cho‘l manzaralari orqali sayohat.'
                        ],
                        'ru' => [
                            'activity_title' => 'Дорога к Шилпику',
                            'activity_description' => 'Переезд от Миздахкана к дахме Шилпик. Путешествие через пустынные пейзажи.'
                        ],
                        'kk' => [
                            'activity_title' => 'Shilpiq tárepke jol',
                            'activity_description' => 'Mizdaxannan Shilpiq daxmasına jol. Shól manzaraları arqalı sayaxat.'
                        ],
                        'en' => [
                            'activity_title' => 'Road to Chilpyk',
                            'activity_description' => 'Transfer from Mizdakhkan to Chilpyk Dakhma. Journey through desert landscapes.'
                        ],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '14:00:00',
                    'translations' => [
                        'uz' => [
                            'activity_title' => 'Shilpiq (Zardushtiylik sukunat minorasi)',
                            'activity_description' => 'Tashrif davomiyligi: taxminan 1 soat. Ritual dafn marosimlari uchun foydalanilgan qadimiy zardushtiy daxma. Tepasidan atrofdagi cho‘l manzarasining panoramik ko‘rinishlari ochiladi.'
                        ],
                        'ru' => [
                            'activity_title' => 'Шилпик (Зороастрийская Башня молчания)',
                            'activity_description' => 'Продолжительность визита: около 1 часа. Древняя зороастрийская дахма, использовавшаяся для ритуальных погребальных церемоний. С вершины открываются панорамные виды на окружающую пустыню.'
                        ],
                        'kk' => [
                            'activity_title' => 'Shilpiq (Zardushtiylik tınıshlıq minorası)',
                            'activity_description' => 'Barıw dawamıylıǵı: tákriyben 1 saǵat. Ritual jerlew dástúrleri ushın paydalanılǵan áyyemgi zardushtiylik daxması. Ústinen átiraptaǵı shól manzarasınıń panoramalı kórinisleri ashıladı.'
                        ],
                        'en' => [
                            'activity_title' => 'Chilpyk (Zoroastrian Tower of Silence)',
                            'activity_description' => 'Visit duration: approximately 1 hour. An ancient Zoroastrian dakhma used for ritual burial ceremonies. From the top, panoramic views of the surrounding desert open up.'
                        ],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '15:00:00',
                    'translations' => [
                        'uz' => [
                            'activity_title' => 'Qizil qal’aga yo‘l olish',
                            'activity_description' => 'Shilpiqdan Qizil qal’a qadimiy qal’asiga yo‘l olish.'
                        ],
                        'ru' => [
                            'activity_title' => 'Дорога к Кызыл-Кале',
                            'activity_description' => 'Переезд от Шилпика к древней крепости Кызыл-Кала.'
                        ],
                        'kk' => [
                            'activity_title' => 'Qızıl Qalaǵa jol',
                            'activity_description' => 'Shilpiqtan Qızıl Qala áyyemgi qalasına jol.'
                        ],
                        'en' => [
                            'activity_title' => 'Road to Kyzyl Kala',
                            'activity_description' => 'Transfer from Chilpyk to the ancient fortress of Kyzyl Kala.'
                        ],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '16:00:00',
                    'translations' => [
                        'uz' => [
                            'activity_title' => 'Qizil qal’a',
                            'activity_description' => 'Tashrif davomiyligi: taxminan 30 daqiqa. Bir vaqtlar Qadimgi Xorazmning aholi manzillari va karvon yo‘llarini himoya qilgan qadimiy qal’a xarobalari.'
                        ],
                        'ru' => [
                            'activity_title' => 'Кызыл-Кала',
                            'activity_description' => 'Продолжительность визита: около 30 минут. Руины древней крепости, которая когда-то защищала поселения и караванные пути Древнего Хорезма.'
                        ],
                        'kk' => [
                            'activity_title' => 'Qızıl Qala',
                            'activity_description' => 'Barıw dawamıylıǵı: tákriyben 30 minut. Bir waqıtları Áyyemgi Xorezmniń xalıq jasaw punktlerin hám kárwan jolların qorǵaǵan áyyemgi qala xarabalıqları.'
                        ],
                        'en' => [
                            'activity_title' => 'Kyzyl Kala',
                            'activity_description' => 'Visit duration: approximately 30 minutes. Ruins of an ancient fortress that once protected settlements and caravan routes of Ancient Khorezm.'
                        ],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '17:00:00',
                    'translations' => [
                        'uz' => [
                            'activity_title' => 'Tuproq qal’a',
                            'activity_description' => 'Tashrif davomiyligi: taxminan 30 daqiqa. Qadimgi Xorazmning sobiq poytaxti. Tuproq qal’a hududning dastlabki shaharsozligi, podshoh saroylari va ma’muriy markazlari haqida tasavvur beradi.'
                        ],
                        'ru' => [
                            'activity_title' => 'Топрак-Кала',
                            'activity_description' => 'Продолжительность визита: около 30 минут. Бывшая столица Древнего Хорезма. Топрак-Кала дает представление о ранней урбанизации региона, царских дворцах и административных центрах.'
                        ],
                        'kk' => [
                            'activity_title' => 'Topraq Qala',
                            'activity_description' => 'Barıw dawamıylıǵı: tákriyben 30 minut. Áyyemgi Xorezmniń burunǵı paytaxtı. Topraq Qala aymaqtıń dáslepki qala qurılısı, patsha sarayları hám basqarıw orayları haqqında túsinik beredi.'
                        ],
                        'en' => [
                            'activity_title' => 'Toprak Kala',
                            'activity_description' => 'Visit duration: approximately 30 minutes. The former capital of Ancient Khorezm. Toprak Kala provides insight into the early urbanization of the region, royal palaces, and administrative centers.'
                        ],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '18:30:00',
                    'translations' => [
                        'uz' => [
                            'activity_title' => 'Ayaz qal’a majmuasi',
                            'activity_description' => 'Tashrif davomiyligi: taxminan 1 soat. Xorazmdagi eng mashhur qal’alar majmuasidan biri bo‘lib, cho‘lga qaragan tepalikda joylashgan. Mehmonlar xarobalarni tomosha qiladi va keng cho‘l manzaralaridan bahramand bo‘ladi.'
                        ],
                        'ru' => [
                            'activity_title' => 'Комплекс крепостей Аяз-Кала',
                            'activity_description' => 'Продолжительность визита: около 1 часа. Один из самых известных комплексов крепостей в Хорезме, расположенный на холме с видом на пустыню. Гости осматривают руины и наслаждаются панорамными видами на пустыню.'
                        ],
                        'kk' => [
                            'activity_title' => 'Ayaz Qala qal’alar kompleksi',
                            'activity_description' => 'Barıw dawamıylıǵı: tákriyben 1 saǵat. Xorezmdegi eń tanımal qal’alar komplekslerinen biri bolıp, shólge qaraǵan tóbelikte jaylasqan. Qonaqlar xarabalıqlardı tamashalaydı hám keń shól manzaralarınan húzirlenedi.'
                        ],
                        'en' => [
                            'activity_title' => 'Ayaz Kala Fortress Complex',
                            'activity_description' => 'Visit duration: approximately 1 hour. One of the most famous fortress complexes in Khorezm, located on a hill overlooking the desert. Guests explore the ruins and enjoy panoramic desert views.'
                        ],
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '21:30:00',
                    'translations' => [
                        'uz' => [
                            'activity_title' => 'Xivaga yetib kelish',
                            'activity_description' => 'Kechqurun Xivaga yetib kelish. Mehmonlar mehmonxonalariga kuzatib qo‘yiladi. Xivada gidlik xizmatlari kiritilmagan. Tur yakuni.'
                        ],
                        'ru' => [
                            'activity_title' => 'Прибытие в Хиву',
                            'activity_description' => 'Прибытие в Хиву вечером. Гостей высаживают в отелях. Услуги гида в Хиве не включены. Завершение тура.'
                        ],
                        'kk' => [
                            'activity_title' => 'Xiywaǵa jetip keliw',
                            'activity_description' => 'Keshki waqıtta Xiywaǵa jetip keliw. Qonaqlar miymanxanalarına túsiriledi. Xiywada gidlik xızmetleri kiritilmegen. Tur juwmaǵı.'
                        ],
                        'en' => [
                            'activity_title' => 'Arrival in Khiva',
                            'activity_description' => 'Arrival in Khiva in the evening. Guests are dropped off at hotels. Guide services in Khiva are not included. End of tour.'
                        ],
                    ]
                ],
            ];

            $this->saveItineraries($khorezmTour->tour_id, $khorezmItineraries);
        }

        // 4. YO'QOTILGAN DENGIZ: 3 KUNLIK SAYOHAT
        $lostSeaTour = TourTranslation::where('title', 'like', '%Потерянное море%')
            ->orWhere('title', 'like', '%Yo‘qotilgan dengiz%')
            ->first();

        if ($lostSeaTour) {
            $lostSeaItineraries = [
                // --- 1-KUN ---
                [
                    'day_number' => 1,
                    'event_time' => '09:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Nukusdan jo‘nab ketish', 'activity_description' => 'Gid va haydovchi bilan uchrashuv hamda Nukusdan yo‘lga chiqish.'],
                        'ru' => ['activity_title' => 'Выезд из Нукуса', 'activity_description' => 'Встреча с гидом и водителем, начало путешествия из Нукуса.'],
                        'en' => ['activity_title' => 'Departure from Nukus', 'activity_description' => 'Meeting with the guide and driver, departure from Nukus.'],
                        'kk' => ['activity_title' => 'Nókisden shıǵıw', 'activity_description' => 'Gid hám ayandawshı menen ushırasıw hám Nókisden jolǵa shıǵıw.']
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '10:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Mizdahkon nekropoli', 'activity_description' => 'Mazlumxon Sulu, Shamun Nabi maqbaralari va Jumart Kassab tepaligiga tashrif.'],
                        'ru' => ['activity_title' => 'Некрополь Миздахкан', 'activity_description' => 'Посещение мавзолеев Мазлумхон Сулу, Шамун Наби и холма Джумарт Кассаб.'],
                        'en' => ['activity_title' => 'Mizdakhan Necropolis', 'activity_description' => 'Visiting Mazlumkhon Sulu, Shamun Nabi mausoleums, and Jumart Kassab hill.'],
                        'kk' => ['activity_title' => 'Mizdaxan nekropoli', 'activity_description' => 'Mazlumxan Sulu, Shamun Nabi keseneleri hám Jumart Qassab tóbeligine sayaxat.']
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '15:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Moynoqda tushlik', 'activity_description' => 'Mahalliy kafeda tushlik va Orol dengizi tubi tomon yo‘lga chiqish.'],
                        'ru' => ['activity_title' => 'Обед в Муйнаке', 'activity_description' => 'Обед в местном кафе и выезд в сторону бывшего дна Аральского моря.'],
                        'en' => ['activity_title' => 'Lunch in Muynak', 'activity_description' => 'Lunch at a local cafe and departure towards the former bed of the Aral Sea.'],
                        'kk' => ['activity_title' => 'Moynaqta túslik', 'activity_description' => 'Jergilikli kafede túslik hám Aral teńizi túbi tárepke jolǵa shıǵıw.']
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '20:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Yurt lageriga joylashish', 'activity_description' => 'Orol dengizi qirg‘og‘ida kechki ovqat va tunash.'],
                        'ru' => ['activity_title' => 'Размещение в юртовом лагере', 'activity_description' => 'Ужин и ночевка в юртах на берегу Аральского моря.'],
                        'en' => ['activity_title' => 'Arrival at Yurt Camp', 'activity_description' => 'Dinner and overnight stay in yurts on the shore of the Aral Sea.'],
                        'kk' => ['activity_title' => 'Yurta lagerine jaylasıw', 'activity_description' => 'Aral teńizi jaǵasında keshki awqat hám túnep qalıw.']
                    ]
                ],

                // --- 2-KUN ---
                [
                    'day_number' => 2,
                    'event_time' => '06:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Orol dengizida tong', 'activity_description' => 'Dengiz qirg‘og‘ida quyosh chiqishini kutib olish va nonushta.'],
                        'ru' => ['activity_title' => 'Рассвет на Арале', 'activity_description' => 'Встреча рассвета на берегу моря и завтрак в лагере.'],
                        'en' => ['activity_title' => 'Sunrise at Aral', 'activity_description' => 'Watching the sunrise on the shore and breakfast at the camp.'],
                        'kk' => ['activity_title' => 'Aralda tań atıwı', 'activity_description' => 'Teńiz jaǵasında tań atıwın kútip alıw hám lagerde azanǵı awqat.']
                    ]
                ],
                [
                    'day_number' => 2,
                    'event_time' => '09:40:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Aktumsuk kanyoni', 'activity_description' => 'Ustyurt platosining hayratlanarli manzaralari va suratga olish.'],
                        'ru' => ['activity_title' => 'Каньон Актумсук', 'activity_description' => 'Впечатляющие виды плато Устюрт и фотосессия.'],
                        'en' => ['activity_title' => 'Aktumsuk Canyon', 'activity_description' => 'Stunning views of the Ustyurt Plateau and photo session.'],
                        'kk' => ['activity_title' => 'Oqtumsıq kanonı', 'activity_description' => 'Ústyurt platosınıń hayran qalarlıq manzaraları hám súwretke túsiriw.']
                    ]
                ],
                [
                    'day_number' => 2,
                    'event_time' => '15:40:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Kemalar qabristoni', 'activity_description' => 'Moynoqdagi kemalar qabristoni va Orol dengizi muzeyi tashrifi.'],
                        'ru' => ['activity_title' => 'Кладбище кораблей', 'activity_description' => 'Посещение кладбища кораблей и музея Аральского моря в Муйнаке.'],
                        'en' => ['activity_title' => 'Ship Graveyard', 'activity_description' => 'Visit to the ship graveyard and the Aral Sea museum in Muynak.'],
                        'kk' => ['activity_title' => 'Kemeler qabristanı', 'activity_description' => 'Moynaqtaǵı kemeler qabristanı hám Aral teńizi muzeyine sayaxat.']
                    ]
                ],
                [
                    'day_number' => 2,
                    'event_time' => '20:30:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Nukusga qaytish', 'activity_description' => 'Nukusga yetib kelish va mehmonxonada dam olish.'],
                        'ru' => ['activity_title' => 'Возвращение в Нукус', 'activity_description' => 'Прибытие в Нукус и отдых в отеле.'],
                        'en' => ['activity_title' => 'Return to Nukus', 'activity_description' => 'Arrival in Nukus and rest at the hotel.'],
                        'kk' => ['activity_title' => 'Nókiske qaytıw', 'activity_description' => 'Nókiske jetip keliw hám miymanxanada dem alıw.']
                    ]
                ],

                // --- 3-KUN ---
                [
                    'day_number' => 3,
                    'event_time' => '10:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Savitskiy muzeyi', 'activity_description' => 'Jahon miqyosidagi avangard san’ati to‘plamini tomosha qilish.'],
                        'ru' => ['activity_title' => 'Музей Савицкого', 'activity_description' => 'Просмотр коллекции авангардного искусства мирового уровня.'],
                        'en' => ['activity_title' => 'Savitsky Museum', 'activity_description' => 'Viewing the world-class collection of avant-garde art.'],
                        'kk' => ['activity_title' => 'Savitskiy muzeyi', 'activity_description' => 'Dúnya júzilik avangard kórkem-óneri toplamın tamashalaw.']
                    ]
                ],
                [
                    'day_number' => 3,
                    'event_time' => '12:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Nukus bozori', 'activity_description' => 'Mahalliy bozor bo‘ylab sayr va esdalik sovg‘alar xarid qilish.'],
                        'ru' => ['activity_title' => 'Рынок Нукуса', 'activity_description' => 'Прогулка по местному рынку и покупка сувениров.'],
                        'en' => ['activity_title' => 'Nukus Bazaar', 'activity_description' => 'Walk through the local market and souvenir shopping.'],
                        'kk' => ['activity_title' => 'Nókis bazarı', 'activity_description' => 'Jergilikli bazar boylap sayıl hám estelik sawǵalar satıp alıw.']
                    ]
                ],
                [
                    'day_number' => 3,
                    'event_time' => '15:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Tur yakuni', 'activity_description' => 'Aeroport yoki vokzalga transfer. Xayrlashuv.'],
                        'ru' => ['activity_title' => 'Завершение тура', 'activity_description' => 'Трансфер в аэропорт или вокзал. Прощание.'],
                        'en' => ['activity_title' => 'End of Tour', 'activity_description' => 'Transfer to the airport or station. Farewell.'],
                        'kk' => ['activity_title' => 'Tur juwmaǵı', 'activity_description' => 'Aeroport yamasa vokzalǵa transfer. Xoshlasıw.']
                    ]
                ],
            ];

            $this->saveItineraries($lostSeaTour->tour_id, $lostSeaItineraries);
        }

        // 5. OROL DENGIZI ASOSLARI: 2 KUNLIK SAYOHAT
        $aralEssentialsTour = TourTranslation::where('title', 'like', '%Аральское море: основы%')
            ->orWhere('title', 'like', '%Orol dengizi asoslari%')
            ->first();

        if ($aralEssentialsTour) {
            $aralEssentialsItineraries = [
                // --- 1-KUN ---
                [
                    'day_number' => 1,
                    'event_time' => '09:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Nukusdan jo‘nab ketish', 'activity_description' => 'Yo‘lboshchi bilan uchrashuv va Nukusdan yo‘lga chiqish. Qisqa tanishuvdan so‘ng sayohat boshlanadi.'],
                        'ru' => ['activity_title' => 'Выезд из Нукуса', 'activity_description' => 'Встреча с гидом и выезд из Нукуса. Путешествие начинается после краткого знакомства.'],
                        'en' => ['activity_title' => 'Departure from Nukus', 'activity_description' => 'Meeting with the guide and departure from Nukus. The journey begins after a short briefing.'],
                        'kk' => ['activity_title' => 'Nókisten jóneп ketiw', 'activity_description' => 'Jolbasshı menen ushırasıw hám Nókisten jolǵa shıǵıw. Qısqasha tanısıwdan soń sayaxat baslanadı.']
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '10:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Mizdahkon nekropoli va Gavir Qala', 'activity_description' => 'Qadimiy dafn marosimlari, afsonalar va qal’a qoldiqlaridan iborat tarixiy majmuaga tashrif.'],
                        'ru' => ['activity_title' => 'Некрополь Миздахкан и Гяур-Кала', 'activity_description' => 'Посещение исторического комплекса, объединяющего древние захоронения и руины крепости.'],
                        'en' => ['activity_title' => 'Mizdakhan Necropolis & Gyaur-Kala', 'activity_description' => 'Visit to the historical complex featuring ancient burials, legends, and fortress ruins.'],
                        'kk' => ['activity_title' => 'Mizdaxan nekropoli hám Gáwir qala', 'activity_description' => 'Áyyemgi jerlew dástúrleri, ápsanalar hám qala qaldıqlarınan ibarat tariyxiy komplekske sayaxat.']
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '15:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Moynoqda tushlik', 'activity_description' => 'Moynoqdagi mahalliy kafeda tushlik.'],
                        'ru' => ['activity_title' => 'Обед в Муйнаке', 'activity_description' => 'Обед в местном кафе города Муйнак.'],
                        'en' => ['activity_title' => 'Lunch in Muynak', 'activity_description' => 'Lunch at a local cafe in Muynak.'],
                        'kk' => ['activity_title' => 'Moynaqta túslik', 'activity_description' => 'Moynaqtaǵı jergilikli kafede túslik.']
                    ]
                ],
                [
                    'day_number' => 1,
                    'event_time' => '19:00:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Orol dengizi va yurt lageri', 'activity_description' => 'Yurt lageriga joylashish, kechki ovqat va Orol dengizi yaqinida tunash.'],
                        'ru' => ['activity_title' => 'Аральское море и юртовый лагерь', 'activity_description' => 'Размещение в юртовом лагере, ужин и ночевка у Аральского моря.'],
                        'en' => ['activity_title' => 'Aral Sea & Yurt Camp', 'activity_description' => 'Settling into the yurt camp, dinner, and overnight stay near the Aral Sea.'],
                        'kk' => ['activity_title' => 'Aral teńizi hám yurta lageri', 'activity_description' => 'Yurta lagerine jaylasıw, keshki awqat hám Aral teńizi jaǵasında túnep qalıw.']
                    ]
                ],

                // --- 2-KUN ---
                [
                    'day_number' => 2,
                    'event_time' => '09:40:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Aktumsuk kanyoni', 'activity_description' => 'Shamol va eroziya natijasida shakllangan hayratlanarli tabiiy kanyon manzaralari.'],
                        'ru' => ['activity_title' => 'Каньон Актумсук', 'activity_description' => 'Удивительные виды природного каньона, сформированного ветром и эрозией.'],
                        'en' => ['activity_title' => 'Aktumsuk Canyon', 'activity_description' => 'Stunning natural canyon landscapes shaped by wind and erosion.'],
                        'kk' => ['activity_title' => 'Oqtumsıq kanyonı', 'activity_description' => 'Samal hám eroziya nátijesinde payda bolǵan hayran qalarlıq tábiyiy kanyon manzaraları.']
                    ]
                ],
                [
                    'day_number' => 2,
                    'event_time' => '16:40:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Kemalar qabristoni va muzey', 'activity_description' => 'Sobiq dengiz tubidagi kemalar va Orol dengizi fojiasini yorituvchi muzeyga tashrif.'],
                        'ru' => ['activity_title' => 'Кладбище кораблей и музей', 'activity_description' => 'Посещение кораблей на бывшем дне моря и музея трагедии Аральского моря.'],
                        'en' => ['activity_title' => 'Ship Graveyard & Museum', 'activity_description' => 'Visit to the ships on the former seabed and the museum of the Aral Sea tragedy.'],
                        'kk' => ['activity_title' => 'Kemeler qabristanı hám muzey', 'activity_description' => 'Burınǵı teńiz túbindegi kemeler hám Aral teńizi fojiasın kórsetiwshi muzeyge sayaxat.']
                    ]
                ],
                [
                    'day_number' => 2,
                    'event_time' => '20:40:00',
                    'translations' => [
                        'uz' => ['activity_title' => 'Nukusga yetib kelish', 'activity_description' => 'Nukusga qaytish va sayohat yakuni.'],
                        'ru' => ['activity_title' => 'Прибытие в Нукус', 'activity_description' => 'Возвращение в Нукус и завершение тура.'],
                        'en' => ['activity_title' => 'Arrival in Nukus', 'activity_description' => 'Return to Nukus and end of the tour.'],
                        'kk' => ['activity_title' => 'Nókiske jetip keliw', 'activity_description' => 'Nókiske qaytıw hám sayaxat juwmaǵı.']
                    ]
                ],
            ];

            $this->saveItineraries($aralEssentialsTour->tour_id, $aralEssentialsItineraries);
        }
    }

    private function saveItineraries($tourId, $itineraries)
    {
        foreach ($itineraries as $item) {
            $itinerary = TourItinerary::create([
                'tour_id' => $tourId,
                'day_number' => $item['day_number'],
                'event_time' => $item['event_time'],
            ]);

            // Seeder ichidagi funksiyani shunday o'zgartiring:
            foreach ($item['translations'] as $lang => $data) {
                TourItineraryTranslation::create([
                    'tour_itenerary_id' => $itinerary->id, // Baza ustun nomi qanday bo'lsa, shunday yozing
                    'lang_code' => $lang,
                    'activity_title' => $data['activity_title'],
                    'activity_description' => $data['activity_description'],
                ]);
            }
        }
    }
}
