<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('batch')->insert([
            [
                'nama' => 'Batch 1',
                'nama_program' => 'Reguler N5',
                'level_target' => 'N5',
                'deskripsi' => 'Angkatan pertama program N5',
                'waktu_mulai' => '2026-06-01',
                'waktu_berakhir' => '2026-09-01',
                'durasi' => '3 Bulan',
                'jadwal' => 'Senin - Kamis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Batch 2',
                'nama_program' => 'Akselerasi N4',
                'level_target' => 'N4',
                'deskripsi' => 'Angkatan kedua program N4',
                'waktu_mulai' => '2026-06-01',
                'waktu_berakhir' => '2026-08-01',
                'durasi' => '2 Bulan',
                'jadwal' => 'Selasa - Jumat',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
