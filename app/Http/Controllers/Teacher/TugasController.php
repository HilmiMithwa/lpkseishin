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

    public function updateAssignment(Request $request, $id) {
        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi_tugas' => 'nullable|string',
            'waktu_pengumpulan' => 'nullable|date',
            'file_path_tugas' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:10240',
            'id_modul' => 'required|exists:modul,id_modul'
        ]);

        $tugas = Tugas::findOrFail($id);
        
        $modul = \App\Models\Modul::findOrFail($request->id_modul);
        $tugas->id_modul = $request->id_modul;
        $tugas->id_rps = $modul->id_rps;
        $tugas->judul_tugas = $request->judul_tugas;
        $tugas->deskripsi_tugas = $request->deskripsi_tugas ?? '';
        $tugas->waktu_pengumpulan = $request->waktu_pengumpulan;

        if ($request->hasFile('file_path_tugas')) {
            if ($tugas->file_path_tugas && \Storage::disk('public')->exists($tugas->file_path_tugas)) {
                \Storage::disk('public')->delete($tugas->file_path_tugas);
            }
            $file = $request->file('file_path_tugas');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/assignments', $filename);
            $tugas->file_path_tugas = 'assignments/' . $filename;
        }

        $tugas->save();

        return redirect()->route('teacher.assignments')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroyAssignment($id) {
        $tugas = Tugas::findOrFail($id);
        
        if ($tugas->file_path_tugas && \Storage::disk('public')->exists($tugas->file_path_tugas)) {
            \Storage::disk('public')->delete($tugas->file_path_tugas);
        }
        
        $tugas->delete();

        return redirect()->route('teacher.assignments')->with('success', 'Tugas berhasil dihapus!');
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

    public function create($id_modul)
    {
        $modul = Modul::with('mapel.batch')->findOrFail($id_modul);
        $currentModuleId = $modul->id_modul;
        $mapelId = $modul->id_mapel;
        $batchId = $modul->mapel->id_batch ?? null;
        $batchName = $modul->mapel->batch->nama ?? 'Unknown Batch';
        $className = $modul->mapel->nama_mapel ?? 'Unknown Class';

        $moduleIndex = Modul::where('id_mapel', $mapelId)->orderBy('id_modul', 'asc')->pluck('id_modul')->search($currentModuleId) + 1;

        return view('teacher.task-create', compact('modul', 'currentModuleId', 'mapelId', 'batchId', 'moduleIndex', 'batchName', 'className'));
    }

    public function store(Request $request, $id_modul)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'deadline' => 'nullable|date',
            'resource_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:10240'
        ]);

        $modul = Modul::findOrFail($id_modul);

        $tugas = new Tugas();
        $tugas->id_modul = $id_modul;
        $tugas->id_rps = $modul->id_rps;
        $tugas->judul_tugas = $request->title;
        $tugas->deskripsi_tugas = $request->content;
        $tugas->waktu_pengumpulan = $request->deadline;
        $tugas->status_tugas = 'Aktif';

        if ($request->hasFile('resource_file')) {
            $file = $request->file('resource_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/assignments', $filename);
            $tugas->file_path_tugas = 'assignments/' . $filename;
        }

        $tugas->save();

        return redirect()->route('teacher.modules.show', $id_modul)->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function showTask($id_modul, $id_tugas)
    {
        $modul = Modul::with('mapel.batch')->findOrFail($id_modul);
        $task = Tugas::with(['submissions.user'])->findOrFail($id_tugas);

        $submissions = $task->submissions->map(function($sub, $index) {
            return (object)[
                'no' => $index + 1,
                'id_siswa' => $sub->id_pengiriman_tugas, // as placeholder or use real student id if available
                'name' => $sub->user->name,
                'status' => $sub->status === 'dikirim' ? 'Menunggu Penilaian' : ($sub->status === 'dinilai' ? 'Sudah Dinilai' : 'Belum Dikumpulkan'),
                'submitted_at' => $sub->submitted_at ? \Carbon\Carbon::parse($sub->submitted_at)->translatedFormat('d M Y, H:i') : '-',
                'score' => $sub->nilai ?? '-'
            ];
        });

        return view('teacher.task-detail', compact('modul', 'task', 'submissions'));
    }

    public function edit($id_modul, $id_tugas)
    {
        $modul = Modul::with('mapel.batch')->findOrFail($id_modul);
        $task = Tugas::findOrFail($id_tugas);
        
        return view('teacher.task-create', compact('modul', 'task'));
    }

    public function update(Request $request, $id_modul, $id_tugas)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'deadline' => 'nullable|date',
            'resource_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:10240'
        ]);

        $tugas = Tugas::where('id_modul', $id_modul)->findOrFail($id_tugas);
        $tugas->judul_tugas = $request->title;
        $tugas->deskripsi_tugas = $request->content;
        $tugas->waktu_pengumpulan = $request->deadline;

        if ($request->hasFile('resource_file')) {
            if ($tugas->file_path_tugas && \Storage::disk('public')->exists($tugas->file_path_tugas)) {
                \Storage::disk('public')->delete($tugas->file_path_tugas);
            }
            $file = $request->file('resource_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/assignments', $filename);
            $tugas->file_path_tugas = 'assignments/' . $filename;
        }

        $tugas->save();

        return redirect()->route('teacher.tasks.show', ['id_modul' => $id_modul, 'id_tugas' => $id_tugas])->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Request $request, $id_modul, $id_tugas)
    {
        $tugas = Tugas::where('id_modul', $id_modul)->findOrFail($id_tugas);
        if ($tugas->file_path_tugas && \Storage::disk('public')->exists($tugas->file_path_tugas)) {
            \Storage::disk('public')->delete($tugas->file_path_tugas);
        }
        $tugas->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tugas berhasil dihapus'
            ]);
        }

        return redirect()->route('teacher.modules.show', $id_modul)->with('success', 'Tugas berhasil dihapus!');
    }

    public function gradeTaskSubmission(Request $request, $id_modul, $id_tugas)
    {
        $request->validate([
            'student_id' => 'required',
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        $submission = \App\Models\Pengiriman_Tugas::findOrFail($request->student_id);
        $submission->nilai = $request->score;
        $submission->feedback = $request->feedback;
        $submission->status = 'dinilai';
        $submission->save();

        return back()->with('success', 'Nilai berhasil disimpan!');
    }
}
