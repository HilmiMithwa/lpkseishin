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
}
