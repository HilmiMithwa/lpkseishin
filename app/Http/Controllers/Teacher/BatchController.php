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
        $teacher = Auth::user();
        
        // Get the actual batches assigned to this teacher directly from the pivot table
        $batches = $teacher->batches;

        return view('teacher.classes', compact('batches'));
    }

    // Menampilkan detail kelas & siswa dalam satu batch
    public function show($id_batch)
    {
        $batch = Batch::findOrFail($id_batch);
        $teacher = Auth::user();

        // Ambil semua kelas dalam batch ini karena guru terhubung ke batch
        $batchClasses = Mapel::where('id_batch', $id_batch)
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

        // Ambil data Guru/Sensei yang terhubung ke batch ini secara dinamis
        $senseis = $batch->gurus;

        // Ambil data siswa yang terdaftar di batch ini
        $query = DB::table('student_list_batch')
            ->join('users', 'student_list_batch.user_id', '=', 'users.id')
            ->where('student_list_batch.id_batch', $id_batch)
            ->select('users.id', 'users.name', 'users.profile_photo_path', 'student_list_batch.status', 'student_list_batch.id_studentbatch')
            ->distinct();

        // Filter berdasarkan pencarian nama atau ID siswa
        $searchData = request('search');
        $searchValue = is_array($searchData) ? ($searchData['value'] ?? '') : $searchData;
        
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('users.name', 'ilike', "%{$searchValue}%")
                  ->orWhereRaw("CONCAT('SIS-', LPAD(CAST(users.id AS text), 3, '0')) ILIKE ?", ["%{$searchValue}%"]);
            });
        }

        // Filter berdasarkan status
        if (request()->filled('status') && request('status') !== 'all') {
            $query->where('student_list_batch.status', ucfirst(request('status')));
        }

        if (request()->ajax() || request()->has('draw')) {
            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('id_siswa', function ($row) {
                    return 'SIS-' . str_pad($row->id, 3, '0', STR_PAD_LEFT);
                })
                ->addColumn('avatar_url', function ($row) {
                    if ($row->profile_photo_path) {
                        return \Illuminate\Support\Facades\Storage::disk('s3')->url($row->profile_photo_path);
                    }
                    return 'https://ui-avatars.com/api/?name=' . urlencode($row->name) . '&background=f3f4f6&color=d62828&bold=true';
                })
                ->addColumn('fallback_avatar_url', function ($row) {
                    return 'https://ui-avatars.com/api/?name=' . urlencode($row->name) . '&background=f3f4f6&color=d62828&bold=true';
                })
                ->addColumn('module_progress', function ($row) {
                    return 0;
                })
                ->addColumn('average_task', function ($row) {
                    return 0;
                })
                ->addColumn('eval_score', function ($row) {
                    return 0;
                })
                ->addColumn('status_badge', function ($row) {
                    if ($row->status === 'Active') {
                        return '<span class="px-2.5 py-1 text-[10px] sm:text-xs font-bold rounded-md bg-green-50 text-green-600 border border-green-200">ACTIVE</span>';
                    } elseif ($row->status === 'Inactive') {
                        return '<span class="px-2.5 py-1 text-[10px] sm:text-xs font-bold rounded-md bg-red-50 text-[#d62828] border border-red-200">INACTIVE</span>';
                    } elseif ($row->status === 'Completed') {
                        return '<span class="px-2.5 py-1 text-[10px] sm:text-xs font-bold rounded-md bg-blue-50 text-blue-600 border border-blue-200">COMPLETED</span>';
                    }
                    return '<span class="px-2.5 py-1 text-[10px] sm:text-xs font-bold rounded-md bg-gray-50 text-gray-600 border border-gray-200">' . strtoupper($row->status) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $name = htmlspecialchars(addslashes($row->name));
                    return '<button @click="$dispatch(\'open-student-sidebar\', { id: \''.$row->id_studentbatch.'\', name: \''.$name.'\', status: \''.$row->status.'\' })" class="p-2 text-gray-400 hover:text-[#d62828] hover:bg-red-50 rounded-lg transition" title="Lihat Detail & Status">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>';
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        // Jika bukan AJAX (inisial load), tidak perlu query student lengkap, DataTables akan mengambilnya via AJAX
        $students = []; // Placeholder

        return view('teacher.batch-detail', compact('batch', 'batchClasses', 'students', 'senseis'));
    }

    public function storeClass(Request $request, $id_batch)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'deskripsi_mapel' => 'required|string',
            'target' => 'required|string',
            'jadwal' => 'required|string',
            'min_score' => 'required|integer',
        ]);
        Mapel::create([
            'id_batch' => $id_batch,
            'nama_mapel' => $request->nama_mapel,
            'deskripsi_mapel' => $request->deskripsi_mapel,
            'id_guru' => Auth::id(), // otomatis guru yang sedang login
            'jp' => 0,
            'status' => 'Aktif',
            'target' => $request->target,
            'jadwal' => $request->jadwal,
            'min_score' => $request->min_score,
        ]);
        return redirect()->back()->with('success', 'Kelas baru berhasil ditambahkan!');
    }

    public function updateStudentStatus(Request $request, $id_studentbatch)
    {
        $request->validate([
            'status' => 'required|string|in:Active,Inactive,Completed',
        ]);

        DB::table('student_list_batch')
            ->where('id_studentbatch', $id_studentbatch)
            ->update([
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Status siswa berhasil diperbarui!');
    }
}
