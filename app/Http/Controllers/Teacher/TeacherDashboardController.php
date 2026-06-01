<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Mapel;
use App\Models\Pengiriman_Tugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();

        $teacherSubjects = Mapel::where('id_guru', $teacher->id)
            ->with('batch')
            ->withCount([
                'modul',
                'enrollmentAccess as students_count' => function ($q) {
                    $q->select(DB::raw('count(distinct id_user)'));
                },
            ])
            ->get();

        $activeClassesCount = $teacherSubjects->where('status', 'active')->count();

        $totalStudentsCount = DB::table('enrollment_access')
            ->whereIn('id_mapel', $teacherSubjects->pluck('id_mapel'))
            ->distinct('id_user')
            ->count('id_user');

        $pendingTasks = Pengiriman_Tugas::where('status', 'dikirim')
            ->with([
                'user:id,name',
                'tugas.rps.modul.mapel',
            ])
            ->whereHas('tugas.rps.modul.mapel', function ($q) use ($teacher) {
                $q->where('id_guru', $teacher->id);
            })
            ->latest('submitted_at')
            ->take(10)
            ->get();

        $pendingTasks->each(function ($task) {
            $task->batch  = optional($task->tugas->rps->modul->mapel)->batch;
            $task->modul  = $task->tugas->rps->modul ?? null;
            $task->student = $task->user;
        });

        $needReviewCount = $pendingTasks->count();

        $todaySchedules = Jadwal::where('id_guru', $teacher->id)->get();
        $todayScheduleCount = $todaySchedules->count();

        $notificationCount = $needReviewCount;

        return view('teacher.dashboard', compact(
            'teacher',
            'teacherSubjects',
            'activeClassesCount',
            'totalStudentsCount',
            'pendingTasks',
            'needReviewCount',
            'todaySchedules',
            'todayScheduleCount',
            'notificationCount'
        ));
    }
}