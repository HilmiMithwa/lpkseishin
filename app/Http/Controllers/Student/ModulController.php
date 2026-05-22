<?php


namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;
use Illuminate\Support\Facades\Auth;


//Nunggu dashboard guru keluar
class ModulController extends Controller
{

    public function index() 
    {
        //ini buat ditunjukin ke siswanya 

        $modul = Modul::with(['mapel', 'rps'])->get();

        return view('students.module-detail', compact('modul'));
    }

    public function showModule($id_mapel, $id_modul)
    {
        $modul = Modul::findOrFail($id_modul);

        if ($modul->id_mapel != $id_mapel) {
            abort(404, 'Modul tidak ditemukan di dalam mata pelajaran ini.');
        }

        /** @var User $user */
        $user = Auth::user();
        $isEnrolled = $user->mapels()->where('mapel.id_mapel', $id_mapel)->exists();

        if (!$isEnrolled) {
            abort(403, 'NO ACCESS! Kamu belum terdaftar di kelas ini.');
        };

        $subject = Mapel::with('modul')->findOrFail($id_mapel);

        return view('students.module-detail', compact('modul', 'subject'));


    }

    

    
}
