<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $batches = Batch::when($status, function($q, $status) {
                $q->where('status', $status);
            })
            ->when($search, function($q, $search) {
                $q->where(function($sub) use ($search) {
                    $sub->where('nama', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%")
                        ->orWhere('nama_program', 'like', "%{$search}%")
                        ->orWhere('level_target', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $studentCounts = DB::table('student_list_batch')
            ->select('id_batch', DB::raw('count(distinct user_id) as student_count'))
            ->groupBy('id_batch')
            ->pluck('student_count', 'id_batch')
            ->toArray();

        return view('admin.batches.index', compact('batches', 'studentCounts', 'status'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'string', 'in:pendaftaran,aktif,selesai'],
            'quota' => ['required', 'integer', 'min:1'],
            'jadwal' => ['required', 'string'],
            'jam_mulai' => ['nullable', 'date_format:H:i'],
            'jam_selesai' => ['nullable', 'date_format:H:i'],
        ]);

        // Auto-determine program & level target from name or defaults
        $name = $validated['batch_name'];
        $level = 'N5';
        if (stripos($name, 'N4') !== false) {
            $level = 'N4';
        } elseif (stripos($name, 'N3') !== false) {
            $level = 'N3';
        } elseif (stripos($name, 'N2') !== false) {
            $level = 'N2';
        } elseif (stripos($name, 'N1') !== false) {
            $level = 'N1';
        }

        $program = 'Program Persiapan ' . $level;
        
        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);
        $months = $start->diffInMonths($end);
        $duration = ($months > 0 ? $months : 1) . ' Bulan';

        Batch::create([
            'nama' => $name,
            'nama_program' => $program,
            'level_target' => $level,
            'deskripsi' => $validated['description'] ?? '',
            'waktu_mulai' => $validated['start_date'],
            'waktu_berakhir' => $validated['end_date'],
            'durasi' => $duration,
            'jadwal' => $validated['jadwal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'status' => $validated['status'],
            'quota' => $validated['quota'],
        ]);

        return redirect()->route('admin.batches')
            ->with('success', 'Data batch berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $validated = $request->validate([
            'batch_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'string', 'in:pendaftaran,aktif,selesai'],
            'quota' => ['required', 'integer', 'min:1'],
            'jadwal' => ['required', 'string'],
            'jam_mulai' => ['nullable', 'date_format:H:i'],
            'jam_selesai' => ['nullable', 'date_format:H:i'],
        ]);

        $name = $validated['batch_name'];
        $level = 'N5';
        if (stripos($name, 'N4') !== false) {
            $level = 'N4';
        } elseif (stripos($name, 'N3') !== false) {
            $level = 'N3';
        } elseif (stripos($name, 'N2') !== false) {
            $level = 'N2';
        } elseif (stripos($name, 'N1') !== false) {
            $level = 'N1';
        }

        $program = 'Program Persiapan ' . $level;

        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);
        $months = $start->diffInMonths($end);
        $duration = ($months > 0 ? $months : 1) . ' Bulan';

        $batch->update([
            'nama' => $name,
            'nama_program' => $program,
            'level_target' => $level,
            'deskripsi' => $validated['description'] ?? '',
            'waktu_mulai' => $validated['start_date'],
            'waktu_berakhir' => $validated['end_date'],
            'durasi' => $duration,
            'jadwal' => $validated['jadwal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'status' => $validated['status'],
            'quota' => $validated['quota'],
        ]);

        return redirect()->route('admin.batches')
            ->with('success', 'Perubahan batch berhasil disimpan!');
    }

    public function destroy($id)
    {
        $batch = Batch::findOrFail($id);
        $batch->delete();

        return redirect()->route('admin.batches')
            ->with('success', 'Batch berhasil dihapus!');
    }
}
