<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;
use App\Http\Requests\Teacher\StoreModulRequest;

class MapelController extends Controller
{
    public function show($id_mapel)
    {
        $classData = Mapel::with('batch')->findOrFail($id_mapel);
        $modules = Modul::where('id_mapel', $id_mapel)->orderBy('id_modul', 'asc')->get();
        $announcements = $classData->announcements;

        return view('teacher.class-detail', compact('classData', 'modules', 'announcements'));
    }

    public function update(Request $request, $id_mapel)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'deskripsi_mapel' => 'required|string',
            'target' => 'required|string',
            'jp' => 'required|numeric',
            'jadwal' => 'required|string',
            'min_score' => 'required|numeric',
        ]);

        $mapel = Mapel::findOrFail($id_mapel);
        $mapel->update([
            'nama_mapel' => $request->nama_mapel,
            'deskripsi_mapel' => $request->deskripsi_mapel,
            'target' => $request->target,
            'jp' => $request->jp,
            'jadwal' => $request->jadwal,
            'min_score' => $request->min_score,
        ]);

        return redirect()->back()->with('success', 'Perubahan kelas berhasil disimpan!');
    }

    public function addModul(StoreModulRequest $request)
    {
        $data = $request->validated();

        // 1. Pemetaan Nama Field (Form Request: teori/praktik -> DB: jp_teori/jp_praktik)
        $data['jp_teori'] = $data['teori'] ?? null;
        $data['jp_praktik'] = $data['praktik'] ?? null;

        // Hapus key lama agar tidak mengotori array payload
        unset($data['teori'], $data['praktik']);

        // Jika teori dan praktik tidak diisi, gunakan fallback jp (dibagi 1/3 teori dan 2/3 praktik)
        if (is_null($data['jp_teori']) && is_null($data['jp_praktik'])) {
            $total_jp = $data['jp'] ?? 0;
            $data['jp_teori'] = (int) ceil($total_jp / 3);
            $data['jp_praktik'] = $total_jp - $data['jp_teori'];
        } else {
            $data['jp_teori'] = $data['jp_teori'] ?? 0;
            $data['jp_praktik'] = $data['jp_praktik'] ?? 0;
        }

        // 2. Generate kode_modul secara otomatis jika kosong
        if (empty($data['kode_modul'])) {
            $mapel = Mapel::findOrFail($data['id_mapel']);
            $level = 'MOD';
            if (preg_match('/N[3-5]/i', $mapel->target, $matches)) {
                $level = strtoupper($matches[0]);
            } elseif (preg_match('/N[3-5]/i', $mapel->nama_mapel, $matches)) {
                $level = strtoupper($matches[0]);
            }

            $count = Modul::where('id_mapel', $data['id_mapel'])->count();
            do {
                $count++;
                $kode_modul = 'MDL-' . $level . '-' . str_pad($count, 2, '0', STR_PAD_LEFT);
            } while (Modul::where('kode_modul', $kode_modul)->exists());
            $data['kode_modul'] = $kode_modul;
        }

        // 3. Simpan ke database
        Modul::create($data);

        // 4. Redirect kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Modul berhasil ditambahkan');
    }

    public function storeAnnouncement(Request $request, $id_mapel)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $announcement = \App\Models\Announcement::create([
            'title' => $request->title,
            'date_formatted' => now()->format('Y-m-d'),
            'id_mapel' => $id_mapel,
            'id_guru' => \Illuminate\Support\Facades\Auth::id(),
        ]);

        return response()->json(['success' => true, 'id' => $announcement->id]);
    }

    public function destroyAnnouncement($id)
    {
        $announcement = \App\Models\Announcement::findOrFail($id);
        $announcement->delete();
        
        return response()->json(['success' => true]);
    }

    public function destroy($id_mapel)
    {
        $mapel = Mapel::findOrFail($id_mapel);
        $id_batch = $mapel->id_batch;
        
        // Delete related records manually to avoid foreign key constraint errors if ON DELETE CASCADE is missing
        $moduls = \App\Models\Modul::with(['bahanAjar', 'evaluasi.questions.images'])->where('id_mapel', $id_mapel)->get();
        foreach ($moduls as $modul) {
            // Delete Bahan Ajar files
            foreach ($modul->bahanAjar as $materi) {
                if ($materi->path_file_dokumen_ajar) {
                    $path = str_replace('/storage/', '', $materi->path_file_dokumen_ajar);
                    if (\Storage::disk('public')->exists($path)) {
                        \Storage::disk('public')->delete($path);
                    }
                }
                if ($materi->video_url && str_starts_with($materi->video_url, '/storage/')) {
                    $path = str_replace('/storage/', '', $materi->video_url);
                    if (\Storage::disk('public')->exists($path)) {
                        \Storage::disk('public')->delete($path);
                    }
                }
                $materi->delete();
            }

            // Delete Tugas files
            $tasks = \App\Models\Tugas::where('id_modul', $modul->id_modul)->get();
            foreach ($tasks as $task) {
                if ($task->file_path_tugas && \Storage::disk('public')->exists($task->file_path_tugas)) {
                    \Storage::disk('public')->delete($task->file_path_tugas);
                }
                $task->delete();
            }

            // Delete Evaluasi and its relations
            foreach ($modul->evaluasi as $evaluasi) {
                foreach ($evaluasi->questions as $question) {
                    foreach ($question->images as $image) {
                        if (\Storage::disk('public')->exists($image->image_path)) {
                            \Storage::disk('public')->delete($image->image_path);
                        }
                    }
                    $question->images()->delete();
                    $question->delete();
                }
                $evaluasi->delete();
            }

            $modul->delete();
        }
        
        \App\Models\Rps::where('id_mapel', $id_mapel)->delete();
        \App\Models\Announcement::where('id_mapel', $id_mapel)->delete();
        \App\Models\Enrollment_List::where('id_mapel', $id_mapel)->delete();

        $mapel->delete();

        return redirect()->route('teacher.batch.show', $id_batch)->with('success', 'Kelas berhasil dihapus');
    }
    public function deleteModul($id_modul)
    {
        try {
            $modul = Modul::with(['bahanAjar', 'evaluasi.questions.images'])->findOrFail($id_modul);
            
            // 1. Delete Bahan Ajar files
            foreach ($modul->bahanAjar as $materi) {
                if ($materi->path_file_dokumen_ajar) {
                    $path = str_replace('/storage/', '', $materi->path_file_dokumen_ajar);
                    if (\Storage::disk('public')->exists($path)) {
                        \Storage::disk('public')->delete($path);
                    }
                }
                if ($materi->video_url && str_starts_with($materi->video_url, '/storage/')) {
                    $path = str_replace('/storage/', '', $materi->video_url);
                    if (\Storage::disk('public')->exists($path)) {
                        \Storage::disk('public')->delete($path);
                    }
                }
                $materi->delete();
            }

            // 2. Delete Tugas files
            $tasks = \App\Models\Tugas::where('id_modul', $id_modul)->get();
            foreach ($tasks as $task) {
                if ($task->file_path_tugas && \Storage::disk('public')->exists($task->file_path_tugas)) {
                    \Storage::disk('public')->delete($task->file_path_tugas);
                }
                $task->delete();
            }

            // 3. Delete Evaluasi and its relations
            foreach ($modul->evaluasi as $evaluasi) {
                foreach ($evaluasi->questions as $question) {
                    foreach ($question->images as $image) {
                        if (\Storage::disk('public')->exists($image->image_path)) {
                            \Storage::disk('public')->delete($image->image_path);
                        }
                    }
                    $question->images()->delete();
                    $question->delete();
                }
                $evaluasi->delete();
            }

            // 4. Finally, delete the module itself
            $modul->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Modul beserta seluruh isinya (Materi, Tugas, Evaluasi) berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus modul: ' . $e->getMessage()
            ], 500);
        }
    }
}
