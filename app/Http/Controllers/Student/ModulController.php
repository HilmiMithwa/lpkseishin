<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;
use App\Http\Requests\Student\StoreModulRequest;

//Nunggu dashboard guru keluar
class ModulController extends Controller
{

    public function index() 
    {
        //ini buat ditunjukin ke siswanya 

        $modul = Modul::with(['mapel', 'rps'])->get();

        return view('students.module-detail', compact('modul'));
    }

    //beberapa validasi untuk dashbaord guru

    public function store(StoreModulRequest $request)
    {
        Modul::create($request->validated());
        return redirect()->route('teacher.dashboardmodul')->with('success', 'Modul Berhasil ditambahkan!'); //buat routingan dashboard guru ini aku serahin lagi ke kamu zan. Ini sebagai contoh doang
    }
}
