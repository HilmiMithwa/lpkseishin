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
use App\Models\Vocabulary;
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
        $activeBatch = DB::table('student_list_batch')
            ->join('batch', 'student_list_batch.id_batch', '=', 'batch.id_batch')
            ->where('student_list_batch.user_id', $user->id)
            ->where('student_list_batch.status', 'Active')
            ->select('batch.*', 'student_list_batch.status as batch_status')
            ->first();

        // 3. Fitur Yumegatari: Ambil satu kata secara acak dari database
        // Pastikan temanmu sudah membuat tabel 'daily_words'
        $dailyWord = Schema::hasTable('daily_words')
            ? DB::table('daily_words')->inRandomOrder()->first()
            : null;

        // 4. Ringkasan (Summary Stat)
         // Ambil semua id_mapel yang diikuti siswa ini
        $mapelIds = $subjects->pluck('id_mapel');

        $totalSubjects = $subjects->count();
        $completedSubjects = $subjects->filter(function ($subject) use ($user) {
            $totalModul = $subject->modul_count;
            if ($totalModul === 0) return false;

            $completedModul = $this->getCompletedModulesCount($subject->id_mapel, $user->id);

            return $completedModul >= $totalModul;
        })->count();
 
        // Ambil semua id_tugas dari mapel-mapel tersebut
        $tugasIds = DB::table('tugas')
            ->join('rps', 'tugas.id_rps', '=', 'rps.id_rps')
            ->join('modul', 'rps.id_mapel', '=', 'modul.id_mapel')
            ->whereIn('modul.id_mapel', $mapelIds)
            ->pluck('tugas.id_tugas');
 
        // Tugas yang sudah selesai dinilai milik siswa ini
        $completedTasksCount = DB::table('pengiriman_tugas')
            ->where('id_user', $user->id)
            ->where('status', 'dinilai')
            ->whereIn('id_tugas', $tugasIds)
            ->count();
 
        // Rata-rata nilai dari tugas yang sudah dinilai
        $averageScore = DB::table('pengiriman_tugas')
            ->where('id_user', $user->id)
            ->where('status', 'dinilai')
            ->whereIn('id_tugas', $tugasIds)
            ->whereNotNull('nilai')
            ->avg('nilai');
        $averageScore = $averageScore ? round($averageScore, 1) : 0;
 
        // Jumlah deadline tugas yang akan datang (dalam 7 hari ke depan)
        // Gunakan kolom created_at tugas sebagai proxy deadline jika tidak ada kolom deadline
        $upcomingDeadlinesCount = DB::table('tugas')
            ->join('rps', 'tugas.id_rps', '=', 'rps.id_rps')
            ->join('modul', 'rps.id_mapel', '=', 'modul.id_mapel')
            ->whereIn('modul.id_mapel', $mapelIds)
            ->whereNotIn('tugas.id_tugas', function ($q) use ($user) {
                $q->select('id_tugas')
                  ->from('pengiriman_tugas')
                  ->where('id_user', $user->id);
            })
            ->count();
 
        // Jumlah kosakata yang sudah dihafal
        $vocabularyCount = VocabProgress::where('id_user', $user->id)
            ->where('is_memorized', DB::raw('true'))
            ->count();
 
        // Estimasi jam belajar: hitung bahan ajar yang sudah selesai
        // Asumsi rata-rata 15 menit per bahan ajar
        $completedMaterialsCount = DB::table('bahan_ajar_progress')
            ->where('id_user', $user->id)
            ->where('is_complete', DB::raw('true'))
            ->count();
        $learningHours = round(($completedMaterialsCount * 15) / 60, 1);

        // 5. Kirim semua variabel ke view dashboard
        return view('students.dashboard', compact(
            'subjects',
            'enrollment',
            'dailyWord',
            'completedTasksCount',
            'averageScore',
            'upcomingDeadlinesCount',
            'vocabularyCount',
            'learningHours',
            'activeBatch',
            'totalSubjects',
            'completedSubjects'
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

    public function saveProgress(Request $request)
    {
        $request->validate([
            'id_vocabulary' => 'required'
        ]);

        $user = Auth::user();
        
        $current = DB::table('vocab_progress')
            ->where('id_user', $user->id)
            ->where('id_vocabulary', $request->id_vocabulary)
            ->first();

        if ($current) {
            DB::table('vocab_progress')
                ->where('id', $current->id)
                ->update(['is_memorized' => DB::raw('true'), 'updated_at' => now()]);
        } else {
            DB::table('vocab_progress')->insert([
                'id_user'       => $user->id,
                'id_vocabulary' => $request->id_vocabulary,
                'is_memorized'  => DB::raw('true'),
                'is_favorite'   => DB::raw('false'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

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

    // Fungsi page Terdaftar (Enrolled)
    public function enrolled()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Fetch subjects the user is enrolled in
        $subjects = $user->mapels()->withCount('modul')->get();

        // Calculate progress status for each enrolled subject
        foreach ($subjects as $subject) {
            $totalModul = $subject->modul_count;
            if ($totalModul === 0) {
                $subject->status = 'Selesai';
            } else {
                $completedModul = $this->getCompletedModulesCount($subject->id_mapel, $user->id);
                $subject->status = ($completedModul >= $totalModul) ? 'Selesai' : 'Proses';
            }

            // Dynamically assign icon
            if (stripos($subject->nama_mapel, 'test') !== false || stripos($subject->nama_mapel, 'tryout') !== false) {
                $subject->icon = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>';
            } else {
                $subject->icon = 'あa';
            }
            $subject->icon_color = 'text-[#d62828]';
        }

        $enrollment = Transaction::where('id_user', Auth::id())->first();

        return view('students.enrolled', compact('subjects', 'enrollment'));
    }

    /**
     * Calculate how many modules in a subject are completed by the user.
     */
    private function getCompletedModulesCount($id_mapel, $userId)
    {
        $modulIds = DB::table('modul')
            ->where('id_mapel', $id_mapel)
            ->pluck('id_modul')
            ->toArray();

        $completedModulesCount = 0;

        foreach ($modulIds as $id_modul) {
            // Count total materials in the module
            $totalMaterial = DB::table('bahan_ajar')
                ->where('id_modul', $id_modul)
                ->count();

            // Count completed materials in the module
            $completedMaterial = DB::table('bahan_ajar')
                ->join('bahan_ajar_progress', 'bahan_ajar.id_bahan_ajar', '=', 'bahan_ajar_progress.id_bahan_ajar')
                ->where('bahan_ajar.id_modul', $id_modul)
                ->where('bahan_ajar_progress.id_user', $userId)
                ->where('bahan_ajar_progress.is_complete', DB::raw('true'))
                ->count();

            // Count total tasks in the module
            $totalTask = DB::table('tugas')
                ->where('id_modul', $id_modul)
                ->count();

            // Count submitted/completed tasks in the module
            $completedTask = DB::table('tugas')
                ->join('pengiriman_tugas', 'tugas.id_tugas', '=', 'pengiriman_tugas.id_tugas')
                ->where('tugas.id_modul', $id_modul)
                ->where('pengiriman_tugas.id_user', $userId)
                ->whereIn('pengiriman_tugas.status', ['dikirim', 'dinilai'])
                ->count();

            $materialClear = ($totalMaterial === $completedMaterial);
            $taskClear = ($totalTask === $completedTask);

            if ($totalMaterial === 0 && $totalTask === 0) {
                $completedModulesCount++;
            } elseif ($materialClear && $taskClear) {
                $completedModulesCount++;
            }
        }

        return $completedModulesCount;
    }
// ======================================

    public function vocabularyMastery()
    {
        $user = Auth::user();
 
        $dailyWord = Schema::hasTable('daily_words')
            ? DB::table('daily_words')->inRandomOrder()->first()
            : null;
 
        $statMastered  = VocabProgress::where('id_user', $user->id)->where('is_memorized', DB::raw('true'))->count();
        $statLearning  = VocabProgress::where('id_user', $user->id)->count();
        $statFavourite = VocabProgress::where('id_user', $user->id)->where('is_favorite', DB::raw('true'))->count();
 
        $totalVocab         = Vocabulary::count();
        $masteredPercentage = $totalVocab > 0 ? round(($statMastered / $totalVocab) * 100) : 0;
 
        $levels = Vocabulary::select('level')->distinct()->orderBy('level')->pluck('level');
 
        $flashcardLevels = $levels->map(function ($level) use ($user) {
            $vocabIds   = Vocabulary::where('level', $level)->pluck('id_vocabulary');
            $total      = $vocabIds->count();
            $mastered   = VocabProgress::where('id_user', $user->id)
                            ->where('is_memorized', DB::raw('true'))
                            ->whereIn('id_vocabulary', $vocabIds)
                            ->count();
            $lastUpdate = VocabProgress::where('id_user', $user->id)
                            ->whereIn('id_vocabulary', $vocabIds)
                            ->latest('updated_at')
                            ->value('updated_at');
 
            return (object)[
                'level'   => $level,
                'total'   => $total,
                'mastered'=> $mastered,
                'status'  => ($mastered >= $total && $total > 0) ? 'Selesai' : 'Proses',
                'updated' => $lastUpdate ? \Carbon\Carbon::parse($lastUpdate)->diffForHumans() : '-',
            ];
        });
 
        return view('students.vocabulary-mastery', compact(
            'dailyWord', 'statMastered', 'statLearning', 'statFavourite',
            'masteredPercentage', 'flashcardLevels'
        ));
    }

    public function vocabularyLevel($id)
    {
        $user = Auth::user();
 
        $vocabList = Vocabulary::where('level', $id)
            ->orderBy('id_vocabulary')
            ->get();
 
        $progressMap = VocabProgress::where('id_user', $user->id)
            ->whereIn('id_vocabulary', $vocabList->pluck('id_vocabulary'))
            ->get()
            ->keyBy('id_vocabulary');
 
        $totalWords = $vocabList->count();
 
        $flashcards = $vocabList->map(function ($vocab, $index) use ($progressMap, $totalWords) {
            $progress = $progressMap->get($vocab->id_vocabulary);
 
            return [
                'id_vocabulary' => $vocab->id_vocabulary,
                'kanji'         => $vocab->kanji,
                'furigana'      => $vocab->furigana ?? '',
                'romaji'        => $vocab->romaji,
                'en'            => $vocab->meaning_en,
                'id'            => $vocab->meaning_id,
                'definition'    => $vocab->definition_id,
                'usage'         => $vocab->contextual_usage,
                'progress'      => 'Kartu ' . ($index + 1) . ' dari ' . $totalWords,
                'status'        => ($progress && $progress->is_memorized) ? 'Dikuasai' : 'Belum Dikuasai',
                'is_fav'        => $progress ? (bool) $progress->is_favorite : false,
            ];
        })->values();
 
        return view('students.vocabulary-level', [
            'level_id'   => $id,
            'flashcards' => $flashcards,
            'totalWords' => $totalWords,
        ]);
    }

     public function toggleMastered($id_vocabulary)
    {
        $user = Auth::user();
        $current = DB::table('vocab_progress')
            ->where('id_user', $user->id)
            ->where('id_vocabulary', $id_vocabulary)
            ->first();

        if ($current) {
            $newValue = filter_var($current->is_memorized, FILTER_VALIDATE_BOOLEAN) ? 'false' : 'true';
            DB::table('vocab_progress')
                ->where('id', $current->id)
                ->update(['is_memorized' => DB::raw($newValue), 'updated_at' => now()]);
        } else {
            $newValue = 'true';
            DB::table('vocab_progress')->insert([
                'id_user'       => $user->id,
                'id_vocabulary' => $id_vocabulary,
                'is_memorized'  => DB::raw($newValue),
                'is_favorite'   => DB::raw('false'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
        
        $is_memorized = $newValue === 'true';
 
        return response()->json([
            'is_memorized' => $is_memorized,
            'status'       => $is_memorized ? 'Dikuasai' : 'Belum Dikuasai',
        ]);
    }

    public function toggleFavorite($id_vocabulary)
    {
        $user = Auth::user();
        $current = DB::table('vocab_progress')
            ->where('id_user', $user->id)
            ->where('id_vocabulary', $id_vocabulary)
            ->first();

        if ($current) {
            $newValue = filter_var($current->is_favorite, FILTER_VALIDATE_BOOLEAN) ? 'false' : 'true';
            DB::table('vocab_progress')
                ->where('id', $current->id)
                ->update(['is_favorite' => DB::raw($newValue), 'updated_at' => now()]);
        } else {
            $newValue = 'true';
            DB::table('vocab_progress')->insert([
                'id_user'       => $user->id,
                'id_vocabulary' => $id_vocabulary,
                'is_memorized'  => DB::raw('false'),
                'is_favorite'   => DB::raw($newValue),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
        
        $is_favorite = $newValue === 'true';
 
        return response()->json([
            'is_favorite' => $is_favorite,
        ]);
    }
    
}
