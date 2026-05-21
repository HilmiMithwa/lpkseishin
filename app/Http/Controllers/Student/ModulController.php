<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;

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

    public function store(Request $request)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:50',
            'kode_modul' => 'required|string|unique:modul,kode_modul',
            'teori' => 'required|integer',
            'praktik' => 'required|integer',
            'module_description' => 'nullable|max:100',
            'id_mapel' => 'required|exists:mapel, id_mapel',
            'id_rps' => 'required|exists:rps, id_rps'
        ]);

        Modul::create($request->all());
        return redirect()->route('teacher.dashboardmodul')->with('success', 'Modul Berhasil ditambahkan!'); //buat routingan dashboard guru ini aku serahin lagi ke kamu zan. Ini sebagai contoh doang
        
    
    }
}
