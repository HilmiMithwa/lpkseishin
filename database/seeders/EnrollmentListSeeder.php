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
        // Cari User secara dinamis berdasarkan email atau nama
        $hilmi = User::where('email', 'hilmi@gmail.com')->first();
        $yussar = User::where('email', 'yussar@gmail.com')->first();

        // Cari Mapel secara dinamis berdasarkan kode_mapel
        $mapelN5 = Mapel::where('kode_mapel', 'N590')->first();
        $mapelN4 = Mapel::where('kode_mapel', 'N591')->first();
        $mapelN3 = Mapel::where('kode_mapel', 'N592')->first();

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