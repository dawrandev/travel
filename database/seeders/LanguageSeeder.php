<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['name' => 'English', 'code' => 'en', 'is_active' => true],
            ['name' => 'Karakalpak', 'code' => 'kk', 'is_active' => true],
            ['name' => 'Uzbek', 'code' => 'uz', 'is_active' => true],
            ['name' => 'Russian', 'code' => 'ru', 'is_active' => false],
        ];

        foreach ($languages as $language) {
            \App\Models\Language::create($language);
        }
    }
}
