<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rps;
use App\Models\Mapel;

class RpsSeeder extends Seeder
{
    public function run(): void
    {
        // ===================== N4 =====================
        $mapelN4 = Mapel::where('kode_mapel', 'N591')->first();

        $rpsN4 = [
            [
                'pertemuan' => 1,
                'deskripsi_rps' => 'Pengenalan struktur ujian JLPT N4 dan review materi N5.',
                'certification_target' => 'JLPT N4',
                'schedule' => 'Setiap Senin 09:00 - 11:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 2,
                'deskripsi_rps' => 'Bentuk Te (〜て) untuk menghubungkan kalimat.',
                'certification_target' => 'JLPT N4',
                'schedule' => 'Setiap Senin 09:00 - 11:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 3,
                'deskripsi_rps' => 'Kata kerja potensial — menyatakan kemampuan (〜られる / 〜える).',
                'certification_target' => 'JLPT N4',
                'schedule' => 'Setiap Senin 09:00 - 11:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 4,
                'deskripsi_rps' => 'Ekspresi pengandaian:〜たら、〜ば、〜と、〜なら.',
                'certification_target' => 'JLPT N4',
                'schedule' => 'Setiap Senin 09:00 - 11:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 5,
                'deskripsi_rps' => 'Keigo dasar — bahasa sopan dalam konteks pekerjaan.',
                'certification_target' => 'JLPT N4',
                'schedule' => 'Setiap Senin 09:00 - 11:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 6,
                'deskripsi_rps' => 'Latihan membaca (Dokkai) teks pendek level N4.',
                'certification_target' => 'JLPT N4',
                'schedule' => 'Setiap Senin 09:00 - 11:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 7,
                'deskripsi_rps' => 'Simulasi ujian penuh JLPT N4 dan pembahasan.',
                'certification_target' => 'JLPT N4',
                'schedule' => 'Setiap Senin 09:00 - 11:00',
                'total_duration' => 120,
            ],
        ];

        if ($mapelN4) {
            foreach ($rpsN4 as $data) {
                Rps::create(array_merge($data, ['id_mapel' => $mapelN4->id_mapel]));
            }
        }

        // ===================== N5 =====================
        $mapelN5 = Mapel::where('kode_mapel', 'N590')->first();

        $rpsN5 = [
            [
                'pertemuan' => 1,
                'deskripsi_rps' => 'Pengenalan Hiragana dan Katakana — membaca dan menulis.',
                'certification_target' => 'JLPT N5',
                'schedule' => 'Setiap Rabu 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 2,
                'deskripsi_rps' => 'Partikel dasar: は、に、で、を、が.',
                'certification_target' => 'JLPT N5',
                'schedule' => 'Setiap Rabu 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 3,
                'deskripsi_rps' => 'Kata kerja bentuk Masu — kalimat formal.',
                'certification_target' => 'JLPT N5',
                'schedule' => 'Setiap Rabu 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 4,
                'deskripsi_rps' => 'Angka, waktu, tanggal, dan hari dalam bahasa Jepang.',
                'certification_target' => 'JLPT N5',
                'schedule' => 'Setiap Rabu 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 5,
                'deskripsi_rps' => 'Kosakata sehari-hari — rumah, makanan, transportasi.',
                'certification_target' => 'JLPT N5',
                'schedule' => 'Setiap Rabu 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 6,
                'deskripsi_rps' => 'Ekspresi salam, perkenalan, dan percakapan dasar.',
                'certification_target' => 'JLPT N5',
                'schedule' => 'Setiap Rabu 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 7,
                'deskripsi_rps' => 'Latihan Dokkai dan Listening level N5.',
                'certification_target' => 'JLPT N5',
                'schedule' => 'Setiap Rabu 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 8,
                'deskripsi_rps' => 'Simulasi ujian penuh JLPT N5 dan pembahasan.',
                'certification_target' => 'JLPT N5',
                'schedule' => 'Setiap Rabu 13:00 - 15:00',
                'total_duration' => 120,
            ],
        ];

        if ($mapelN5) {
            foreach ($rpsN5 as $data) {
                Rps::create(array_merge($data, ['id_mapel' => $mapelN5->id_mapel]));
            }
        }

        // ===================== N3 =====================
        $mapelN3 = Mapel::where('kode_mapel', 'N592')->first();

        $rpsN3 = [
            [
                'pertemuan' => 1,
                'deskripsi_rps' => 'Review tata bahasa N4 dan pengenalan pola N3.',
                'certification_target' => 'JLPT N3',
                'schedule' => 'Setiap Jumat 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 2,
                'deskripsi_rps' => 'Tata bahasa formal vs kasual — perbedaan dan penggunaan.',
                'certification_target' => 'JLPT N3',
                'schedule' => 'Setiap Jumat 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 3,
                'deskripsi_rps' => 'Membaca artikel berita pendek level N3.',
                'certification_target' => 'JLPT N3',
                'schedule' => 'Setiap Jumat 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 4,
                'deskripsi_rps' => 'Ungkapan perasaan, opini, dan pendapat dalam bahasa Jepang.',
                'certification_target' => 'JLPT N3',
                'schedule' => 'Setiap Jumat 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 5,
                'deskripsi_rps' => 'Pemahaman Dokkai level menengah — teks panjang.',
                'certification_target' => 'JLPT N3',
                'schedule' => 'Setiap Jumat 13:00 - 15:00',
                'total_duration' => 120,
            ],
            [
                'pertemuan' => 6,
                'deskripsi_rps' => 'Simulasi ujian penuh JLPT N3 dan pembahasan.',
                'certification_target' => 'JLPT N3',
                'schedule' => 'Setiap Jumat 13:00 - 15:00',
                'total_duration' => 120,
            ],
        ];

        if ($mapelN3) {
            foreach ($rpsN3 as $data) {
                Rps::create(array_merge($data, ['id_mapel' => $mapelN3->id_mapel]));
            }
        }
    }
}