<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VocabularySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/vocabulary.json');

        if (!file_exists($jsonPath)) {
            $this->command->error("File tidak ditemukan: {$jsonPath}");
            $this->command->warn("Pastikan vocabulary.json sudah ada di database/seeders/data/");
            return;
        }

        $vocabList = json_decode(file_get_contents($jsonPath), true);

        if (empty($vocabList) || !is_array($vocabList)) {
            $this->command->error("vocabulary.json kosong atau formatnya tidak valid.");
            return;
        }

        $this->command->info("Membaca " . count($vocabList) . " kata dari vocabulary.json...");

        // Hapus data lama sebelum seed ulang
        DB::table('vocabularies')->truncate();

        $rows = [];
        $now  = now();

        foreach ($vocabList as $item) {
            $rows[] = [
                'kanji'            => $item['word']             ?? '',
                'furigana'         => $item['furigana']         ?? '',
                'romaji'           => $item['romaji']           ?? '',
                'meaning_en'       => $item['meaning']          ?? '',
                'meaning_id'       => $item['meaning_id']       ?? '',
                'level'            => $item['level']            ?? 1,
                'definition_id'    => $item['definition_id']    ?? '',
                'contextual_usage' => $item['contextual_usage'] ?? '',
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }

        // Insert per chunk 200 baris
        foreach (array_chunk($rows, 200) as $chunk) {
            DB::table('vocabularies')->insert($chunk);
        }

        // Laporan per level
        $levels = array_unique(array_column($vocabList, 'level'));
        sort($levels);
        foreach ($levels as $level) {
            $count = count(array_filter($vocabList, fn($v) => $v['level'] === $level));
            $this->command->info("Level {$level}: {$count} kata.");
        }

        $total = DB::table('vocabularies')->count();
        $this->command->info("Selesai! Total vocabulary tersimpan: {$total} kata.");
    }
}