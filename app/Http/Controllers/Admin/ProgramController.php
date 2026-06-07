<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = \App\Models\Program::with('batches')->orderBy('id_program', 'asc')->get();
        $allBatches = \App\Models\Batch::with('program')->get();
        return view('admin.programs.index', compact('programs', 'allBatches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'theme_color' => 'required|string|in:rose,blue,emerald,indigo,slate,amber,cyan',
        ]);

        \App\Models\Program::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'theme_color' => $request->theme_color,
            'is_active' => 'true',
        ]);

        return redirect()->route('admin.programs')->with('success', 'Program berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $program = \App\Models\Program::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'theme_color' => 'required|string|in:rose,blue,emerald,indigo,slate,amber,cyan',
            'batches' => 'nullable|array',
            'batches.*' => 'exists:batch,id_batch',
        ]);

        $program->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'theme_color' => $request->theme_color,
        ]);

        // Sync batches
        $newBatches = $request->batches ?? [];
        
        // Remove from batches that are no longer selected
        \App\Models\Batch::where('id_program', $program->id_program)
            ->whereNotIn('id_batch', $newBatches)
            ->update(['id_program' => null]);
            
        // Add to selected batches (automatically moves them from other programs)
        if (count($newBatches) > 0) {
            \App\Models\Batch::whereIn('id_batch', $newBatches)
                ->update(['id_program' => $program->id_program]);
        }

        return redirect()->route('admin.programs')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $program = \App\Models\Program::findOrFail($id);
        
        // Toggle status explicitly with strings to bypass PDO integer casting issues on Postgres
        $currentStatus = filter_var($program->is_active, FILTER_VALIDATE_BOOLEAN);
        $program->is_active = $currentStatus ? 'false' : 'true';
        $program->save();

        $statusStr = $program->is_active === 'true' ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.programs')->with('success', 'Program berhasil ' . $statusStr . '.');
    }
}
