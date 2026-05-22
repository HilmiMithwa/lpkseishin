<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk fitur random
use Illuminate\Support\Facades\Schema;
use App\Models\Modul;
use App\Models\User;
use App\Models\VocabProgress;
use Illuminate\Support\Facades\Http;
use App\Models\BahanAjar;


class StudentController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // 1. Gabungkan pengambilan relasi guru dan hitung modul dalam satu query
        // Ini akan mengisi variabel $subject->modul_count secara otomatis
        $subjects = $user->mapels()->with('guru')->withCount('modul')->get();

        // 2. Ambil data pendaftaran user yang sedang login untuk banner merah
        $enrollment = Enrollment::where('id_user', Auth::id())->first();

        // 3. Fitur Yumegatari: Ambil satu kata secara acak dari database
        // Pastikan temanmu sudah membuat tabel 'daily_words'
        $dailyWord = Schema::hasTable('daily_words')
            ? DB::table('daily_words')->inRandomOrder()->first()
            : null;

        // 4. Kirim semua variabel ke view dashboard
        return view('students.dashboard', compact(
            'subjects',
            'enrollment',
            'dailyWord'
        ));
    }

    public function show($id_mapel)
    {
        /** @var \App\Models\User $user */
        // 1. Cek apakah user yang login benar-benar terdaftar di mapel ini
        $user = Auth::user();
        $isEnrolled = $user->mapels()->where('mapel.id_mapel', $id_mapel)->exists();

        if (!$isEnrolled) {
            // Jika tidak terdaftar, lempar error 403 (Forbidden)
            abort(403, 'NO ACCESS! Kamu belum terdaftar di kelas ini.');
        }

        // 2. Jika lolos pengecekan, baru ambil datanya
        $subject = Mapel::with(['guru', 'rps', 'modul'])->withCount('modul')->findOrFail($id_mapel);

        $enrollment = Enrollment::where('id_user', Auth::id())->first();

        return view('students.class-detail', compact('subject', 'enrollment'));
    }

    
    public function showTask($id_mapel, $id_modul, $id_tugas)
    {
        // 1. Ambil data tugas berdasarkan ID Tugas dan ID Modul (menjaga hirarki)
        $task = DB::table('tugas')
            ->where('id_tugas', $id_tugas)
            ->where('id_modul', $id_modul)
            ->first();

        if (!$task) {
            abort(404, 'Tugas tidak ditemukan di dalam modul ini');
        }

        // 2. Ambil Modul terkait
        $currentModul = DB::table('modul')->where('id_modul', $id_modul)->first();

        // 3. Ambil Mata Pelajaran terkait
        $subject = DB::table('mapel')->where('id_mapel', $id_mapel)->first();

        //Cari nama asli guru ke tabel users menggunakan ID angka tadi
        $guru = DB::table('users')->where('id', $subject->id_guru)->first();

        // 4. Ambil status pengumpulan tugas milik siswa yang sedang login
        $submission = DB::table('pengiriman_tugas')
            ->where('id_tugas', $id_tugas)
            ->where('id_user', Auth::id())
            ->first();

        // 5. Lempar semua data beserta ID parameter untuk form action di Blade
        return view('students.task-detail', compact('task', 'currentModul', 'subject', 'submission', 'id_mapel', 'id_modul', 'id_tugas', 'guru'));
    }
    public function getVocabulary()
    {
        $response = Http::get('https://jlpt-vocab-api.vercel.app/api/words/all');

        if ($response->successful()) {
            $vocabList = $response->json()['data'] ?? [];

            $memorizedID = VocabProgress::where('id_user', Auth::id())->where('is_memorized', true)->pluck('vocabulary_id')->toArray();

            return view('student.vocabulary', [ //sok ini sesuaikan aja buat nama view bladenya sama kamu 
                'vocabList' => $vocabList,
                'memorizedID' => $memorizedID,
            ]);
        }

        return abort(500, 'Gagal mengambil data dari API');
    }

    public function saveProgress(Request $request)
    {
        $request->validate([
            'vocabulary_id' => 'required'
        ]);

        VocabProgress::updateOrCreate(
            [
                'id_user' => Auth::id(),
                'vocabulary_id' => $request->vocabulary_id,
            ],
            [
                'is_memorized' => true
            ]
        );

        return redirect()->back()->with('success', 'Vocabulary Memorized!');
    }

    // Detail material
    public function showMaterial($id_mapel, $id_modul, $id_materi)
    {
        // 1. Ambil data induk untuk kebutuhan Breadcrumbs & Navigasi Sidebar
        $subject = Mapel::find($id_mapel);
        $currentModul = Modul::find($id_modul);

        // 2. Cari data materi di database (mengembalikan null jika tidak ada, agar ditangani Blade)
        $material = null;
        try {
            $material = BahanAjar::find($id_materi);
        } catch (\Throwable $e) {
            $material = null;
        }

        // Inisialisasi default URL pagination
        $previousMaterialUrl = null;
        $nextMaterialUrl = null;

        // 3. 🌟 LOGIKA UTAMAKAN KUNCI PAGINATION PER MODUL 🌟
        if ($material) {
            // Cari materi SEBELUMNYA yang mutlak berada di dalam id_modul yang sama
            $previousMaterial = DB::table('bahan_ajar')
                ->where('id_modul', $id_modul)
                ->where('id_bahan_ajar', '<', $material->id_bahan_ajar)
                ->orderBy('id_bahan_ajar', 'desc')
                ->first();

            // Cari materi SELANJUTNYA yang mutlak berada di dalam id_modul yang sama
            $nextMaterial = DB::table('bahan_ajar')
                ->where('id_modul', $id_modul)
                ->where('id_bahan_ajar', '>', $material->id_bahan_ajar)
                ->orderBy('id_bahan_ajar', 'asc')
                ->first();

            // Susun rute URL jika record materi pendukungnya ditemukan
            $previousMaterialUrl = $previousMaterial
                ? route('materials.show', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_materi' => $previousMaterial->id_bahan_ajar])
                : null;

            $nextMaterialUrl = $nextMaterial
                ? route('materials.show', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_materi' => $nextMaterial->id_bahan_ajar])
                : null;
        }

        // 4. Kirim data ke View
        return view('students.material-detail', compact(
            'subject',
            'currentModul',
            'material',
            'previousMaterialUrl',
            'nextMaterialUrl'
        ));
    }



    // Mark materi sebagai selesai (update progress)
    public function completeMaterial($id_materi)
    {
        try {
            // 1. Cari data materi berdasarkan Primary Key aslinya
            $material = BahanAjar::find($id_materi);

            if ($material) {
                // 2. Ubah kolom is_complete menjadi 1 (true / selesai)
                $material->is_complete = 1;
                $material->save();
            }
        } catch (\Throwable $e) {
            // Jika database belum siap/error, tetap biarkan halaman melakukan refresh tanpa crash
        }

        // 3. Kembalikan siswa ke halaman materi semula dengan data yang sudah terupdate
        return back();
    }
}
