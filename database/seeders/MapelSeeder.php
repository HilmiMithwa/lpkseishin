<?php

namespace Database\Seeders;

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
        $guru = User::where('name', 'Mizan')->first();

        if ($guru) {
            $mapelData = [
                [
                    'id_batch' => 1,
                    'nama_mapel' => 'N5 Mastering',
                    'deskripsi_mapel' => 'Program intensif 3 bulan (396 JP) dengan fokus praktik. Mencakup 8 unit kompetensi dasar bahasa Jepang hingga persiapan ujian level N5.',
                    'id_guru' => $guru->id,
                    'jp' => 30,
                    'status' => 'Aktif',
                    'target' => 'JLPT N5',
                    'jadwal' => 'Senin - Kamis',
                    'min_score' => 75 // SINKRONISASI: Ditambahkan agar lolos migrasi NOT NULL
                ],
                [
                    'id_batch' => 2,
                    'nama_mapel' => 'N4 Mastering',
                    'deskripsi_mapel' => 'Program lanjutan 2 bulan (264 JP) dengan fokus praktik. Mencakup 7 unit kompetensi bahasa Jepang hingga persiapan ujian level N4.',
                    'id_guru' => $guru->id,
                    'jp' => 30,
                    'status' => 'Aktif',
                    'target' => 'JLPT N4',
                    'jadwal' => 'Rabu - Jumat',
                    'min_score' => 75 // SINKRONISASI
                ],
                [
                    'id_batch' => 1,
                    'nama_mapel' => 'N3 Mastering',
                    'deskripsi_mapel' => 'Program lanjutan 2 bulan (264 JP) dengan fokus praktik. Mencakup 7 unit kompetensi bahasa Jepang hingga persiapan ujian level N3.',
                    'id_guru' => $guru->id,
                    'jp' => 30,
                    'status' => 'Aktif',
                    'target' => 'JLPT N3',
                    'jadwal' => 'Selasa - Kamis',
                    'min_score' => 80 // SINKRONISASI
                ]
            ];

            foreach ($mapelData as $data) {
                Mapel::create($data);
            }

            // Ambil data User Siswa
            $yussar = User::where('name', 'Yussar')->first();
            $hilmi = User::where('name', 'Hilmi Mithwa')->first();
            $userN3N4 = User::where('email', 'n3n4@gmail.com')->first();
            $userN4N5 = User::where('email', 'n4n5@gmail.com')->first();

            // Ambil data Mapel yang baru di-insert berdasarkan nama
            $mapelN5 = Mapel::where('nama_mapel', 'N5 Mastering')->first();
            $mapelN4 = Mapel::where('nama_mapel', 'N4 Mastering')->first();
            $mapelN3 = Mapel::where('nama_mapel', 'N3 Mastering')->first();

            // Skenario Kontrak Belajar Siswa
            if ($yussar && $mapelN5) {
                $yussar->mapels()->attach($mapelN5->id_mapel);
            }

            if ($hilmi && $mapelN5 && $mapelN4) {
                $hilmi->mapels()->attach([$mapelN5->id_mapel, $mapelN4->id_mapel]);
            }

            // Skenario 1: User mengontrak N3 dan N4
            if ($userN3N4 && $mapelN3 && $mapelN4) {
                $userN3N4->mapels()->attach([$mapelN3->id_mapel, $mapelN4->id_mapel]);
            }

            // Skenario 2: User mengontrak N4 dan N5
            if ($userN4N5 && $mapelN4 && $mapelN5) {
                $userN4N5->mapels()->attach([$mapelN4->id_mapel, $mapelN5->id_mapel]);
            }
        }
    }
}