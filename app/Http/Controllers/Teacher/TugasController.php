<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Batch;
use App\Models\Mapel;
use App\Models\Modul;
use App\Http\Requests\Teacher\CreateAssignmentRequest;

class TugasController extends Controller
{
    public function show(Request $request) {
        $selectedBatchId = $request->input('batch_id');
        $selectedMapelId = $request->input('mapel_id');

        $batches = Batch::all();

        $query = Tugas::with(['modul.mapel.batch', 'submissions']);

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

        $allAssignments = $query->get();

        $now = \Carbon\Carbon::now();

        $belumDiperiksa = $allAssignments->filter(function($task) {
            return $task->submissions->where('status', 'dikirim')->count() > 0;
        });

        $aktifBerjalan = $allAssignments->filter(function($task) use ($now) {
            return empty($task->waktu_pengumpulan) || \Carbon\Carbon::parse($task->waktu_pengumpulan)->greaterThanOrEqualTo($now);
        })->diff($belumDiperiksa);

        $selesai = $allAssignments->filter(function($task) use ($now) {
            return !empty($task->waktu_pengumpulan) && \Carbon\Carbon::parse($task->waktu_pengumpulan)->lessThan($now);
        })->diff($belumDiperiksa);

        $classes = Mapel::all();
        $allModules = Modul::all();

        return view('teacher.assignments', compact('belumDiperiksa', 'aktifBerjalan', 'selesai', 'batches', 'selectedBatchId', 'selectedMapelId', 'classes', 'allModules'));
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

    public function gradePage($id) {
        $tugas = Tugas::with(['submissions.user', 'modul.mapel.batch'])->findOrFail($id);
        
        // Pass submissions with mapped properties so the Alpine view can use it directly
        $submissions = $tugas->submissions->map(function($sub) {
            return [
                'id' => $sub->id_pengiriman_tugas,
                'name' => $sub->user->name,
                'status' => $sub->status === 'dikirim' ? 'belum_dinilai' : ($sub->status === 'dinilai' ? 'selesai' : 'terlambat'),
                'submitted_at' => $sub->submitted_at ? $sub->submitted_at->translatedFormat('d M Y, H:i') : '-',
                'avatar' => strtoupper(substr($sub->user->name, 0, 2)),
                'attachment' => $sub->file_path ? [
                    'type' => 'document', 
                    'url' => asset('storage/' . $sub->file_path),
                    'name' => basename($sub->file_path),
                    'size' => 'File' // We can improve this later
                ] : null,
                'score' => $sub->nilai,
                'feedback' => $sub->feedback,
                'notes' => $sub->text_content ?? ''
            ];
        })->values();

        return view('teacher.grade-submission', compact('tugas', 'submissions'));
    }

    public function gradeAssignment(Request $request, $id) {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        $submission = \App\Models\Pengiriman_Tugas::findOrFail($id);
        $submission->nilai = $request->nilai;
        $submission->feedback = $request->feedback;
        $submission->status = 'dinilai';
        $submission->save();

        return back()->with('success', 'Nilai berhasil disimpan!');
    }
}
