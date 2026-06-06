<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modul;
use App\Models\BahanAjar;
use Illuminate\Support\Facades\Storage;

class BahanAjarController extends Controller
{
    public function create($id_modul)
    {
        $modul = Modul::with(['mapel.batch'])->findOrFail($id_modul);
        $currentModuleId = $modul->id_modul;
        $batchName = $modul->mapel->batch->nama ?? 'Unknown Batch';
        $className = $modul->mapel->nama_mapel ?? 'Unknown Class';
        
        return view('teacher.material-create', compact('modul', 'currentModuleId', 'batchName', 'className'));
    }

    public function store(Request $request, $id_modul)
    {
        $rules = [
            'nama_bahan_ajar' => 'required|string|max:255',
            'type' => 'required|string|in:theory,practice',
            'bahan_ajar_description' => 'required|string',
        ];

        $messages = [
            'nama_bahan_ajar.required' => 'Judul materi wajib diisi.',
            'bahan_ajar_description.required' => 'Teks / Deskripsi materi dari editor wajib diisi.',
            'task_title.required' => 'Judul tugas wajib diisi untuk tipe Praktik.',
            'task_description.required' => 'Deskripsi tugas wajib diisi untuk tipe Praktik.',
            'task_deadline.required' => 'Batas waktu tugas wajib diisi untuk tipe Praktik.',
        ];

        // Ensure task fields are strictly required if practice
        if ($request->input('type') === 'practice') {
            $rules['task_title'] = 'required|string|max:255';
            $rules['task_description'] = 'required|string';
            $rules['task_deadline'] = 'required|date';
        }

        $request->validate($rules, $messages);

        $modul = Modul::findOrFail($id_modul);

        $bahanAjar = new BahanAjar();
        $bahanAjar->id_modul = $id_modul;
        $bahanAjar->nama_bahan_ajar = $request->input('nama_bahan_ajar');
        $bahanAjar->type = $request->input('type');

        // Content
        $bahanAjar->bahan_ajar_description = $request->input('bahan_ajar_description') ?: $request->input('task_description');

        // Video fields
        $bahanAjar->video_title = $request->input('video_title');
        $bahanAjar->video_url = $request->input('video_url');
        
        // Video upload (if any)
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $path = $file->store('materials/videos', 'public');
            $bahanAjar->video_url = '/storage/' . $path;
            $bahanAjar->video_title = $bahanAjar->video_title ?: $file->getClientOriginalName();
        }

        // Additional fields
        $bahanAjar->focus_skill = $request->input('focus_skill');
        $bahanAjar->key_points = $request->input('key_points');
        $bahanAjar->objective = $request->input('objective');
        $bahanAjar->sensei_note = $request->input('sensei_note');

        // Resource / Document upload
        if ($request->hasFile('resource_file')) {
            $file = $request->file('resource_file');
            $path = $file->store('materials/documents', 'public');
            $bahanAjar->nama_dokumen_ajar = $file->getClientOriginalName();
            $bahanAjar->path_file_dokumen_ajar = '/storage/' . $path;
            $bahanAjar->ukuran_file_dokumen_ajar = $file->getSize();
            // Just mark it as uploaded
            $bahanAjar->unggah_file_dokumen_ajar = now();
        }

        // Task file upload (if Practice)
        if ($request->hasFile('task_file')) {
            $file = $request->file('task_file');
            $path = $file->store('materials/tasks', 'public');
            $bahanAjar->nama_dokumen_ajar = $file->getClientOriginalName();
            $bahanAjar->path_file_dokumen_ajar = '/storage/' . $path;
            $bahanAjar->ukuran_file_dokumen_ajar = $file->getSize();
            $bahanAjar->unggah_file_dokumen_ajar = now();
        }

        $bahanAjar->save();

        if ($request->input('type') === 'practice' && $request->input('task_title')) {
            \App\Models\Tugas::create([
                'judul_tugas' => $request->input('task_title'),
                'deskripsi_tugas' => $request->input('task_description') ?: 'Tidak ada deskripsi',
                'waktu_pengumpulan' => $request->input('task_deadline'),
                'status_tugas' => 'active',
                'id_rps' => $modul->id_rps ?? \App\Models\Rps::first()->id_rps ?? 1, // Fallback if modul has no rps
                'id_modul' => $id_modul,
            ]);
        }

        return redirect()->route('teacher.modules.show', $id_modul)->with('success', 'Materi berhasil ditambahkan!');
    }

    public function show($id_modul, $id_materi)
    {
        $material = BahanAjar::findOrFail($id_materi);
        $modul = Modul::with('mapel.batch')->findOrFail($id_modul);
        
        $currentModuleId = $modul->id_modul;
        $batchName = $modul->mapel->batch->nama ?? 'Unknown Batch';
        $className = $modul->mapel->nama_mapel ?? 'Unknown Class';

        $tugas = null;
        if (strtolower($material->type) === 'practice') {
            $tugas = \App\Models\Tugas::where('id_modul', $id_modul)->latest('id_tugas')->first();
        }

        return view('teacher.material-detail', compact('material', 'modul', 'currentModuleId', 'batchName', 'className', 'tugas'));
    }

    public function destroy($id_modul, $id_materi)
    {
        $material = BahanAjar::findOrFail($id_materi);
        
        $disk = env('FILESYSTEM_DISK', 's3');

        if ($material->path_file_dokumen_ajar && Storage::disk($disk)->exists($material->path_file_dokumen_ajar)) {
            Storage::disk($disk)->delete($material->path_file_dokumen_ajar);
        }
        
        $material->delete();

        return redirect()->route('teacher.modules.show', $id_modul)->with('success', 'Materi berhasil dihapus!');
    }
}
