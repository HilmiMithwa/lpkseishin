<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;

class StudentController extends Controller
{
    public function index()
    {
        
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
