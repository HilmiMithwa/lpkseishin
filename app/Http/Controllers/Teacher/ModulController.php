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
        $mapelId = $modul->id_mapel;
        $batchId = $modul->mapel->id_batch ?? null;
        $batchName = $modul->mapel->batch->nama ?? 'Unknown Batch';
        $className = $modul->mapel->nama_mapel ?? 'Unknown Class';
        
        // Calculate the module's sequence index within its mapel
        $moduleIndex = Modul::where('id_mapel', $mapelId)->orderBy('id_modul', 'asc')->pluck('id_modul')->search($currentModuleId) + 1;
        $moduleTitle = 'Modul ' . $moduleIndex . ': ' . $modul->nama_modul;
        
        // Fetch all modules of this mapel/class for the sidebar list
        $modules = $modul->mapel->modul; 

        // Fetch materials, tasks, and evaluations
        $materials = $modul->bahanAjar;
        $tasks = Tugas::where('id_modul', $id_modul)->get();
        $evaluations = $modul->evaluasi;

        return view('teacher.module-detail', compact('modul', 'currentModuleId', 'mapelId', 'batchId', 'batchName', 'className', 'moduleTitle', 'moduleIndex', 'modules', 'materials', 'tasks', 'evaluations'));
    }

    public function store(StoreModulRequest $request)
    {
        Modul::create($request->validated());
        return redirect()->back()->with('success', 'Modul berhasil ditambahkan!');
    }

    public function update(Request $request, $id_modul)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:255',
            'teori' => 'nullable|integer|min:0',
            'praktik' => 'nullable|integer|min:0',
            'icon_type' => 'required|integer',
            'module_description' => 'nullable|string',
        ]);

        $modul = Modul::findOrFail($id_modul);
        
        $modul->update([
            'nama_modul' => $request->nama_modul,
            'jp_teori' => $request->teori ?? 0,
            'jp_praktik' => $request->praktik ?? 0,
            'icon_type' => $request->icon_type,
            'module_description' => $request->module_description,
        ]);

        return redirect()->back()->with('success', 'Modul berhasil diperbarui!');
    }
}
