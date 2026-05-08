<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        if ($user instanceof \App\Models\User) {
            $subjects = $user->mapels()->with('guru')->get();
        } else {
            $subjects = collect();
        }

        return view('students.dashboard', compact('subjects'));
    }

    public function show($id)
    {
        // Untuk sementara kita tampilkan teks saja

        $subject = Mapel::with('guru')->where('id_mapel', $id)->firstOrFail();

        return "Halaman Modul untuk: " . $id;
    }
}
