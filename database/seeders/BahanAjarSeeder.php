<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BahanAjarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama agar fresh saat running ulang
        DB::table('bahan_ajar')->truncate();

        DB::table('bahan_ajar')->insert([
            
            // =========================================================================
            // KELOMPOK 1: MATERI UNTUK MAPEL "N5 BASIC" (id_modul: 1)
            // =========================================================================
            [
                'id_modul' => 1,
                'nama_bahan_ajar' => 'Pengenalan Huruf Hiragana Dasar (A - SO)',
                'type' => 'theory', // 🌟 Diubah jadi huruf kecil agar lolos CHECK constraint
                'bahan_ajar_description' => '<p>Materi awal untuk menguasai sistem penulisan Jepang. Kita fokus pada baris vokal dasar (あいうえお) hingga baris Sa (さしすせそ) lengkap dengan stroke order.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=6p9Ih_10_m4',
                'video_title' => 'Hiragana Masterclass Part 1',
                'video_duration' => '12:45',
                'focus_skill' => 'Writing & Reading',
                'key_points' => 'Urutan goresan (stroke order), kemiringan karakter, membedakan Huruf A (あ) dan O (お).',
                'objective' => 'Siswa dapat menulis dan melafalkan 20 huruf Hiragana pertama tanpa ragu.',
                'sensei_note' => 'Jangan ditarik terlalu kaku, ikuti aliran kuas pada panduan gambarnya.',
                'nama_dokumen_ajar' => 'Workbook_Hiragana_A_SO.pdf',
                'path_file_dokumen_ajar' => '/documents/materials/hiragana-a-so.pdf',
                'is_complete' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // =========================================================================
            // KELOMPOK 2: MATERI UNTUK MAPEL "N4 MASTERING" (id_modul: 6)
            // =========================================================================
            [
                'id_modul' => 6,
                'nama_bahan_ajar' => 'Metode Hafalan Cepat Perubahan Kata Kerja Bentuk Te (~Te)',
                'type' => 'theory', // 🌟 Diubah jadi 'theory' agar sesuai opsi enum tabel bahan_ajar
                'bahan_ajar_description' => '<p>Mempelajari aturan konjugasi kata kerja golongan 1, 2, dan 3 menjadi bentuk sambung (~te) menggunakan metode lagu jembatan keledai agar mudah dihafal.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=6eeae9.png', 
                'video_title' => 'Lagu Konjugasi Kata Kerja Bentuk Te',
                'video_duration' => '05:45',
                'focus_skill' => 'Grammar (Bunpou)',
                'key_points' => 'Perubahan golongan 1 (u, tsu, ru -> tte), golongan 2 (ru -> te), dan golongan 3 (suru -> shite).',
                'objective' => 'Siswa hafal seluruh perubahan bentuk kata kerja menyambung kalimat menggunakan irama lagu.',
                'sensei_note' => 'Nyanyikan lagu konjugasi ini setiap pagi sebelum memulai aktivitas belajar kelas tatap muka!',
                'nama_dokumen_ajar' => 'Tabel_Perubahan_Bentuk_Te.pdf',
                'path_file_dokumen_ajar' => '/documents/materials/bentuk-te-chart.pdf',
                'is_complete' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // =========================================================================
            // KELOMPOK 3: MATERI UNTUK MAPEL 3 "VOCABULARY MASTERY" (id_modul: 12)
            // =========================================================================
            [
                'id_modul' => 12, // Menyesuaikan id_modul riil dari log error-mu
                'nama_bahan_ajar' => 'Strategi Cepat Menguasai 100 Kosakata N5 Paling Sering Muncul',
                'type' => 'practice', // 🌟 Diubah menggunakan nilai dasar 'practice' agar valid dengan database
                'bahan_ajar_description' => '<p>Modul akselerasi khusus pemantapan kosakata (Goi) yang paling sering keluar pada ujian JLPT N5 maupun NAT-TEST, lengkap dengan contoh aplikasinya pada kalimat majemuk.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=6eeae9.png', 
                'video_title' => 'Teknik Spaced Repetition untuk Goi Jepang',
                'video_duration' => '10:15',
                'focus_skill' => 'Vocabulary Mastery',
                'key_points' => 'Kata sifat-I, kata sifat-Na, kata kerja aktivitas harian pabrik dan asrama.',
                'objective' => 'Siswa mampu mengingat dan mengonstruksi kalimat dengan 100 kosakata target dalam waktu singkat.',
                'sensei_note' => 'Gunakan metode flashcard yang ada di menu sebelah kiri untuk menguji hafalan mandiri setelah menyimak materi ini.',
                'nama_dokumen_ajar' => 'Daftar_100_Goi_Wajib_N5.pdf',
                'path_file_dokumen_ajar' => '/documents/materials/100-goi-n5.pdf',
                'is_complete' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}