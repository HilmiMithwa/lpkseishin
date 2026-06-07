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

        // If class is selected, get progress for enrolled students
        if ($selectedClassId) {
            $selectedClassName = $classes->where('id_mapel', $selectedClassId)->first()->nama_mapel ?? '';
            $enrollments = Enrollment_List::where('id_mapel', $selectedClassId)->pluck('id_user');
            $studentUsers = User::whereIn('id', $enrollments)->get();

            $totalMaterial = BahanAjar::whereHas('modul', function ($q) use ($selectedClassId) {
                $q->where('id_mapel', $selectedClassId);
            })->count();

            $totalTask = Tugas::whereHas('modul', function ($q) use ($selectedClassId) {
                $q->where('id_mapel', $selectedClassId);
            })->count();

            $totalItems = $totalMaterial + $totalTask;

            $totalRataTugasAll = 0;
            $totalProgressAll = 0;

            foreach ($studentUsers as $student) {
                // Completed materials
                $completedMaterial = DB::table('bahan_ajar_progress')
                    ->join('bahan_ajar', 'bahan_ajar.id_bahan_ajar', '=', 'bahan_ajar_progress.id_bahan_ajar')
                    ->join('modul', 'modul.id_modul', '=', 'bahan_ajar.id_modul')
                    ->where('modul.id_mapel', $selectedClassId)
                    ->where('bahan_ajar_progress.id_user', $student->id)
                    ->where('bahan_ajar_progress.is_complete', DB::raw('true'))
                    ->count();

                // Completed tasks
                $completedTask = Pengiriman_Tugas::join('tugas', 'tugas.id_tugas', '=', 'pengiriman_tugas.id_tugas')
                    ->join('modul', 'modul.id_modul', '=', 'tugas.id_modul')
                    ->where('modul.id_mapel', $selectedClassId)
                    ->where('pengiriman_tugas.id_user', $student->id)
                    ->whereIn('pengiriman_tugas.status', ['dikirim', 'Sudah Dinilai'])
                    ->count();

                $completedItems = $completedMaterial + $completedTask;
                $progressPercentage = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;

                // Task average
                $taskGrades = Pengiriman_Tugas::join('tugas', 'tugas.id_tugas', '=', 'pengiriman_tugas.id_tugas')
                    ->join('modul', 'modul.id_modul', '=', 'tugas.id_modul')
                    ->where('modul.id_mapel', $selectedClassId)
                    ->where('pengiriman_tugas.id_user', $student->id)
                    ->where('pengiriman_tugas.status', 'Sudah Dinilai')
                    ->avg('pengiriman_tugas.nilai');

                $taskAverage = $taskGrades ? round($taskGrades) : 0;

                // Status
                $status = 'Aktif';
                if ($progressPercentage == 100) {
                    $status = 'Selesai';
                } elseif ($progressPercentage == 0) {
                    $status = 'Tidak Aktif';
                }

                if ($progressPercentage < 50) {
                    $warningCount++;
                }

                $students->push((object)[
                    'user_id' => $student->id,
                    'id' => '012025' . str_pad($student->id, 3, '0', STR_PAD_LEFT),
                    'name' => $student->name,
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=random',
                    'progress_modul' => $progressPercentage,
                    'rata_rata_tugas' => $taskAverage,
                    'nilai_evaluasi' => '-',
                    'status' => $status
                ]);

                $totalRataTugasAll += $taskAverage;
                $totalProgressAll += $progressPercentage;
            }

            $studentCount = $students->count();
            if ($studentCount > 0) {
                $avgClass = round($totalRataTugasAll / $studentCount);
                $avgProgress = round($totalProgressAll / $studentCount);
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
            'skor' => 'required|integer|min:0|max:100',
        ]);

        CatatanEvaluasi::create($request->all());

        return response()->json(['success' => true]);
    }

    public function updateEvaluationLog(Request $request, $id)
    {
        $log = CatatanEvaluasi::findOrFail($id);
        $log->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroyEvaluationLog($id)
    {
        $log = CatatanEvaluasi::findOrFail($id);
        $log->delete();
        return response()->json(['success' => true]);
    }
}
