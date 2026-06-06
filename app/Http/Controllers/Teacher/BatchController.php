<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    // Menampilkan list batch guru
    public function index()
    {
        $batches = Batch::all();
        return view('teacher.classes', compact('batches'));
    }

    // Menampilkan detail kelas & siswa dalam satu batch
    public function show($id_batch)
    {
        $batch = Batch::findOrFail($id_batch);
        $teacher = Auth::user();

        // Ambil kelas yang diajar oleh guru ini
        $batchClasses = Mapel::where('id_batch', $id_batch)
            ->where('id_guru', $teacher->id)
            ->withCount('modul')
            ->get();

        // Pemetaan data pendukung untuk view detail
        $batch->nama_batch = $batch->nama;
        $batch->tanggal_mulai = \Carbon\Carbon::parse($batch->waktu_mulai)->format('d M Y');
        $batch->tanggal_selesai = \Carbon\Carbon::parse($batch->waktu_berakhir)->format('d M Y');
        $batch->target_level = $batch->level_target;

        $batch->total_siswa = DB::table('enrollment_access')
            ->whereIn('id_mapel', $batchClasses->pluck('id_mapel'))
            ->distinct('id_user')
            ->count('id_user');
        $batch->total_kelas = $batchClasses->count();
        $batch->status = 'Active';

        // Ambil data Guru/Sensei yang mengajar mata pelajaran di batch ini secara dinamis
        $senseis = \App\Models\User::whereIn('id', function ($query) use ($id_batch) {
            $query->select('id_guru')->from('mapel')->where('id_batch', $id_batch);
        })->get();

        // Ambil data siswa yang terdaftar di kelas guru tersebut
        $students = DB::table('enrollment_access')
            ->join('users', 'enrollment_access.id_user', '=', 'users.id')
            ->whereIn('enrollment_access.id_mapel', $batchClasses->pluck('id_mapel'))
            ->select('users.id', 'users.name')
            ->distinct()
            ->get()
            ->map(function ($student, $index) {
                return (object)[
                    'no' => $index + 1,
                    'id_siswa' => 'SIS-' . str_pad($student->id, 3, '0', STR_PAD_LEFT),
                    'name' => $student->name,
                    'module_progress' => 50,
                    'avg_task' => 75,
                    'eval_score' => 80,
                    'status' => 'Active',
                ];
            });

        return view('teacher.batch-detail', compact('batch', 'batchClasses', 'students', 'senseis'));
    }

    public function storeClass(Request $request, $id_batch)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'deskripsi_mapel' => 'required|string',
            'target' => 'required|string',
            'jp' => 'required|integer',
            'jadwal' => 'required|string',
            'min_score' => 'required|integer',
        ]);
        Mapel::create([
            'id_batch' => $id_batch,
            'nama_mapel' => $request->nama_mapel,
            'deskripsi_mapel' => $request->deskripsi_mapel,
            'id_guru' => Auth::id(), // otomatis guru yang sedang login
            'jp' => $request->jp,
            'status' => 'Aktif',
            'target' => $request->target,
            'jadwal' => $request->jadwal,
            'min_score' => $request->min_score,
        ]);
        return redirect()->back()->with('success', 'Kelas baru berhasil ditambahkan!');
    }
}
