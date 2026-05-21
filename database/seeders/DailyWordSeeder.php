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
            [
                'kanji' => '頑張る',
                'romaji' => 'ganbaru',
                'meaning_en' => 'To do one\'s best / To persist',
                'meaning_id' => 'Berjuang / Tidak menyerah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '懐かしい',
                'romaji' => 'natsukashii',
                'meaning_en' => 'Nostalgic / Fondly remembered',
                'meaning_id' => 'Nostalgia / Rindu masa lalu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '旅',
                'romaji' => 'tabi',
                'meaning_en' => 'Journey / Travel',
                'meaning_id' => 'Perjalanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '縁',
                'romaji' => 'en',
                'meaning_en' => 'Fate / Bond / Connection',
                'meaning_id' => 'Takdir / Ikatan / Jodoh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '侘び寂び',
                'romaji' => 'wabi-sabi',
                'meaning_en' => 'Beauty in imperfection and impermanence',
                'meaning_id' => 'Keindahan dalam ketidaksempurnaan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '森林浴',
                'romaji' => 'shinrinyoku',
                'meaning_en' => 'Forest bathing / Taking in the forest atmosphere',
                'meaning_id' => 'Mandi hutan / Menikmati suasana hutan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '間',
                'romaji' => 'ma',
                'meaning_en' => 'Pause / Negative space / Gap',
                'meaning_id' => 'Jeda / Ruang kosong / Sela',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kanji' => '笑顔',
                'romaji' => 'egao',
                'meaning_en' => 'Smiling face',
                'meaning_id' => 'Wajah tersenyum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Memasukkan semua data di atas sekaligus ke dalam tabel daily_words
        DB::table('daily_words')->insert($words);
    }
}