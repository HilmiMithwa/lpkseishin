<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rps;
use App\Models\Mapel;

class RpsSeeder extends Seeder
{
    public function run(): void
    {
        $mapelN4 = Mapel::where('kode_mapel', 'N591')->first();

        if ($mapelN4) {
            for ($i = 1; $i <= 7; $i++) {
                Rps::create([
                    'pertemuan' => $i,
                    'deskripsi_rps' => "Materi pembelajaran pertemuan ke-$i untuk persiapan JLPT N4.",
                    'kode_kelas' => 'N4-BATCH-2026',
                    'id_mapel' => $mapelN4->id_mapel,
                ]);
            }
        }
    }
}