<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        // Mengambil guru yang sudah dibuat di MapelSeeder
        $guru = User::where('name', 'Mizan')->first();

        if ($guru) {
            DB::table('jadwal')->insert([
                [
                    'judul_pertemuan' => 'Sesi Konsultasi N4',
                    'start_time' => '09:00:00',
                    'end_time' => '11:00:00',
                    'lokasi_pertemuan' => 'Zoom Meeting A',
                    'id_guru' => $guru->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'judul_pertemuan' => 'Evaluasi Bulanan N5',
                    'start_time' => '13:00:00',
                    'end_time' => '15:00:00',
                    'lokasi_pertemuan' => 'Ruang Kelas 302',
                    'id_guru' => $guru->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'judul_pertemuan' => 'Kelas Intensif N5 - Hiragana',
                    'start_time' => '08:00:00',
                    'end_time' => '10:00:00',
                    'lokasi_pertemuan' => 'Ruang Kelas 101',
                    'id_guru' => $guru->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'judul_pertemuan' => 'Sesi Tanya Jawab N3',
                    'start_time' => '14:00:00',
                    'end_time' => '16:00:00',
                    'lokasi_pertemuan' => 'Google Meet B',
                    'id_guru' => $guru->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'judul_pertemuan' => 'Simulasi Ujian JLPT N4',
                    'start_time' => '09:00:00',
                    'end_time' => '12:00:00',
                    'lokasi_pertemuan' => 'Zoom Meeting C',
                    'id_guru' => $guru->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}