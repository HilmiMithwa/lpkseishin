<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modul;
use App\Models\BahanAjar;
use App\Models\Tugas;
use App\Http\Requests\Teacher\StoreModulRequest;

class ModulController extends Controller
{
    public function showModule($id_modul)
    {
        // Fetch module with its associated mapel
        $module = Modul::with(['mapel', 'mapel.batch'])->findOrFail($id_modul);

        // Fetch all modules of this mapel/class for the sidebar list
        $modules = Modul::where('id_mapel', $module->id_mapel)->get();

        // Fetch materials and tasks
        $materials = BahanAjar::where('id_modul', $id_modul)->get();
        $tasks = Tugas::where('id_modul', $id_modul)->get();

        return view('teacher.module-detail', compact('module', 'modules', 'materials', 'tasks'));
    }

    public function store(StoreModulRequest $request)
    {
        Modul::create($request->validated());
        return redirect()->route('teacher.dashboardmodul')->with('success', 'Modul Berhasil ditambahkan!'); //buat routingan dashboard guru ini aku serahin lagi ke kamu zan. Ini sebagai contoh doang
    }


}
