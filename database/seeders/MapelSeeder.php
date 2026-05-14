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
        $guru = User::where('name', 'Mizan')->first();

        if ($guru) {
            $mapelData = [
                [
                    'kode_mapel' => 'N590',
                    'nama_mapel' => 'N5 Mastering',
                    'deskripsi_mapel' => 'Program intensif 3 bulan (396 JP) dengan fokus praktik. Mencakup 8 unit kompetensi dasar bahasa Jepang hingga persiapan ujian level N5.',
                    'id_guru' => $guru->id,
                    'jp' => 30,
                    'status' => 'Aktif'
                ],
                [
                    'kode_mapel' => 'N591',
                    'nama_mapel' => 'N4 Mastering',
                    'deskripsi_mapel' => 'Program lanjutan 2 bulan (264 JP) dengan fokus praktik. Mencakup 7 unit kompetensi bahasa Jepang hingga persiapan ujian level N4.',
                    'id_guru' => $guru->id,
                    'jp' => 30,
                    'status' => 'Aktif'
                ],
                [
                    'kode_mapel' => 'N592',
                    'nama_mapel' => 'N3 Mastering',
                    'deskripsi_mapel' => 'Program lanjutan 2 bulan (264 JP) dengan fokus praktik. Mencakup 7 unit kompetensi bahasa Jepang hingga persiapan ujian level N3.',
                    'id_guru' => $guru->id,
                    'jp' => 30,
                    'status' => 'Aktif'
                ]
            ];

            foreach ($mapelData as $data) {
                Mapel::create($data);
            }

            $yussar = User::where('name', 'Yussar')->first();
            $hilmi = User::where('name', 'Hilmi Mithwa')->first();

            $mapelN590 = Mapel::where('kode_mapel', 'N590')->first();
            $mapelN591 = Mapel::where('kode_mapel', 'N591')->first();
            $mapelN592 = Mapel::where('kode_mapel', 'N592')->first();

            if ($yussar && $mapelN590) {
                $yussar->mapels()->attach($mapelN590);
            };

            if ($hilmi && $mapelN590 && $mapelN591) {
                $hilmi->mapels()->attach([$mapelN590->id_mapel, $mapelN591->id_mapel]);
            };


        }
    }
}
