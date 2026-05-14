<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mapel;
use App\Models\Enrollment;
use App\Models\Rps;
use App\Models\Tugas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Guru
        $guru = User::create([
            'name' => 'Neida Nurfadillah',
            'email' => 'neida@seishin.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
        ]);

        $siswa = User::where('email', 'siswa@gmail.com')->first();

        if ($siswa) {
            // 2. Buat Enrollment (Tambahkan order_id dan gross_amount)
            Enrollment::create([
                'id_user' => $siswa->id,
                'order_id' => 'ORD-' . strtoupper(Str::random(10)), // Wajib diisi
                'gross_amount' => 500000, // Wajib diisi
                'jenis_program' => 'N4 Mastering',
                'metode_pembayaran' => 'Transfer Bank',
                'status_pembayaran' => 'Lunas',
                'tanggal_daftar' => now(),
            ]);

            // 3. Buat Mapel (Tambahkan kode_mapel)
            $mapel1 = Mapel::create([
                'kode_mapel' => 'N4-MK001', // Wajib diisi
                'nama_mapel' => 'Pengenalan Huruf Jepang (Hiragana & Katakana)',
                'id_guru' => $guru->id,
            ]);

            // 4. Buat RPS & Tugas (Looping 7 modul)
            for ($i = 1; $i <= 7; $i++) {
                $rps = Rps::create([
                    'pertemuan' => $i,
                    'deskripsi_rps' => "Materi pertemuan ke-$i",
                    'kode_kelas' => 'N4-BATCH5',
                    'id_mapel' => $mapel1->id_mapel,
                ]);

                Tugas::create([
                    'judul_tugas' => "Latihan Modul $i",
                    'deskripsi_tugas' => "Selesaikan latihan pada modul $i",
                    'waktu_pengumpulan' => now()->addDays(7),
                    'status_tugas' => 'Aktif',
                    'id_rps' => $rps->id_rps,
                ]);
            }
        }
    }
}