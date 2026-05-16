<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk fitur random
use Illuminate\Support\Facades\Schema;

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
}