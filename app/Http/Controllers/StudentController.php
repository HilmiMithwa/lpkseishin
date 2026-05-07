<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Data ini nantinya diambil dari Database (Eloquent)
        // Sekarang kita pakai array object agar sesuai dengan Blade yang tadi
        $subjects = [
            (object)[
                'code' => 'SCB-N5-01',
                'title' => 'Pengenalan Huruf Jepang (Hiragana & Katakana)',
                'sensei' => 'Ahmad Sensei',
                'jp' => '30 JP',
                'status' => 'Aktif'
            ],
            (object)[
                'code' => 'SCB-N5-02',
                'title' => 'Kosakata (Kotoba)',
                'sensei' => 'Siti Sensei',
                'jp' => '30 JP',
                'status' => 'Aktif'
            ],
            // Tambahkan mapel lainnya di sini...
        ];

        return view('students.dashboard', compact('subjects'));
    }

    public function show($slug)
{
    // Untuk sementara kita tampilkan teks saja
    return "Halaman Modul untuk: " . $slug;
}
}