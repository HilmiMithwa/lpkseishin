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
        $mapelId = $modul->id_mapel;
        $batchId = $modul->mapel->id_batch ?? null;
        $batchName = $modul->mapel->batch->nama ?? 'Unknown Batch';
        $className = $modul->mapel->nama_mapel ?? 'Unknown Class';
        
        $moduleIndex = Modul::where('id_mapel', $mapelId)->orderBy('id_modul', 'asc')->pluck('id_modul')->search($currentModuleId) + 1;
        
        return view('teacher.material-create', compact('modul', 'currentModuleId', 'mapelId', 'batchId', 'moduleIndex', 'batchName', 'className'));
    }

    public function store(Request $request, $id_modul)
    {
        $rules = [
            'nama_bahan_ajar' => 'required|string|max:255',
            'type' => 'required|string|in:theory,practice,video',
            'video_title' => 'nullable|string|max:255',
            'video_url' => 'nullable|string',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400', // Max 100MB
            'focus_skill' => 'nullable|string|max:255',
            'key_points' => 'nullable|string',
            'objective' => 'nullable|string',
            'sensei_note' => 'nullable|string',
            'bahan_ajar_description' => 'nullable|string',
            'resource_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:51200', // Max 50MB
            
            // For practice tasks
            'task_title' => 'nullable|string|max:255',
            'task_description' => 'nullable|string',
            'task_deadline' => 'nullable|date',
            'task_file' => 'nullable|file|max:51200', // Max 50MB
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

        // Ensure video is provided if any video metadata is filled
        $hasVideoDetails = $request->filled('video_title') || 
                           $request->filled('focus_skill') || 
                           $request->filled('key_points') || 
                           $request->filled('objective') || 
                           $request->filled('sensei_note');

        if ($hasVideoDetails) {
            $rules['video_url'] = 'required_without:video_file|nullable|string';
            $rules['video_file'] = 'required_without:video_url|nullable|file|mimes:mp4,mov,avi,wmv|max:102400';
            $messages['video_url.required_without'] = 'Anda mengisi detail/informasi video, sehingga Anda harus menyertakan URL video atau mengunggah file videonya.';
            $messages['video_file.required_without'] = 'Anda mengisi detail/informasi video, sehingga Anda harus mengunggah file video atau menyertakan URL videonya.';
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
        $mapelId = $modul->id_mapel;
        $batchId = $modul->mapel->id_batch ?? null;
        $batchName = $modul->mapel->batch->nama ?? 'Unknown Batch';
        $className = $modul->mapel->nama_mapel ?? 'Unknown Class';

        $moduleIndex = Modul::where('id_mapel', $mapelId)->orderBy('id_modul', 'asc')->pluck('id_modul')->search($currentModuleId) + 1;

        $tugas = null;
        if (strtolower($material->type) === 'practice') {
            $tugas = \App\Models\Tugas::where('id_modul', $id_modul)->latest('id_tugas')->first();
        }

        return view('teacher.material-detail', compact('material', 'modul', 'currentModuleId', 'mapelId', 'batchId', 'moduleIndex', 'batchName', 'className', 'tugas'));
    }

    public function destroy($id_modul, $id_materi)
    {
        $material = BahanAjar::findOrFail($id_materi);
        
        $disk = 'public';

        if ($material->path_file_dokumen_ajar) {
            $path = str_replace('/storage/', '', $material->path_file_dokumen_ajar);
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        }

        if ($material->video_url && str_starts_with($material->video_url, '/storage/')) {
            $path = str_replace('/storage/', '', $material->video_url);
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        }
        
        $material->delete();

        return redirect()->route('teacher.modules.show', $id_modul)->with('success', 'Materi berhasil dihapus!');
    }
    public function edit($id_modul, $id_materi)
    {
        $material = BahanAjar::findOrFail($id_materi);
        $modul = Modul::with('mapel.batch')->findOrFail($id_modul);
        
        $currentModuleId = $modul->id_modul;
        $mapelId = $modul->id_mapel;
        $batchId = $modul->mapel->id_batch ?? null;
        $batchName = $modul->mapel->batch->nama ?? 'Unknown Batch';
        $className = $modul->mapel->nama_mapel ?? 'Unknown Class';

        $moduleIndex = Modul::where('id_mapel', $mapelId)->orderBy('id_modul', 'asc')->pluck('id_modul')->search($currentModuleId) + 1;

        $tugas = null;
        if (strtolower($material->type) === 'practice') {
            $tugas = \App\Models\Tugas::where('id_modul', $id_modul)->latest('id_tugas')->first();
        }

        return view('teacher.material-edit', compact('material', 'modul', 'currentModuleId', 'mapelId', 'batchId', 'moduleIndex', 'batchName', 'className', 'tugas'));
    }

    public function update(Request $request, $id_modul, $id_materi)
    {
        $material = BahanAjar::findOrFail($id_materi);
        $modul = Modul::findOrFail($id_modul);

        $rules = [
            'nama_bahan_ajar' => 'required|string|max:255',
            'type' => 'required|string|in:theory,practice,video',
            'video_title' => 'nullable|string|max:255',
            'video_url' => 'nullable|string',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400',
            'focus_skill' => 'nullable|string|max:255',
            'key_points' => 'nullable|string',
            'objective' => 'nullable|string',
            'sensei_note' => 'nullable|string',
            'bahan_ajar_description' => 'nullable|string',
            'resource_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:51200',
        ];

        // For practice tasks
        if ($request->input('type') === 'practice') {
            $rules['task_title'] = 'required|string|max:255';
            $rules['task_description'] = 'required|string';
            $rules['task_deadline'] = 'required|date';
            $rules['task_file'] = 'nullable|file|max:51200';
        }

        // Ensure video is provided if any video metadata is filled
        $hasVideoDetails = $request->filled('video_title') || 
                           $request->filled('focus_skill') || 
                           $request->filled('key_points') || 
                           $request->filled('objective') || 
                           $request->filled('sensei_note');

        if ($hasVideoDetails) {
            $rules['video_url'] = 'required_without:video_file|nullable|string';
            $rules['video_file'] = 'required_without:video_url|nullable|file|mimes:mp4,mov,avi,wmv|max:102400';
            $messages['video_url.required_without'] = 'Anda mengisi detail/informasi video, sehingga Anda harus menyertakan URL video atau mengunggah file videonya.';
            $messages['video_file.required_without'] = 'Anda mengisi detail/informasi video, sehingga Anda harus mengunggah file video atau menyertakan URL videonya.';
        }

        $messages = [
            'nama_bahan_ajar.required' => 'Judul materi wajib diisi.',
            'bahan_ajar_description.required' => 'Teks / Deskripsi materi dari editor wajib diisi.',
            'task_title.required' => 'Judul tugas wajib diisi untuk tipe Praktik.',
            'task_description.required' => 'Deskripsi tugas wajib diisi untuk tipe Praktik.',
            'task_deadline.required' => 'Batas waktu tugas wajib diisi untuk tipe Praktik.',
        ];

        $request->validate($rules, $messages);

        $material->nama_bahan_ajar = $request->input('nama_bahan_ajar');
        $material->type = $request->input('type');
        $material->bahan_ajar_description = $request->input('bahan_ajar_description') ?: $request->input('task_description');
        
        $material->video_title = $request->input('video_title');
        $material->video_url = $request->input('video_url');
        
        if ($request->hasFile('video_file')) {
            // Delete old if exists
            if ($material->video_url && str_starts_with($material->video_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $material->video_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $file = $request->file('video_file');
            $path = $file->store('materials/videos', 'public');
            $material->video_url = '/storage/' . $path;
            $material->video_title = $material->video_title ?: $file->getClientOriginalName();
        }

        $material->focus_skill = $request->input('focus_skill');
        $material->key_points = $request->input('key_points');
        $material->objective = $request->input('objective');
        $material->sensei_note = $request->input('sensei_note');

        if ($request->hasFile('resource_file')) {
            if ($material->path_file_dokumen_ajar && str_starts_with($material->path_file_dokumen_ajar, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $material->path_file_dokumen_ajar);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $file = $request->file('resource_file');
            $path = $file->store('materials/documents', 'public');
            $material->nama_dokumen_ajar = $file->getClientOriginalName();
            $material->path_file_dokumen_ajar = '/storage/' . $path;
            $material->ukuran_file_dokumen_ajar = $file->getSize();
            $material->unggah_file_dokumen_ajar = now();
        }

        if ($request->hasFile('task_file')) {
            if ($material->path_file_dokumen_ajar && str_starts_with($material->path_file_dokumen_ajar, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $material->path_file_dokumen_ajar);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $file = $request->file('task_file');
            $path = $file->store('materials/tasks', 'public');
            $material->nama_dokumen_ajar = $file->getClientOriginalName();
            $material->path_file_dokumen_ajar = '/storage/' . $path;
            $material->ukuran_file_dokumen_ajar = $file->getSize();
            $material->unggah_file_dokumen_ajar = now();
        }

        $material->save();

        if ($request->input('type') === 'practice' && $request->input('task_title')) {
            $tugas = \App\Models\Tugas::where('id_modul', $id_modul)->latest('id_tugas')->first();
            if ($tugas) {
                $tugas->update([
                    'judul_tugas' => $request->input('task_title'),
                    'deskripsi_tugas' => $request->input('task_description') ?: 'Tidak ada deskripsi',
                    'waktu_pengumpulan' => $request->input('task_deadline'),
                ]);
            } else {
                \App\Models\Tugas::create([
                    'judul_tugas' => $request->input('task_title'),
                    'deskripsi_tugas' => $request->input('task_description') ?: 'Tidak ada deskripsi',
                    'waktu_pengumpulan' => $request->input('task_deadline'),
                    'status_tugas' => 'active',
                    'id_rps' => $modul->id_rps ?? \App\Models\Rps::first()->id_rps ?? 1,
                    'id_modul' => $id_modul,
                ]);
            }
        }

        return redirect()->route('teacher.materials.show', [$id_modul, $id_materi])->with('success', 'Materi berhasil diperbarui!');
    }
}
