<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Batch;
use App\Models\Mapel;
use App\Http\Requests\Teacher\CreateAssignmentRequest;

class TugasController extends Controller
{
    public function show(Request $request) {
        $selectedBatchId = $request->input('batch_id');
        $selectedMapelId = $request->input('mapel_id');

        $batches = Batch::all();

        $query = Tugas::with(['modul.mapel.batch']);

        if ($selectedBatchId) {
            $query->whereHas('modul.mapel.batch', function ($q) use ($selectedBatchId) {
                $q->where('id_batch', $selectedBatchId);
            });
        }

        if ($selectedMapelId) {
            $query->whereHas('modul.mapel', function ($q) use ($selectedMapelId) {
                $q->where('id_mapel', $selectedMapelId);
            });
        }

        $assignments = $query->get();

        $classes = Mapel::all();
        $allModules = \App\Models\Modul::all();

        return view('teacher.assignments', compact('assignments', 'batches', 'selectedBatchId', 'selectedMapelId', 'classes', 'allModules'));
    }

    public function createAssignment(CreateAssignmentRequest $request) {
        $data = $request->validated();

        $modul = \App\Models\Modul::findOrFail($data['id_modul']);
        $data['id_rps'] = $modul->id_rps;
        $data['status_tugas'] = 'Aktif';
        $data['deskripsi_tugas'] = $data['deskripsi_tugas'] ?? '';

        if ($request->hasFile('file_path_tugas')) {
            $file = $request->file('file_path_tugas');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/assignments', $filename);
            $data['file_path_tugas'] = 'assignments/' . $filename;
        }

        Tugas::create($data);

        return redirect()->route('teacher.assignments')->with('success', 'Tugas berhasil dibuat!');
    }
}
