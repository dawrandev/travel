<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TourInclusionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. NUKUS MADANIY TURI
        $nukusTour = DB::table('tour_translations')
            ->where('title', 'Nukus madaniy bir kunlik turi')
            ->orWhere('title', 'Культурный однодневный тур по Нукусу')
            ->first();

        if ($nukusTour) {
            $nukusInclusions = [
                // Kiritilganlar
                ['icon' => 'fas fa-route', 'included' => true],    // Gid
                ['icon' => 'fas fa-bus', 'included' => true],      // Sedan
                ['icon' => 'fas fa-tint', 'included' => true],     // Suv
                ['icon' => 'fas fa-battery-full', 'included' => true], // Powerbank
                ['icon' => 'fas fa-video', 'included' => true],    // Vlog
                ['icon' => 'fas fa-hotel', 'included' => true],    // Mehmonxonaga olib borish

                // Kiritilmaganlar
                ['icon' => 'fas fa-ticket-alt', 'included' => false], // Muzey chiptalari
                ['icon' => 'fas fa-utensils', 'included' => false],   // Ovqatlanish
            ];
            $this->saveInclusions($nukusTour->tour_id, $nukusInclusions);
        }

        // 2. XORAZM QAL'ALARI TURI (NUKUS - HIVA)
        $khorezmTour = DB::table('tour_translations')
            ->where('title', 'like', '%Xorazm%')
            ->orWhere('title', 'like', '%Хорезм%')
            ->first();

        if ($khorezmTour) {
            $khorezmInclusions = [
                // Kiritilganlar
                ['icon' => 'fas fa-route', 'included' => true],    // Mahalliy hamroh
                ['icon' => 'fas fa-bus', 'included' => true],      // Transport
                ['icon' => 'fas fa-box-open', 'included' => true], // Lanch-boks
                ['icon' => 'fas fa-tint', 'included' => true],     // Suv
                ['icon' => 'fas fa-battery-full', 'included' => true], // Power bank
                ['icon' => 'fas fa-video', 'included' => true],    // Vlog
                ['icon' => 'fas fa-map-marker-alt', 'included' => true], // Xivada yakunlash

                // Kiritilmaganlar
                ['icon' => 'fas fa-user-tie', 'included' => false], // Xivada gid xizmati (shahar ichi)
                ['icon' => 'fas fa-wallet', 'included' => false],   // Shaxsiy xarajatlar
            ];
            $this->saveInclusions($khorezmTour->tour_id, $khorezmInclusions);
        }

        // 3. MOYNAQ TURI (Эхо Арала)
        $aralTour = DB::table('tour_translations')
            ->where('title', 'like', '%Эхо Арала%')
            ->orWhere('title', 'like', '%Moynaq%')
            ->first();

        if ($aralTour) {
            $aralInclusions = [
                // Kiritilganlar (Included)
                ['icon' => 'fas fa-route', 'included' => true],       // Mahalliy hamroh
                ['icon' => 'fas fa-bus', 'included' => true],         // Sedan transport
                ['icon' => 'fas fa-hotel', 'included' => true],       // Transfer (vokzal/aeroport)
                ['icon' => 'fas fa-utensils', 'included' => true],    // Victoria kafesida tushlik
                ['icon' => 'fas fa-tint', 'included' => true],        // Suv
                ['icon' => 'fas fa-battery-full', 'included' => true], // Powerbank
                ['icon' => 'fas fa-video', 'included' => true],       // Vlog video

                // Kiritilmaganlar (Not Included)
                ['icon' => 'fas fa-wallet', 'included' => false],     // Shaxsiy xarajatlar
                ['icon' => 'fas fa-ticket-alt', 'included' => false], // Muzey chiptasi (3$)
            ];
            $this->saveInclusions($aralTour->tour_id, $aralInclusions);
        }

        // 4. YO'QOTILGAN DENGIZ: 3 KUNLIK SAYOHAT (3-Day Tour)
        $lostSeaTour = DB::table('tour_translations')
            ->where('title', 'like', '%Yo‘qotilgan dengiz%')
            ->orWhere('title', 'like', '%Потерянное море%')
            ->orWhere('title', 'like', '%The Lost Sea%')
            ->first();

        if ($lostSeaTour) {
            $lostSeaInclusions = [
                // Kiritilganlar (Included)
                ['icon' => 'fas fa-route', 'included' => true],        // Mahalliy hamroh
                ['icon' => 'fas fa-bus', 'included' => true],          // Barcha transferlar
                ['icon' => 'fas fa-hotel', 'included' => true],        // Aeroport/Vokzal transfer va Nukus mehmonxonasi
                ['icon' => 'fas fa-campground', 'included' => true],   // Yurt lagerida 1 tun
                ['icon' => 'fas fa-utensils', 'included' => true],     // To'liq ovqatlanish
                ['icon' => 'fas fa-tint', 'included' => true],         // Ichimlik suvi
                ['icon' => 'fas fa-battery-full', 'included' => true],  // Powerbank
                ['icon' => 'fas fa-video', 'included' => true],        // Vlog video (agar ro'yxatda bo'lsa)

                // Kiritilmaganlar (Not Included)
                ['icon' => 'fas fa-ticket-alt', 'included' => false],  // Muzey chiptalari
                ['icon' => 'fas fa-wifi', 'included' => false],        // Internet (aloqa cheklangan)
                ['icon' => 'fas fa-wallet', 'included' => false],      // Shaxsiy xarajatlar
            ];
            $this->saveInclusions($lostSeaTour->tour_id, $lostSeaInclusions);
        }

        // 5. OROL DENGIZI ASOSLARI: 2 KUNLIK SAYOHAT
        $aralEssentialsTour = DB::table('tour_translations')
            ->where('title', 'like', '%Orol dengizi asoslari%')
            ->orWhere('title', 'like', '%Aral teńizi tiykarları%')
            ->first();

        if ($aralEssentialsTour) {
            $aralInclusions = [
                // Kiritilganlar (Included)
                ['icon' => 'fas fa-route', 'included' => true],        // Mahalliy hamroh
                ['icon' => 'fas fa-bus', 'included' => true],          // Barcha transportlar
                ['icon' => 'fas fa-campground', 'included' => true],   // Yurt lageri (1 tun)
                ['icon' => 'fas fa-utensils', 'included' => true],     // Ovqatlanish (T, K, N, T)
                ['icon' => 'fas fa-ticket-alt', 'included' => true],   // Moynoq muzeyi chiptasi
                ['icon' => 'fas fa-tint', 'included' => true],         // Suv
                ['icon' => 'fas fa-battery-full', 'included' => true], // Pauerbank
                ['icon' => 'fas fa-video', 'included' => true],        // Vlog video

                // Kiritilmaganlar (Not Included)
                ['icon' => 'fas fa-wallet', 'included' => false],      // Shaxsiy xarajatlar
                ['icon' => 'fas fa-hand-holding-usd', 'included' => false], // Choychaqa
            ];

            $this->saveInclusions($aralEssentialsTour->tour_id, $aralInclusions);
        }
    }

    /**
     * Inclusions'larni bazaga saqlash/yangilash
     */
    private function saveInclusions(int $tourId, array $items): void
    {
        foreach ($items as $item) {
            $feature = DB::table('features')->where('icon', $item['icon'])->first();

            if ($feature) {
                DB::table('tour_inclusions')->updateOrInsert(
                    [
                        'tour_id' => $tourId,
                        'feature_id' => $feature->id
                    ],
                    [
                        'is_included' => $item['included'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
            } else {
                // Agar feature topilmasa, logda xabar berish (ixtiyoriy)
                Log::warning("Feature with icon {$item['icon']} not found in database.");
            }
        }
    }
}
