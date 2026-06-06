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
        $modul = Modul::with(['mapel.batch', 'mapel.modul', 'bahanAjar'])->findOrFail($id_modul);
        
        $currentModuleId = $modul->id_modul;
        $batchName = $modul->mapel->batch->nama_batch ?? 'Unknown Batch';
        $className = $modul->mapel->nama_mapel ?? 'Unknown Class';
        $moduleTitle = 'Modul ' . $currentModuleId . ': ' . $modul->nama_modul;
        
        // Fetch all modules of this mapel/class for the sidebar list
        $modules = $modul->mapel->modul; 

        // Fetch materials and tasks
        $materials = $modul->bahanAjar;
        $tasks = Tugas::where('id_modul', $id_modul)->get();

        return view('teacher.module-detail', compact('modul', 'currentModuleId', 'batchName', 'className', 'moduleTitle', 'modules', 'materials', 'tasks'));
    }

    public function store(StoreModulRequest $request)
    {
        Modul::create($request->validated());
        return redirect()->route('teacher.dashboardmodul')->with('success', 'Modul Berhasil ditambahkan!'); //buat routingan dashboard guru ini aku serahin lagi ke kamu zan. Ini sebagai contoh doang
    }
}
