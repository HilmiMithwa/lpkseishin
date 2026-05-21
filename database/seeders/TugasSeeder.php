<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tugas;
use App\Models\Rps;
use App\Models\Modul;

class TugasSeeder extends Seeder
{
    public function run(): void
    {
        $rpsList = Rps::all();

        foreach ($rpsList as $rps) {
            $modul = Modul::where('id_mapel', $rps->id_mapel)->first();
            Tugas::create([
                'judul_tugas' => "Latihan Mandiri: " . $rps->pertemuan,
                'deskripsi_tugas' => "Selesaikan latihan soal yang berkaitan dengan materi pertemuan ke-" . $rps->pertemuan,
                'waktu_pengumpulan' => now()->addDays(7),
                'status_tugas' => 'Aktif',
                'id_rps' => $rps->id_rps,
                'id_modul' => $modul?->id_modul,
            ]);
        }
    }
}