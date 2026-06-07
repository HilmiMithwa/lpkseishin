<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Mapel;
use App\Models\User;
use App\Models\BahanAjar;
use App\Models\Tugas;
use App\Models\Pengiriman_Tugas;
use App\Models\Enrollment_List;
use App\Models\CatatanMingguan;
use App\Models\CatatanEvaluasi;
use App\Http\Requests\Teacher\StoreWeeklyLogRequest;
use Illuminate\Support\Facades\DB;

class ProgressReportController extends Controller
{
    public function index(Request $request)
    {
        $teacher = auth()->user();
        $teacherBatches = $teacher->batches()->pluck('batch.id_batch')->toArray();
        $selectedBatchId = $request->get('batch_id');
        $selectedClassId = $request->get('class_id');

        // Get Batches for this teacher
        $batches = Batch::whereIn('id_batch', $teacherBatches)->get();

        $classes = collect();
        $students = collect();
        $avgClass = 0;
        $avgProgress = 0;
        $warningCount = 0;

        $selectedBatchName = '';
        $selectedClassName = '';

        // If batch is selected, get classes for the selected batch
        if ($selectedBatchId) {
            $selectedBatchName = $batches->where('id_batch', $selectedBatchId)->first()->nama ?? '';
            $classes = Mapel::where('id_batch', $selectedBatchId)->get();
        }

        $enrollments = collect();

        // If class is selected, get progress for enrolled students
        if ($selectedClassId) {
            $selectedClassName = $classes->where('id_mapel', $selectedClassId)->first()->nama_mapel ?? '';
            $enrollments = Enrollment_List::where('id_mapel', $selectedClassId)->pluck('id_user');
            $studentCount = $enrollments->count();

            // Total Items for progress percentage
            $totalMaterial = BahanAjar::whereHas('modul', function ($q) use ($selectedClassId) {
                $q->where('id_mapel', $selectedClassId);
            })->count();
            $totalTask = Tugas::whereHas('modul', function ($q) use ($selectedClassId) {
                $q->where('id_mapel', $selectedClassId);
            })->count();
            $totalItems = $totalMaterial + $totalTask;

            // Bulk Fetch Data for stats
            $completedMaterials = DB::table('bahan_ajar_progress')
                ->join('bahan_ajar', 'bahan_ajar.id_bahan_ajar', '=', 'bahan_ajar_progress.id_bahan_ajar')
                ->join('modul', 'modul.id_modul', '=', 'bahan_ajar.id_modul')
                ->where('modul.id_mapel', $selectedClassId)
                ->whereIn('bahan_ajar_progress.id_user', $enrollments)
                ->where('bahan_ajar_progress.is_complete', DB::raw('true'))
                ->select('bahan_ajar_progress.id_user', DB::raw('COUNT(*) as count'))
                ->groupBy('bahan_ajar_progress.id_user')
                ->pluck('count', 'id_user');

            $tasksData = DB::table('pengiriman_tugas')
                ->join('tugas', 'tugas.id_tugas', '=', 'pengiriman_tugas.id_tugas')
                ->join('modul', 'modul.id_modul', '=', 'tugas.id_modul')
                ->where('modul.id_mapel', $selectedClassId)
                ->whereIn('pengiriman_tugas.id_user', $enrollments)
                ->whereIn('pengiriman_tugas.status', ['dikirim', 'Sudah Dinilai'])
                ->select(
                    'pengiriman_tugas.id_user', 
                    DB::raw('COUNT(*) as count'), 
                    DB::raw('AVG(CASE WHEN pengiriman_tugas.status = \'Sudah Dinilai\' THEN pengiriman_tugas.nilai ELSE NULL END) as avg_nilai')
                )
                ->groupBy('pengiriman_tugas.id_user')
                ->get()
                ->keyBy('id_user');

            if ($studentCount > 0) {
                $totalProgressAll = 0;
                $totalRataTugasAll = 0;

                foreach ($enrollments as $userId) {
                    $cMaterial = $completedMaterials->get($userId, 0);
                    $taskRow = $tasksData->get($userId);
                    $cTask = $taskRow ? $taskRow->count : 0;
                    
                    $completedItems = $cMaterial + $cTask;
                    $progressPercentage = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
                    $taskAverage = $taskRow && $taskRow->avg_nilai !== null ? round($taskRow->avg_nilai) : 0;

                    $totalProgressAll += $progressPercentage;
                    $totalRataTugasAll += $taskAverage;

                    if ($progressPercentage < 50) $warningCount++;
                }

                $avgClass = round($totalRataTugasAll / $studentCount);
                $avgProgress = round($totalProgressAll / $studentCount);
            }

            // AJAX DATATABLES
            if ($request->ajax() || $request->has('draw')) {
                $query = DB::table('student_list_batch')
                    ->join('users', 'student_list_batch.user_id', '=', 'users.id')
                    ->where('student_list_batch.id_batch', $selectedBatchId)
                    ->whereIn('users.id', $enrollments)
                    ->select('users.id', 'users.name', 'student_list_batch.status');

                // Filter pencarian
                $searchData = request('search');
                $searchValue = is_array($searchData) ? ($searchData['value'] ?? '') : $searchData;
                if (!empty($searchValue)) {
                    $query->where('users.name', 'ilike', "%{$searchValue}%");
                }

                // Filter status
                if ($request->filled('status') && $request->get('status') !== 'all') {
                    if ($request->get('status') === 'Aktif') $query->where('student_list_batch.status', 'Active');
                    elseif ($request->get('status') === 'Tidak Aktif') $query->where('student_list_batch.status', 'Inactive');
                    elseif ($request->get('status') === 'Selesai') $query->where('student_list_batch.status', 'Completed');
                }

                $evaluations = DB::table('catatan_evaluasi')
                    ->where('id_mapel', $selectedClassId)
                    ->whereIn('id_user', $enrollments)
                    ->select('id_user', DB::raw('AVG(skor) as avg_eval'))
                    ->groupBy('id_user')
                    ->pluck('avg_eval', 'id_user');

                return \Yajra\DataTables\Facades\DataTables::of($query)
                    ->filter(function ($query) {
                        // Prevent Yajra's default global search, since we already manually filtered the query above.
                    })
                    ->addIndexColumn()
                    ->addColumn('formatted_id', function ($row) {
                        return '012025' . str_pad($row->id, 3, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('avatar_url', function($row) {
                        return 'https://ui-avatars.com/api/?name=' . urlencode($row->name) . '&background=random';
                    })
                    ->addColumn('progress_modul', function ($row) use ($completedMaterials, $tasksData, $totalItems) {
                        $cMaterial = $completedMaterials->get($row->id, 0);
                        $taskRow = $tasksData->get($row->id);
                        $cTask = $taskRow ? $taskRow->count : 0;
                        $completedItems = $cMaterial + $cTask;
                        return $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
                    })
                    ->addColumn('rata_rata_tugas', function ($row) use ($tasksData) {
                        $taskRow = $tasksData->get($row->id);
                        return $taskRow && $taskRow->avg_nilai !== null ? round($taskRow->avg_nilai) : 0;
                    })
                    ->addColumn('nilai_evaluasi', function ($row) use ($evaluations) {
                        $eval = $evaluations->get($row->id);
                        return $eval !== null ? round($eval) : '-';
                    })
                    ->addColumn('status_badge', function ($row) {
                        if ($row->status === 'Completed') return '<span class="inline-flex px-3 py-1 bg-gray-200 text-gray-700 rounded-lg text-[10px] font-bold tracking-wide uppercase">Selesai</span>';
                        if ($row->status === 'Active') return '<span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-lg text-[10px] font-bold tracking-wide uppercase">Aktif</span>';
                        return '<span class="inline-flex px-3 py-1 bg-red-100 text-red-700 rounded-lg text-[10px] font-bold tracking-wide uppercase">Tidak Aktif</span>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<button @click="openStudentDetail(' . $row->id . ')" class="w-8 h-8 inline-flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>';
                    })
                    ->rawColumns(['status_badge', 'action'])
                    ->make(true);
            }
        }

        return view('teacher.progress-report', compact(
            'batches',
            'classes',
            'students',
            'selectedBatchId',
            'selectedClassId',
            'selectedBatchName',
            'selectedClassName',
            'avgClass',
            'avgProgress',
            'warningCount'
        ));
    }

    public function getStudentDetails($id_user, $id_mapel)
    {
        $user = User::find($id_user);
        if (!$user) return response()->json(['error' => 'Student not found'], 404);

        $weeklyLogs = CatatanMingguan::where('id_user', $id_user)
            ->where('id_mapel', $id_mapel)
            ->orderBy('minggu_ke', 'asc')
            ->get();

        $evaluations = CatatanEvaluasi::where('id_user', $id_user)
            ->where('id_mapel', $id_mapel)
            ->orderBy('created_at', 'asc')
            ->get();

        // Calculate averages for radar chart
        $avgWord = $weeklyLogs->avg('score_word') ?? 0;
        $avgKotoba = $weeklyLogs->avg('score_kotoba') ?? 0;
        $avgBunpou = $weeklyLogs->avg('score_bunpou') ?? 0;
        $avgKanji = $weeklyLogs->avg('score_kanji') ?? 0;
        $avgChoukai = $weeklyLogs->avg('score_choukai') ?? 0;
        $avgKaiwa = $weeklyLogs->avg('score_kaiwa') ?? 0;

        $overallAverage = round(($avgWord + $avgKotoba + $avgBunpou + $avgKanji + $avgChoukai + $avgKaiwa) / 6);
        
        $predikat = 'E - Sangat Kurang';
        if ($overallAverage >= 85) $predikat = 'A - Sangat Baik';
        elseif ($overallAverage >= 75) $predikat = 'B - Baik';
        elseif ($overallAverage >= 65) $predikat = 'C - Cukup';
        elseif ($overallAverage >= 50) $predikat = 'D - Kurang';

        return response()->json([
            'studentName' => $user->name,
            'studentAvatar' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random',
            'overallAverage' => $overallAverage,
            'predikat' => $predikat,
            'radarScores' => [round($avgWord), round($avgKotoba), round($avgBunpou), round($avgKanji), round($avgChoukai), round($avgKaiwa)],
            'weeklyLogs' => $weeklyLogs,
            'evaluations' => $evaluations
        ]);
    }

    public function storeWeeklyLog(StoreWeeklyLogRequest $request)
    {
        CatatanMingguan::create($request->validated());

        return response()->json(['success' => true]);
    }

    public function updateWeeklyLog(StoreWeeklyLogRequest $request, $id)
    {
        $log = CatatanMingguan::findOrFail($id);
        $log->update($request->validated());
        return response()->json(['success' => true]);
    }

    public function destroyWeeklyLog($id)
    {
        $log = CatatanMingguan::findOrFail($id);
        $log->delete();
        return response()->json(['success' => true]);
    }

    public function storeEvaluationLog(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_mapel' => 'required|exists:mapel,id_mapel',
            'nama_evaluasi' => 'required|string|max:255',
            'tipe_ujian' => 'nullable|string|max:50',
            'skor' => 'required|integer|min:0|max:100',
        ]);

        CatatanEvaluasi::create($request->all());

        return response()->json(['success' => true]);
    }

    public function updateEvaluationLog(Request $request, $id)
    {
        $log = CatatanEvaluasi::findOrFail($id);
        
        $data = $request->all();
        if (strtolower($log->tipe_ujian) === 'online') {
            if ($request->has('skor_essay')) {
                $skorEssay = $request->input('skor_essay');
                $skorPg = $log->skor_pg;

                if (is_null($skorPg)) {
                    if (!is_null($log->skor_essay)) {
                        // Reverse calculate PG score if it was already averaged
                        $skorPg = ($log->skor * 2) - $log->skor_essay;
                    } else {
                        // Fallback to skor if it wasn't graded yet (assuming skor = PG)
                        $skorPg = $log->skor ?? 0;
                    }
                    
                    // Auto fix database
                    $log->skor_pg = $skorPg;
                }
                
                $skorAkhir = round(($skorPg + $skorEssay) / 2);
                
                $data = [
                    'skor_pg' => $skorPg,
                    'skor_essay' => $skorEssay,
                    'skor' => $skorAkhir
                ];
            } else {
                $data = $request->only('skor');
            }
        }
        
        $log->update($data);
        return response()->json(['success' => true]);
    }

    public function destroyEvaluationLog($id)
    {
        $log = CatatanEvaluasi::findOrFail($id);
        $log->delete();
        return response()->json(['success' => true]);
    }

    public function getOnlineEvaluations($classId)
    {
        $evaluations = DB::table('catatan_evaluasi')
            ->where('id_mapel', $classId)
            ->where('tipe_ujian', 'Online')
            ->select('nama_evaluasi')
            ->distinct()
            ->pluck('nama_evaluasi');
            
        return response()->json($evaluations);
    }

    public function getEvaluationSubmissions(Request $request, $classId)
    {
        $evalName = $request->query('eval_name');
        
        $submissions = DB::table('catatan_evaluasi')
            ->join('users', 'catatan_evaluasi.id_user', '=', 'users.id')
            ->where('catatan_evaluasi.id_mapel', $classId)
            ->where('catatan_evaluasi.tipe_ujian', 'Online')
            ->where('catatan_evaluasi.nama_evaluasi', $evalName)
            ->select(
                'catatan_evaluasi.*',
                'users.name as student_name'
            )
            ->get();
            
        return response()->json($submissions);
    }
}
