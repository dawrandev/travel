<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Bazadagi mavjud turlar ID-larini olamiz
        $tourIds = DB::table('tours')->pluck('id')->toArray();

        if (empty($tourIds)) {
            $this->command->info('Turlar topilmadi. Avval TourSeeder-ni ishga tushiring!');
            return;
        }

        $questions = [
            [
                'full_name' => 'Alisher Navoiy',
                'email' => 'alisher@example.uz',
                'phone' => '+998901234567',
                'comment' => 'Ushbu turda vegetarianlar uchun taomlar ko\'zda tutilganmi?',
                'status' => 'answered',
            ],
            [
                'full_name' => 'Sarah Jenkins',
                'email' => 'sarah.j@gmail.com',
                'phone' => '+12025550199',
                'comment' => 'Do you have discounts for students or groups larger than 10 people?',
                'status' => 'pending',
            ],
            [
                'full_name' => 'Dmitriy Petrov',
                'email' => 'dima_88@mail.ru',
                'phone' => '+79008887766',
                'comment' => 'Можно ли взять с собой маленькую собаку в этот тур?',
                'status' => 'pending',
            ],
            [
                'full_name' => 'Gulnara Karimova',
                'email' => 'gulya.nukus@inbox.uz',
                'phone' => '+998935554433',
                'comment' => 'Mizdaxan majmuasiga kirish chiptalari narxi tur ichiga kiradimi?',
                'status' => 'answered',
            ],
            [
                'full_name' => 'Hans Schmidt',
                'email' => 'hans.travel@yahoo.de',
                'phone' => '+49301234567',
                'comment' => 'Is there professional photography equipment available for rent during the trip?',
                'status' => 'pending',
            ],
        ];

        foreach ($questions as $question) {
            DB::table('questions')->insert(array_merge($question, [
                // Savolni tasodifiy turga biriktiramiz
                'tour_id' => $tourIds[array_rand($tourIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
