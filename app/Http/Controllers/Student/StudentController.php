<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Transaction;
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
        $enrollment = Transaction::where('id_user', Auth::id())->first();

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

        $enrollment = Transaction::where('id_user', Auth::id())->first();

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

// ======================================
// ======================================
// // DUMMY EVALUATION

    public function showEvaluation($id_mapel, $id_modul, $id)
    {
        // 1. Ambil data mapel asli dari database berdasarkan id_mapel di URL
        $subject = Mapel::findOrFail($id_mapel);
        
        // 2. Ambil data modul asli dari database berdasarkan id_modul di URL (Bukan dummy lagi!)
        $currentModul = Modul::findOrFail($id_modul);

        // 3. Buat Dummy Data Informasi Evaluasi (Sambil menunggu tabel evaluasi asli selesai)
        $evaluation = (object)[
            'id' => $id,
            'title' => 'Final Competency Test & Mock Interview',
            'type' => 'Multiple Choice',
            'duration' => 120, 
            'total_questions' => 50,
            'language' => 'Japanese N4',
            'time_left_seconds' => 15 
        ];

        // 4. GENERATOR 50 SOAL DUMMY (AUTO-INCREMENT)
        $questions = [];
        for ($i = 1; $i <= $evaluation->total_questions; $i++) {
            $questions[] = [
                'number' => $i,
                'text' => 'Ini adalah simulasi teks soal untuk <b>Pertanyaan Nomor ' . $i . '</b> pada ' . $currentModul->nama_modul . '. Silakan pilih satu jawaban yang menurut Anda paling tepat untuk melanjutkan.',
                'options' => [
                    ['id' => 'a', 'value' => 'Pilihan A soal ' . $i],
                    ['id' => 'b', 'value' => 'Pilihan B soal ' . $i],
                    ['id' => 'c', 'value' => 'Pilihan C soal ' . $i],
                    ['id' => 'd', 'value' => 'Pilihan D soal ' . $i]
                ]
            ];
        }

        return view('students.evaluation-detail', compact('subject', 'currentModul', 'evaluation', 'questions'));
    }

    // Fungsi page MY TASKS
    public function myTasks()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Dapatkan daftar ID mata pelajaran yang dikontrak oleh siswa aktif
        $enrolledMapelIds = $user->mapels()->pluck('mapel.id_mapel')->toArray();

        // 2. Tarik semua tugas dari hirarki mapel -> modul -> tugas
        $tasks = DB::table('tugas')
            ->join('modul', 'tugas.id_modul', '=', 'modul.id_modul')
            ->join('mapel', 'modul.id_mapel', '=', 'mapel.id_mapel')
            ->leftJoin('pengiriman_tugas', function ($join) use ($user) {
                $join->on('tugas.id_tugas', '=', 'pengiriman_tugas.id_tugas')
                     ->where('pengiriman_tugas.id_user', '=', $user->id);
            })
            ->whereIn('mapel.id_mapel', $enrolledMapelIds)
            ->select(
                'tugas.*',
                'modul.id_modul',
                'mapel.id_mapel',
                'pengiriman_tugas.id_pengiriman_tugas as id_pengiriman', // 
                'pengiriman_tugas.status as submission_status'
            )
            ->orderBy('tugas.waktu_pengumpulan', 'asc')
            ->get();

        return view('students.my-tasks', compact('tasks'));
    }
// ======================================

    
    
}
