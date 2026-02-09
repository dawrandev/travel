<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Bazadagi mavjud turlar ID-larini olamiz
        $tourIds = DB::table('tours')->pluck('id')->toArray();

        // Agar turlar hali yaratilmagan bo'lsa, seeder to'xtaydi
        if (empty($tourIds)) {
            $this->command->info('Turlar topilmadi. Avval TourSeeder-ni ishga tushiring!');
            return;
        }

        $bookings = [
            [
                'full_name' => 'John Doe',
                'max_people' => 2,
                'starting_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'ending_date' => Carbon::now()->addDays(11)->format('Y-m-d'),
                'primary_phone' => '+998901234567',
                'secondary_phone' => '+998907654321',
                'email' => 'john@example.com',
                'message' => 'We need an English speaking guide.',
                'status' => 'confirmed',
            ],
            [
                'full_name' => 'Dilshod Axmedov',
                'max_people' => 4,
                'starting_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
                'ending_date' => Carbon::now()->addDays(18)->format('Y-m-d'),
                'primary_phone' => '+998998887766',
                'secondary_phone' => null,
                'email' => 'dilshod@mail.ru',
                'message' => 'Orol bo\'yiga borishni intiqlik bilan kutamiz.',
                'status' => 'pending',
            ],
            [
                'full_name' => 'Elena Smirnova',
                'max_people' => 1,
                'starting_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'ending_date' => Carbon::now()->addDays(6)->format('Y-m-d'),
                'primary_phone' => '+79001112233',
                'secondary_phone' => null,
                'email' => 'elena@travel.ru',
                'message' => 'Transfer from the airport is required.',
                'status' => 'pending',
            ],
            [
                'full_name' => 'Mike Ross',
                'max_people' => 3,
                'starting_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'ending_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'primary_phone' => '+12025550101',
                'secondary_phone' => '+12025550102',
                'email' => 'mike@suits.com',
                'message' => null,
                'status' => 'cancelled',
            ],
        ];

        foreach ($bookings as $booking) {
            DB::table('bookings')->insert(array_merge($booking, [
                // Tasodifiy turni biriktiramiz
                'tour_id' => $tourIds[array_rand($tourIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
