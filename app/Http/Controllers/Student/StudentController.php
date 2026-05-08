<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subjects = Mapel::with('guru')->get();

        return view('students.dashboard', compact('subjects'));
    }

    public function show($id)
    {
        // Untuk sementara kita tampilkan teks saja

        $subject = Mapel::with('guru')->where('id_mapel', $id)->firstOrFail();

        return "Halaman Modul untuk: " . $id;
    }
}
