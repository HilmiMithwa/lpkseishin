<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Mapel;

class EnrollmentListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari User secara dinamis berdasarkan email atau nama (Sudah Benar)
        $hilmi = User::where('email', 'hilmi@gmail.com')->first();
        $yussar = User::where('email', 'yussar@gmail.com')->first();

        // SINKRONISASI: Ubah pencarian dari 'kode_mapel' menjadi 'nama_mapel'
        $mapelN5 = Mapel::where('nama_mapel', 'N5 Mastering')->first();
        $mapelN4 = Mapel::where('nama_mapel', 'N4 Mastering')->first();
        $mapelN3 = Mapel::where('nama_mapel', 'N3 Mastering')->first();

        // Masukkan data hanya jika User dan Mapel ditemukan
        if ($hilmi && $mapelN4) {
            DB::table('enrollment_access')->insert([
                'id_user' => $hilmi->id,
                'id_mapel' => $mapelN4->id_mapel,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if ($yussar && $mapelN4 && $mapelN3) {
            DB::table('enrollment_access')->insert([
                [
                    'id_user' => $yussar->id,
                    'id_mapel' => $mapelN4->id_mapel,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_user' => $yussar->id,
                    'id_mapel' => $mapelN3->id_mapel,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}