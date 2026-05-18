<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modul;
use App\Models\Mapel;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data Mapel yang sudah dibuat di MapelSeeder
        $mapelN5 = Mapel::where('kode_mapel', 'N590')->first();
        $mapelN4 = Mapel::where('kode_mapel', 'N591')->first();
        $mapelN3 = Mapel::where('kode_mapel', 'N592')->first();

        // Seed Modul untuk N5
        if ($mapelN5) {
            $this->createModulData($mapelN5->id_mapel, [
                'Dasar Hiragana & Katakana',
                'Partikel Dasar (Wa, Ni, De)',
                'Kata Kerja Bentuk Masu'
            ], 'N5');
        }

        // Seed Modul untuk N4
        if ($mapelN4) {
            $this->createModulData($mapelN4->id_mapel, [
                'Bentuk Te (Menghubungkan Kalimat)',
                'Keigo Dasar dalam Pekerjaan'
            ], 'N4');
        }

        // Seed Modul untuk N3
        if ($mapelN3) {
            $this->createModulData($mapelN3->id_mapel, [
                'Pemahaman Dokkai Level Menengah'
            ], 'N3');
        }
    }

    /**
     * Helper untuk mengisi kolom sesuai model Modul
     */
    private function createModulData($idMapel, $titles, $level)
    {
        // Ditambahkan $index untuk membuat kode_modul unik otomatis (cth: MDL-N5-01)
        foreach ($titles as $index => $title) {
            Modul::create([
                'nama_modul'         => $title,
                'kode_modul'         => 'MDL-' . $level . '-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'teori'              => 12, // Nilai dummy jam pelajaran teori
                'praktik'            => 24, // Nilai dummy jam pelajaran praktik
                'module_description' => "Materi lengkap mengenai konsep dan penggunaan $title untuk level $level.",
                'id_mapel'           => $idMapel,
                'id_rps'             => null, 
            ]);
        }
    }
}