<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil semua ID mapel yang valid dari database
        $mapelIds = DB::table('mapel')->pluck('id_mapel')->toArray();

        if (empty($mapelIds)) {
            $this->command->warn('Gagal membuat seeder: Pastikan tabel `mapel` sudah ada datanya!');
            return;
        }

        // Ambil ID mapel pertama atau acak dari database agar tidak memaksakan angka '1' jika tidak ada
        $defaultMapel = $mapelIds[0]; 
        $randomMapel1 = $mapelIds[array_rand($mapelIds)];
        $randomMapel2 = $mapelIds[array_rand($mapelIds)];

        $announcements = [
            [
                'title' => 'Pengumuman Ujian Tengah Semester',
                'date_formatted' => Carbon::now()->format('Y-m-d'),
                'id_mapel' => $defaultMapel, // Menggunakan ID mapel yang valid dari DB
                'id_guru' => 6, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Tugas Utama Menggambar',
                'date_formatted' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'id_mapel' => $randomMapel1,
                'id_guru' => 1, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Materi Pembelajaran Tambahan',
                'date_formatted' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'id_mapel' => $randomMapel2,
                'id_guru' => 2, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('announcement')->insert($announcements);
        $this->command->info('AnnouncementSeeder berhasil dijalankan!');
    }
}