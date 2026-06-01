<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgressBahanAjarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama agar fresh saat running ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('bahan_ajar_progress')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Skenario: Ambil ID semua bahan ajar yang sukses dibuat dari BahanAjarSeeder
        $allBahanAjarIds = DB::table('bahan_ajar')->pluck('id_bahan_ajar')->toArray();

        $progressData = [];

        // =========================================================================
        // SKENARIO SISWA 1 (id_user: 5) -> Siswa Rajin (Selesai membaca semua materi)
        // =========================================================================
        foreach ($allBahanAjarIds as $idBahanAjar) {
            $progressData[] = [
                'id_user' => 5, // Menggunakan ID 5
                'id_bahan_ajar' => $idBahanAjar,
                'is_complete' => true, // Ditandai SELESAI semua
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // =========================================================================
        // SKENARIO SISWA 2 (id_user: 7) -> Siswa Cicil (Baru selesai beberapa modul)
        // =========================================================================
        // Contoh: Siswa ID 7 baru menyelesaikan Modul 1 (ID bahan ajar 1, 2, 3) dan Modul 2 (ID 4, 5)
        $completedBySiswa7 = [1, 2, 3, 4, 5]; 

        foreach ($allBahanAjarIds as $idBahanAjar) {
            $progressData[] = [
                'id_user' => 7, // Menggunakan ID 7
                'id_bahan_ajar' => $idBahanAjar,
                // Jika ID masuk di array atas maka true (complete), jika tidak maka false
                'is_complete' => in_array($idBahanAjar, $completedBySiswa7), 
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert sekaligus ke database agar prosesnya cepat (Bulk Insert)
        DB::table('bahan_ajar_progress')->insert($progressData);
    }
}