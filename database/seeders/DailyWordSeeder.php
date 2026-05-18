<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DailyWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $words = [
            [
                'kanji' => '夢',
                'romaji' => 'yume',
                'meaning_en' => 'Dream',
                'meaning_id' => 'Mimpi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '木漏れ日',
                'romaji' => 'komorebi',
                'meaning_en' => 'Sunlight filtering through trees',
                'meaning_id' => 'Sinar matahari yang menyelinap di sela-sela dedaunan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '一生懸命',
                'romaji' => 'isshoukenmei',
                'meaning_en' => 'With utmost effort / Do one\'s best',
                'meaning_id' => 'Berusaha sekuat tenaga / Bersungguh-sungguh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '希望',
                'romaji' => 'kibou',
                'meaning_en' => 'Hope / Wish',
                'meaning_id' => 'Harapan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '桜',
                'romaji' => 'sakura',
                'meaning_en' => 'Cherry blossom',
                'meaning_id' => 'Bunga sakura',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Memasukkan semua data di atas sekaligus ke dalam tabel daily_words
        DB::table('daily_words')->insert($words);
    }
}