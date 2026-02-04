<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactId = DB::table('contacts')->insertGetId([
            'phone' => '+998 90 123 45 67',
            'email' => 'tokarbay@info.uz',
            'latitude' => '42.4603',
            'longitude' => '59.6121',
            'telegram_url' => 'https://t.me/welcome_to_karakalpakistan',
            'telegram_username' => 'welcome_to_karakalpakistan',
            'instagram_url' => 'https://instagram.com/karakalpakistan',
            'facebook_url' => 'https://facebook.com/karakalpakistan',
            'youtube_url' => 'https://youtube.com/@toktarbay_aga',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $addresses = [
            'ru' => 'Нукус, Республика Каракалпакстан',
            'uz' => 'Nukus, Qoraqalpog‘iston Respublikasi',
            'kk' => 'Nókis, Qaraqalpaqstan Respublikası',
            'en' => 'Nukus, Republic of Karakalpakstan',
        ];

        foreach ($addresses as $lang => $address) {
            DB::table('contact_translations')->insert([
                'contact_id' => $contactId,
                'lang_code' => $lang,
                'address' => $address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
