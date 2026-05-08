<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mapel;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guru = User::where('name', 'Ahmad Hidayat')->first();

        if ($guru) {
            $mapelData = [
                [
                    'kode_mapel' => 'N590',
                    'nama_mapel' => 'N5 Mastering',
                    'deskripsi_mapel' => 'Program intensif 3 bulan (396 JP) dengan fokus praktik. Mencakup 8 unit kompetensi dasar bahasa Jepang hingga persiapan ujian level N5.',
                    'id_guru' => $guru->id,
                    'jumlah_modul' => 7,
                    'jp' => 30,
                    'status' => 'Aktif'
                ]
            ];

            foreach ($mapelData as $data) {
                Mapel::create($data);
            }
        }
    }
}
