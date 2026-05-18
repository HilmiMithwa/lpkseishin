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

    public function showModule($id_mapel, $id_modul)
    {
        // 1. Ambil data modul dasarnya berdasarkan ID modul yang benar
        $currentModul = Modul::findOrFail($id_modul);

        // 2. VALIDASI SILANG: Pastikan modul ini memang bagian dari mata pelajaran di URL
        if ($currentModul->id_mapel != $id_mapel) {
            abort(404, 'Modul tidak ditemukan di dalam mata pelajaran ini.');
        }

        // 3. BARIKADE KEAMANAN (IDOR): Cek kontrak belajar siswa pada kelas ini
        /** @var User $user */
        $user = Auth::user();
        $isEnrolled = $user->mapels()->where('mapel.id_mapel', $id_mapel)->exists();

        if (!$isEnrolled) {
            abort(403, 'NO ACCESS! Kamu belum terdaftar di kelas ini.');
        }

        try {
            // Daftar relasi yang ingin kita panggil jika sudah siap di backend
            $potentialRelations = ['materials', 'tasks'];
            $safeRelations = [];

            // Safety Check: Cek apakah method relasi tersebut sudah ada di model Modul
            $modulModel = new Modul();
            foreach ($potentialRelations as $relation) {
                if (method_exists($modulModel, $relation)) {
                    $safeRelations[] = $relation;
                }
            }

            // Jalankan query hanya dengan relasi yang sudah terbukti ada
            $currentModul = Modul::with($safeRelations)->findOrFail($id_modul);
        } catch (\Exception $e) {
            // Error Handler Fallback: Jika ada error database lain, tetap muat modul secara aman
            $currentModul = Modul::findOrFail($id_modul);
        }

        // Ambil data mapel menggunakan $id_mapel dari URL untuk navigasi sidebar kanan
        $subject = Mapel::with('modul')->findOrFail($id_mapel);

        // ====================================================================
        // BARKODE MOCK DATA (DUMMY) UNTUK TESTING LAYOUT FIGMA
        // ====================================================================

        // 1. Memaksa isi Teaching Materials muncul (2 Data: 1 Sukses, 1 Progress)
        $currentModul->materials = collect([
            (object)[
                'title' => 'Intro to N4 and Kanji',
                'type' => 'Theory',
                'is_completed' => true,
                'link_url' => '#'
            ],
            (object)[
                'title' => 'Intro to N4 and Kanji',
                'type' => 'Practice',
                'is_completed' => false,
                'link_url' => '#'
            ]
        ]);

        // 2. Memaksa isi Evaluation muncul
        $currentModul->evaluation = (object)[
            'id' => 1,
            'title' => 'N4 and Kanji Evaluation',
            'type' => 'Test',
            'date' => '21 May 2026',
            'duration' => 60
        ];

        // 3. Memaksa isi Task muncul (2 baris tugas)
        $currentModul->tasks = collect([
            (object)[
                'id' => 1,
                'title' => 'N4 Exercise',
                'due_date' => '8 Mei 2026, 23:59',
                'status' => 'Completed'
            ],
            (object)[
                'id' => 2,
                'title' => 'Kanji Writing Exercise',
                'due_date' => '9 Mei 2026, 23:59',
                'status' => 'Incompleted'
            ]
        ]);

        // ====================================================================

        return view('students.module-detail', compact('currentModul', 'subject'));
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
                $material = \App\Models\BahanAjar::find($id_materi);
        } catch (\Throwable $e) {
            // Jika ada error database apapun, kunci variabel menjadi null agar placeholder aktif
            $material = null;
        }

        // 3. Logika Otomatis URL Tombol Pembuka Materi Sebelumnya & Selanjutnya
        // (Asumsi testing sementara batas maksimal ada 3 materi)
        $previousMaterialUrl = ($id_materi > 1) 
            ? route('materials.show', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_materi' => $id_materi - 1]) 
            : null;

        $nextMaterialUrl = ($id_materi < 3) 
            ? route('materials.show', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_materi' => $id_materi + 1]) 
            : null;

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
        // Sementara kembalikan ke halaman semula, logic database diserahkan ke backend
        return back();
    }

}
