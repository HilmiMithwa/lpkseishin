<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modul;
use App\Http\Requests\Teacher\StoreModulRequest;

class ModulController extends Controller
{
    public function store(StoreModulRequest $request)
    {
        Modul::create($request->validated());
        return redirect()->route('teacher.dashboardmodul')->with('success', 'Modul Berhasil ditambahkan!'); //buat routingan dashboard guru ini aku serahin lagi ke kamu zan. Ini sebagai contoh doang
    }

    public function show($id_modul)
    {
        $modul = Modul::with(['mapel.batch', 'mapel.modul', 'bahanAjar'])->findOrFail($id_modul);
        
        $currentModuleId = $modul->id_modul;
        $batchName = $modul->mapel->batch->nama ?? 'Unknown Batch';
        $className = $modul->mapel->nama_mapel ?? 'Unknown Class';
        $moduleTitle = 'Modul ' . $currentModuleId . ': ' . $modul->nama_modul;
        $modules = $modul->mapel->modul; // List of all modules in this class
        $materials = $modul->bahanAjar;
        $tasks = []; // Assuming tasks are managed separately for now
        
        return view('teacher.module-detail', compact('modul', 'currentModuleId', 'batchName', 'className', 'moduleTitle', 'modules', 'materials', 'tasks'));
    }
}
