<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        // Mengambil data asli dari tabel 'mapel' di database
        // 'with(guru)' digunakan agar data nama guru juga ikut terbawa
        $subjects = \App\Models\Mapel::with('guru')->get();

        // Mengambil data pendaftaran siswa yang sedang login
        $enrollment = Auth::user()->enrollment;

        return view('students.dashboard', compact('subjects', 'enrollment'));

        // Tambahkan 'rps' ke dalam fungsi with()
        $subjects = \App\Models\Mapel::with(['guru', 'rps'])->get();

        $enrollment = auth()->user()->enrollment;

        return view('students.dashboard', compact('subjects', 'enrollment'));
    }
    
    public function show($slug)
    {
        // Untuk sementara kita tampilkan teks saja
        return "Halaman Modul untuk: " . $slug;
    }
}
