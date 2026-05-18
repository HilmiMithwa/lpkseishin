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

class StudentController extends Controller
{
    public function index()
    {
        // 1. Gabungkan pengambilan relasi guru dan hitung modul dalam satu query
        // Ini akan mengisi variabel $subject->modul_count secara otomatis
        $subjects = Auth::user()->mapels()
            ->with(['guru'])
            ->withCount('modul')
            ->get();

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

    public function show($id)
    {
        // 1. Cek apakah user yang login benar-benar terdaftar di mapel ini
        $isEnrolled = Auth::user()->mapels()->where('mapel.id_mapel', $id)->exists();

        if (!$isEnrolled) {
            // Jika tidak terdaftar, lempar error 403 (Forbidden)
            abort(403, 'Gak boleh intip-intip! Kamu belum daftar di kelas ini.');
        }

        // 2. Jika lolos pengecekan, baru ambil datanya
        $subject = Mapel::with(['guru', 'rps', 'modul'])->findOrFail($id)
            ->withCount('modul')
            ->findOrFail($id);
        
        $enrollment = Enrollment::where('id_user', Auth::id())->first();

        return view('students.class-detail', compact('subject', 'enrollment'));
    }

    public function showModule($id_modul)
    {
        try {
            // 1. Daftar relasi yang ingin kita panggil jika sudah siap di backend
            $potentialRelations = ['materials', 'tasks'];
            $safeRelations = [];

            // 2. Safety Check: Cek apakah method relasi tersebut sudah ada di model Modul
            $modulModel = new Modul();
            foreach ($potentialRelations as $relation) {
                if (method_exists($modulModel, $relation)) {
                    $safeRelations[] = $relation;
                }
            }

            // 3. Jalankan query hanya dengan relasi yang sudah terbukti ada
            $currentModul = Modul::with($safeRelations)->findOrFail($id_modul);

        } catch (\Exception $e) {
            // 4. Error Handler Fallback: Jika ada error database lain, tetap muat modul secara aman
            $currentModul = Modul::findOrFail($id_modul);
        }
        
        // Ambil data mapel untuk navigasi sidebar
        $subject = Mapel::with('modul')->findOrFail($currentModul->id_mapel);

        // 5. Kirim ke view (Blade kamu sudah aman karena menggunakan operator ?? [])
        return view('students.module-detail', compact('currentModul', 'subject'));
    }
}