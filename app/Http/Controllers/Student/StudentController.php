<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

use App\Models\Mapel;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        // Ambil data mapel beserta relasi guru dan rps (untuk hitung module)
        $subjects = Mapel::with(['guru', 'rps'])->get();

        // Ambil data pendaftaran user yang sedang login
        $enrollment = Enrollment::where('id_user', Auth::id())->first(); 

        return view('students.dashboard', compact('subjects', 'enrollment'));
    }

    public function show($id)
    {
        // 1. Cari data mapel berdasarkan ID. Jika tidak ada, otomatis 404.
        // Eager load guru dan rps agar data silabus muncul di page detail.
        $subject = Mapel::with(['guru', 'rps'])->findOrFail($id);
        
        // 2. Ambil data enrollment untuk menampilkan info program di banner merah
        $enrollment = Enrollment::where('id_user', Auth::id())->first();

        // 3. Sambungkan ke file blade yang baru kamu buat
        return view('students.class-detail', compact('subject', 'enrollment'));
    }
}