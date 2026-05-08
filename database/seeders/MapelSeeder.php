<?php

namespace Database\Seeders;

use App\Models\Mapel;
use App\Models\User;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        // Mengambil user dengan email guru yang sudah ada di database
        $guru = User::where('email', 'guru@gmail.com')->first();

        if ($guru) {
            // Membuat data mata pelajaran baru
            Mapel::create([
                'nama_mapel' => 'Pengenalan Huruf Jepang (Hiragana & Katakana)',
                'id_guru' => $guru->id
            ]);

            Mapel::create([
                'nama_mapel' => 'Kosakata Dasar (Kotoba)',
                'id_guru' => $guru->id
            ]);

            Mapel::create([
                'nama_mapel' => 'Tata Bahasa Dasar (Bunpou)',
                'id_guru' => $guru->id
            ]);
        }
    }
}