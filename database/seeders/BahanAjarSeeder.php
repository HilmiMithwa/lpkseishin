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
            // MAPEL 1: N5 MASTERING (id_modul: 1 - 6)
            // =========================================================================

            // --- Modul 1: Dasar Hiragana & Katakana (3 Materi) ---
            [
                'id_modul' => 1,
                'nama_bahan_ajar' => 'Pengenalan Huruf Hiragana Dasar (A - SO)',
                'type' => 'theory', // Jenis: Teks + Video + File
                'bahan_ajar_description' => '<p>Materi awal penulisan Jepang. Fokus pada baris vokal dasar (あいうえお) hingga baris Sa (さしすせそ) dengan stroke order.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo',
                'video_title' => 'Hiragana Masterclass Part 1',
                'video_duration' => '12:45',
                'focus_skill' => 'Writing & Reading',
                'key_points' => 'Urutan goresan, kemiringan karakter, membedakan あ dan お.',
                'objective' => 'Siswa dapat menulis dan melafalkan 20 huruf Hiragana pertama tanpa ragu.',
                'sensei_note' => 'Ikuti aliran kuas pada panduan gambarnya.',
                'nama_dokumen_ajar' => 'Workbook_Hiragana_A_SO.pdf',
                'path_file_dokumen_ajar' => '/documents/materials/hiragana-a-so.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 1,
                'nama_bahan_ajar' => 'Lembar Latihan Menulis Huruf Katakana Dasar',
                'type' => 'practice', // Jenis: Teks + File
                'bahan_ajar_description' => '<p>Silakan unduh dokumen latihan menulis berikut untuk memperlancar kelenturan tangan Anda dalam menulis alfabet Katakana.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Writing', 'key_points' => 'Katakana stroke order', 'objective' => 'Lancar menulis Katakana', 'sensei_note' => 'Print file ini lalu kerjakan manual',
                'nama_dokumen_ajar' => 'Workbook_Katakana_Dasar.pdf',
                'path_file_dokumen_ajar' => '/documents/materials/katakana-dasar.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 1,
                'nama_bahan_ajar' => 'Sejarah dan Evolusi Aksara Jepang Klasik',
                'type' => 'theory', // Jenis: Teks Saja
                'bahan_ajar_description' => '<p>Wawasan budaya mengenai asal-usul huruf Jepang yang diadaptasi dari Kanji China (Kanbun) menjadi penyederhanaan fonetik Hiragana oleh kaum wanita di era Heian.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'History', 'key_points' => 'Era Heian, Kanji Adaptation', 'objective' => 'Memahami latar belakang budaya aksara', 'sensei_note' => 'Cukup dibaca untuk menambah wawasan',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

            // --- Modul 2: Partikel Dasar (Wa, Ni, De) (2 Materi) ---
            [
                'id_modul' => 2,
                'nama_bahan_ajar' => 'Menguasai Partikel Topik Subjek (Wa vs Ga)',
                'type' => 'theory', // Jenis: Teks + Video
                'bahan_ajar_description' => '<p>Sesi kupas tuntas perbedaan mendasar penggunaan partikel penanda topik は (wa) dan partikel penanda subjek fokus が (ga).</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo',
                'video_title' => 'Rahasia Membedakan Partikel Wa & Ga',
                'video_duration' => '10:15',
                'focus_skill' => 'Grammar',
                'key_points' => 'Topik sentral vs penekanan informasi baru.',
                'objective' => 'Siswa tidak tertukar lagi menempatkan Wa dan Ga dalam kalimat.',
                'sensei_note' => 'Gunakan Ga ketika kata tanya (Dare, Nani) berada di depan subjek.',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 2,
                'nama_bahan_ajar' => 'Cheatsheet Fungsi Partikel Lokasi (Ni & De)',
                'type' => 'theory', // Jenis: Teks + File
                'bahan_ajar_description' => '<p><p>Ringkasan rumus cepat memahami kapan menggunakan Ni untuk titik keberadaan, dan kapan menggunakan De untuk lokasi terjadinya aktivitas.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Grammar Chart', 'key_points' => 'Action location vs static location', 'objective' => 'Paham penempatan partikel tempat', 'sensei_note' => 'Simpan PDF ini di HP sebagai referensi cepat',
                'nama_dokumen_ajar' => 'Cheatsheet_Partikel_Ni_De.pdf',
                'path_file_dokumen_ajar' => '/documents/materials/partikel-ni-de.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

            // --- Modul 3: Kata Kerja Bentuk Masu (2 Materi) ---
            [
                'id_modul' => 3,
                'nama_bahan_ajar' => 'Konjugasi Kata Kerja Formal Bentuk ~Masu',
                'type' => 'theory', // Jenis: Teks + Video + File
                'bahan_ajar_description' => '<p>Perubahan kata kerja kamus ke bentuk sopan (~Masu), bentuk negatif (~Masen), serta bentuk lampau (~Mashita).</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo',
                'video_title' => 'Mudah Mengubah Kata Kerja Kamus ke Masu',
                'video_duration' => '14:20',
                'focus_skill' => 'Grammar',
                'key_points' => 'Golongan 1 (U->I), Golongan 2 (Ru->Masu), Golongan 3 (Irregular).',
                'objective' => 'Siswa mampu merubah status waktu kata kerja formal.',
                'sensei_note' => 'Hafalkan pengecualian seperti "Taberu" dan "Neru" masuk golongan 2.',
                'nama_dokumen_ajar' => 'Tabel_Konjugasi_Kata_Kerja_Masu.pdf',
                'path_file_dokumen_ajar' => '/documents/materials/konjugasi-masu.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 3,
                'nama_bahan_ajar' => 'Identifikasi Mandiri Golongan Kata Kerja 1, 2, 3',
                'type' => 'practice', // Jenis: Teks Saja
                'bahan_ajar_description' => '<p>Bacalah teks narasi pendek di bawah ini, temukan minimal 10 kata kerja tersembunyi, lalu klasifikasikan ke dalam tabel kelompok golongannya masing-masing.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Analyzing', 'key_points' => 'Verb grouping rules', 'objective' => 'Tajam membedakan rumpun kata kerja', 'sensei_note' => 'Laporkan hasil klasifikasimu ke grup chat bimbingan',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

            // --- Modul 4: Kosakata Sehari-hari (N5) (4 Materi) ---
            [
                'id_modul' => 4,
                'nama_bahan_ajar' => 'Goi Seputar Hubungan Anggota Keluarga (Kazoku)',
                'type' => 'theory', // Jenis: Teks + Video
                'bahan_ajar_description' => '<p>Belajar menyebutkan silsilah keluarga sendiri (rendah hati) vs menyebutkan keluarga orang lain (hormat).</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'Sebutan Kazoku & Kyodai', 'video_duration' => '09:12', 'focus_skill' => 'Vocabulary', 'key_points' => 'Chichi vs Otousan, Haha vs Okaasan', 'objective' => 'Bisa menceritakan profil keluarga', 'sensei_note' => 'Gunakan sebutan hormat jika memuji orang lain',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 4,
                'nama_bahan_ajar' => 'Daftar Kata Sifat-I dan Kata Sifat-Na Level Esensial',
                'type' => 'theory', // Jenis: Teks + File
                'bahan_ajar_description' => '<p>Kumpulan 50 kata sifat yang paling krusial digunakan untuk menggambarkan kondisi benda, cuaca, dan perasaan sekitar asrama.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Vocabulary List', 'key_points' => 'Keiyoushi rules', 'objective' => 'Memperkaya kosakata deskriptif', 'sensei_note' => 'Kata Sifat-Na butuh "na" jika langsung menyambung kata benda',
                'nama_dokumen_ajar' => 'Daftar_Keiyoushi_N5.pdf', 'path_file_dokumen_ajar' => '/documents/materials/goi-kata-sifat.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 4,
                'nama_bahan_ajar' => 'Kata Kerja Aktivitas Domestik Rumah & Asrama',
                'type' => 'theory', // Jenis: Teks Saja
                'bahan_ajar_description' => '<p>Daftar Goi esensial: Souji suru (menyapu), Sentaku suru (mencuci baju), Gohan wo taku (memasak nasi), dan Okiiru (bangun tidur).</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Daily Vocab', 'key_points' => 'Household chores vocabulary', 'objective' => 'Mandiri berkomunikasi di lingkungan asrama', 'sensei_note' => 'Catat kosakata baru ini di buku saku Anda',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 4,
                'nama_bahan_ajar' => 'Video Drill Cepat Flashcard Tebak Arti Goi N5',
                'type' => 'practice', // Jenis: Teks + Video + File
                'bahan_ajar_description' => '<p>Uji kecepatan memori otak Anda dengan menyimak video interaktif tebak arti kosakata di bawah ini.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'Drill 3 Menit Kosakata N5', 'video_duration' => '03:00', 'focus_skill' => 'Speed Memorizing', 'key_points' => 'Quick response test', 'objective' => 'Kecepatan pemahaman dengar', 'sensei_note' => 'Gunakan cetakan lampiran untuk mencocokkan skor akhir',
                'nama_dokumen_ajar' => 'Lembar_Jawaban_Drill_Vocab.pdf', 'path_file_dokumen_ajar' => '/documents/materials/drill-vocab.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

            // --- Modul 5: Angka, Waktu, dan Tanggal (0 Materi) ---
            // Sengaja dikosongkan (0 materi) untuk menguji kondisi @empty halaman list modul kamu!

            // --- Modul 6: Ekspresi Salam dan Perkenalan (2 Materi) ---
            [
                'id_modul' => 6,
                'nama_bahan_ajar' => 'Etika Melakukan Perkenalan Diri (Jikoshoukai) Formal',
                'type' => 'theory', // Jenis: Teks + Video
                'bahan_ajar_description' => '<p>Simulasi baku memperkenalkan diri di depan jajaran direksi / pewawancara kerja asal Jepang untuk meyakinkan pihak perusahaan.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'SOP Jikoshoukai Kerja', 'video_duration' => '07:40', 'focus_skill' => 'Public Speaking', 'key_points' => 'Hajimemashite, Douzo yoroshiku onegaishimasu', 'objective' => 'Percaya diri saat interview magang', 'sensei_note' => 'Pastikan posisi berdiri tegap lurus saat berbicara',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 6,
                'nama_bahan_ajar' => 'Derajat Kemiringan Membungkuk (Ojigi) Budaya Jepang',
                'type' => 'theory', // Jenis: Teks + File
                'bahan_ajar_description' => '<p>Modul bergambar mengenai perbedaan kemiringan 15 derajat (Eshaku), 30 derajat (Keirei), hingga 45 derajat (Saikeirei) beserta tujuannya.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Manners', 'key_points' => 'Business ethics & bowing angle', 'objective' => 'Menghindari salah paham etika kesopanan', 'sensei_note' => 'Jangan membungkuk sambil mata melirik ke atas',
                'nama_dokumen_ajar' => 'Panduan_Ojigi_Visual.pdf', 'path_file_dokumen_ajar' => '/documents/materials/ojigi-guide.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],


            // =========================================================================
            // MAPEL 2: N4 MASTERING (id_modul: 7 - 11)
            // =========================================================================

            // --- Modul 7: Bentuk Te (Menghubungkan Kalimat) (3 Materi) ---
            [
                'id_modul' => 7,
                'nama_bahan_ajar' => 'Aturan Konjugasi Bentuk Te Kata Kerja Golongan I',
                'type' => 'theory', // Jenis: Teks + Video
                'bahan_ajar_description' => '<p>Perubahan akhiran rumit kata kerja golongan satu seperti u-tsu-ru berubah menjadi tte, mu-bu-nu menjadi nde, dst.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'Mastering Godan Doushi Te-Form', 'video_duration' => '11:15', 'focus_skill' => 'Grammar', 'key_points' => 'U, tsu, ru -> tte; mu, bu, nu -> nde', 'objective' => 'Hafal luar kepala rumus golongan 1', 'sensei_note' => 'Awas ada satu pengecualian: Iku (pergi) berubah jadi Itte',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 7,
                'nama_bahan_ajar' => 'Lagu Jembatan Keledai Hafalan Cepat Bentuk Te',
                'type' => 'theory', // Jenis: Teks + Video + File
                'bahan_ajar_description' => '<p>Gunakan irama lagu anak terkenal untuk mempermudah ingatan motorik Anda menyerap seluruh rumus perubahan bentuk Te dalam sekejap.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'Sing Along Te-Form Song', 'video_duration' => '04:30', 'focus_skill' => 'Audio Memorizing', 'key_points' => 'Song mnemonic device', 'objective' => 'Hafal konjugasi tanpa stress tertukar', 'sensei_note' => 'Putar lagu ini sambil ikut bernyanyi setiap pagi sebelum mulai kelas',
                'nama_dokumen_ajar' => 'Lirik_Lagu_Aman_Bentuk_Te.pdf', 'path_file_dokumen_ajar' => '/documents/materials/lirik-lagu-te.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 7,
                'nama_bahan_ajar' => 'Lembar Latihan Menggabungkan Dua Klausa Aktivitas',
                'type' => 'practice', // Jenis: Teks + File
                'bahan_ajar_description' => '<p>Lembar tugas menyatukan dua kalimat mandiri menjadi satu jalinan kalimat runut urutan kronologis kejadian (Asa okite, gohan wo tabemasu).</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Sentence Building', 'key_points' => 'Sequential actions linking', 'objective' => 'Mampu bercerita kronologis kejadian', 'sensei_note' => 'Gunakan tanda koma pembatas setelah bentuk Te selesai ditulis',
                'nama_dokumen_ajar' => 'Workbook_Kalimat_Bentuk_Te.pdf', 'path_file_dokumen_ajar' => '/documents/materials/workbook-te.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

            // --- Modul 8: Keigo Dasar dalam Pekerjaan (1 Materi) ---
            [
                'id_modul' => 8,
                'nama_bahan_ajar' => 'Penerapan Sonkeigo (Hormat) & Kenjougo (Rendah Hati)',
                'type' => 'theory', // Jenis: Teks + Video + File
                'bahan_ajar_description' => '<p>Bahasa sopan level bisnis kerja di Jepang. Menghormati posisi klien / atasan dan merendahkan posisi diri sendiri untuk menunjukkan kerendahan hati korporat.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'Dasar Keigo Bisnis Jepang', 'video_duration' => '15:35', 'focus_skill' => 'Business Manner', 'key_points' => 'Irassharu, Moushiagemasu, Keigo levels', 'objective' => 'Siap bekerja di lingkungan industri formal Jepang', 'sensei_note' => 'Sangat vital bagi peserta magang / Tokutei Ginou',
                'nama_dokumen_ajar' => 'Buku_Saku_Keigo_Dunia_Kerja.pdf', 'path_file_dokumen_ajar' => '/documents/materials/keigo-pocketbook.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

            // --- Modul 9: Kata Kerja Potensial (Bisa/Tidak Bisa) (2 Materi) ---
            [
                'id_modul' => 9,
                'nama_bahan_ajar' => 'Pola Kalimat ~Koto ga dekiru vs Bentuk ~Reru',
                'type' => 'theory', // Jenis: Teks + Video
                'bahan_ajar_description' => '<p>Membandingkan cara menyatakan kemampuan lewat susunan kata dasar ditambah koto ga dekiru dengan konjugasi menyatu struktur potensial doushi level N4.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'Menyatakan Kemampuan (Potensial)', 'video_duration' => '09:50', 'focus_skill' => 'Grammar Comparison', 'key_points' => 'Yomeru vs Yomu koto ga dekiru', 'objective' => 'Dapat meringkas kalimat potensial lebih efisien', 'sensei_note' => 'Partikel Wo (を) biasanya berubah menjadi Ga (が) pada bentuk potensial murni',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 9,
                'nama_bahan_ajar' => 'Daftar Pengecualian Kata Kerja Potensial Alami',
                'type' => 'theory', // Jenis: Teks Saja
                'bahan_ajar_description' => '<p>Membahas perbedaan kata kerja intrinsik yang dari awalnya bermakna bisa terlihat/terdengar otomatis tanpa konjugasi: Mieru (kelihatan) vs Rareru (bisa melihat sengaja), Kikoeru vs Kikeru.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Nuance Analysis', 'key_points' => 'Mieru/Kikoeru natural capacity', 'objective' => 'Paham nuansa makna kalimat pendengaran', 'sensei_note' => 'Materi ini sering mengecoh di sesi ujian Chokai',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

            // --- Modul 10: Ekspresi Pengandaian (Kalau / Jika) (3 Materi) ---
            [
                'id_modul' => 10,
                'nama_bahan_ajar' => 'Penggunaan Pola Pengandaian Kondisional ~Tara',
                'type' => 'theory', // Jenis: Teks + Video
                'bahan_ajar_description' => '<p>Membahas syarat pengandaian bersyarat masa depan menggunakan bentuk lampau kasual ditambah akhiran ra (Nihon ni ittara, fuji-san ni climbing shitai).</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'Kondisional Tara Level N4', 'video_duration' => '11:02', 'focus_skill' => 'Grammar Structure', 'key_points' => 'Ta-form + ra suffix, future conditional', 'objective' => 'Mampu merencanakan kalimat bersyarat logis', 'sensei_note' => 'Pola Tara adalah rumpun pengandaian paling aman digunakan di segala situasi',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 10,
                'nama_bahan_ajar' => 'Analisis Perbedaan Nuansa Pola (~Tara, ~Ba, ~To)',
                'type' => 'theory', // Jenis: Teks + File
                'bahan_ajar_description' => '<p>Bedah tuntas jebakan tersulit tata bahasa N4: Pola To untuk hukum alam mutlak, Ba untuk syarat krusial ekonomi/logika, dan Tara untuk pengandaian umum.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Advanced Comparison', 'key_points' => 'Hukum alam vs rencana pribadi', 'objective' => 'Lolos jebakan soal kembar tatabahasa JLPT', 'sensei_note' => 'Cetak analisis bagan tabel pembeda ini agar mudah dibaca berulang kali',
                'nama_dokumen_ajar' => 'Tabel_Bagan_Pembeda_Kondisional.pdf', 'path_file_dokumen_ajar' => '/documents/materials/kondisional-pembeda.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 10,
                'nama_bahan_ajar' => 'Studi Kasus Percakapan Logika Rencana Masa Depan',
                'type' => 'practice', // Jenis: Teks Saja
                'bahan_ajar_description' => '<p>Tugas mandiri: Tulislah esai pendek sepanjang 150 kata mengenai apa rencana taktis hidup Anda jika lolos seleksi kontrak magang visa EPA ke Jepang.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Creative Writing', 'key_points' => 'Future plans drafting using ~tara', 'objective' => 'Melatih penuangan ide abstrak ke tata bahasa jepang riil', 'sensei_note' => 'Kirim draf karanganmu ke portal asisten guru untuk dikoreksi',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

            // --- Modul 11: Kosakata Tempat Kerja (2 Materi) ---
            [
                'id_modul' => 11,
                'nama_bahan_ajar' => 'Kosakata Prosedur K3 Keselamatan Pabrik (Anzen Eisei)',
                'type' => 'theory', // Jenis: Teks + Video + File
                'bahan_ajar_description' => '<p>Sangat vital! Mengenal istilah instruksi tanggap darurat, rambu bahaya listrik, zona wajib helm, pemeliharaan kebersihan mesin, dan pelaporan kecelakaan kerja.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'SOP Anzen First Proyek Jepang', 'video_duration' => '13:12', 'focus_skill' => 'Industrial Vocab', 'key_points' => 'Kiken (Bahaya), Anzen Daiichi (Utamakan Selamat), Daijoubu', 'objective' => 'Mencegah kecelakaan kerja fatal akibat gagal menerjemahkan rambu', 'sensei_note' => 'Hafalkan tanda seru merah dan lambang silang hijau khas industri Jepang',
                'nama_dokumen_ajar' => 'Kamus_Istilah_K3_Industri_Manufaktur.pdf', 'path_file_dokumen_ajar' => '/documents/materials/anzen-eisei-vocab.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 11,
                'nama_bahan_ajar' => 'Struktur Jabatan Hierarki Perusahaan Jepang (Shakaijin)',
                'type' => 'theory', // Jenis: Teks + File
                'bahan_ajar_description' => '<p>Mengenal tingkatan panggilan nama atasan korporasi dari level terendah Shain (Karyawan biasa), Shouchou (Supervisor), Kanchou (Manajer), hingga Shachou (Direktur Utama).</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Company Culture', 'key_points' => 'Keigo hierarchy addressing', 'objective' => 'Mampu memanggil nama atasan dengan sebutan hormat profesional', 'sensei_note' => 'Di Jepang, panggil jabatan di belakang marga, misal: Tanaka-Shachou',
                'nama_dokumen_ajar' => 'Bagan_Hierarki_Corporate_Jepang.pdf', 'path_file_dokumen_ajar' => '/documents/materials/corporate-structure.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],


            // =========================================================================
            // MAPEL 3: VOCABULARY MASTERY (id_modul: 12 - 15)
            // =========================================================================

            // --- Modul 12: Pemahaman Dokkai Level Menengah (2 Materi) ---
            [
                'id_modul' => 12,
                'nama_bahan_ajar' => 'Strategi Skimming & Scanning Teks Panjang N3',
                'type' => 'theory', // Jenis: Teks + File
                'bahan_ajar_description' => '<p>Trik menghemat durasi ujian membaca dengan cara berburu kata kunci partikel, kesimpulan di kalimat akhir pargraf, tanpa perlu membaca seluruh huruf kata per kata.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Reading Strategy', 'key_points' => 'Keyword hunting, concluding lines priority', 'objective' => 'Selesai membaca sebelum batas waktu habis', 'sensei_note' => 'Selalu baca pertanyaan soal terlebih dahulu sebelum melirik teks panjangnya',
                'nama_dokumen_ajar' => 'Modul_Trik_Dokkai_Akselerasi.pdf', 'path_file_dokumen_ajar' => '/documents/materials/dokkai-skimming.pdf',
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 12,
                'nama_bahan_ajar' => 'Bedah Soal Dokkai Esai Opini JLPT Proyek Resmi',
                'type' => 'practice', // Jenis: Teks + Video
                'bahan_ajar_description' => '<p>Saksikan rekaman pengerjaan langsung beserta alasan pemilihan jawaban benar dari soal tryout esai argumen opini pembicara asli Jepang.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'Live Review Esai Dokkai N3', 'video_duration' => '16:40', 'focus_skill' => 'Analyzing Text', 'key_points' => 'Speaker intent identification', 'objective' => 'Paham maksud terselubung penulis jepang', 'sensei_note' => 'Perhatikan baik kata pembalik arah kalimat seperti "Shikashi" atau "Demo"',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

            // --- Modul 13: Tata Bahasa Formal vs Kasual (1 Materi) ---
            [
                'id_modul' => 13,
                'nama_bahan_ajar' => 'Regulasi Penyesuaian Derajat Bahasa di Luar Kantor',
                'type' => 'theory', // Jenis: Teks Saja
                'bahan_ajar_description' => '<p>Panduan bergaul akrab (*Futsuu-go*) bersama teman sejawat di warung makan / Izakaya setelah jam kerja selesai tanpa menyinggung aturan tata krama bisnis senioritas (*Senpai-Kouhai*).</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Social Adaptability', 'key_points' => 'Formal vs Plain form switching social context', 'objective' => 'Mampu mencairkan suasana pertemanan dengan luwes', 'sensei_note' => 'Jangan gunakan bahasa kasual jika atasan pabrik Anda berada di ruangan yang sama',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                //'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

            // --- Modul 14: Membaca Artikel Berita Pendek (0 Materi) ---
            // Sengaja dikosongkan (0 materi) untuk variasi jumlah seeder per modul!

            // --- Modul 15: Ungkapan Perasaan dan Opini (2 Materi) ---
            [
                'id_modul' => 15,
                'nama_bahan_ajar' => 'Mengutarakan Pendapat Pribadi Berwibawa (~To Omoimasu)',
                'type' => 'theory', // Jenis: Teks + Video + File
                'bahan_ajar_description' => '<p>Mempelajari tata cara menyisipkan argumen spekulatif personal secara halus menggunakan gabungan kalimat kasual diakhiri frase pembungkus sopan To Omoimasu.</p>',
                'video_url' => 'https://www.youtube.com/watch?v=gfbYOyq4SKo', 'video_title' => 'Menyatakan Opini To Omoimasu', 'video_duration' => '08:50', 'focus_skill' => 'Expressing Thought', 'key_points' => 'Plain form + to omoimasu / to iimasu', 'objective' => 'Dapat berdiskusi rapat menyumbangkan saran ide', 'sensei_note' => 'Frase ini sangat penting agar argumen Anda terdengar santun tidak menggurui',
                'nama_dokumen_ajar' => 'Daftar_Ekspresi_Diskusi_Rapat.pdf', 'path_file_dokumen_ajar' => '/documents/materials/to-omoimasu-guide.pdf',
                //  'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'id_modul' => 15,
                'nama_bahan_ajar' => 'Ragam Kosakata Mengekspresikan Rasa Empati Alami',
                'type' => 'theory', // Jenis: Teks Saja
                'bahan_ajar_description' => '<p>Kumpulan Goi ungkapan rasa peduli mendalam: Taihen desu ne (Aduh berat sekali ya), Sokko desu ka (Oalah begitu ya), hingga Omedetou gozaimasu untuk ikut merayakan kegembiraan rekan.</p>',
                'video_url' => null, 'video_title' => null, 'video_duration' => null, 'focus_skill' => 'Empathy Vocabulary', 'key_points' => 'Aizuchi sympathetic expressions', 'objective' => 'Dapat menjadi pendengar obrolan jepang yang responsif aktif', 'sensei_note' => 'Orang Jepang sangat menyukai lawan bicara yang rajin memberikan feedback empati (*Aizuchi*)',
                'nama_dokumen_ajar' => null, 'path_file_dokumen_ajar' => null,
                // 'is_complete' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],

        ]);
    }
}