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

        $activeClassesCount = $teacherSubjects->where('status', 'Aktif')->count();

        $totalStudentsCount = DB::table('enrollment_access')
            ->whereIn('id_mapel', $teacherSubjects->pluck('id_mapel'))
            ->distinct('id_user')
            ->count('id_user');

        $needReviewCount = Pengiriman_Tugas::where('status', 'dikirim')
            ->whereHas('tugas.modul.mapel', function ($q) use ($teacher) {
                $q->where('id_guru', $teacher->id);
            })
            ->count();

        $pendingTasks = Pengiriman_Tugas::where('status', 'dikirim')
            ->with([
                'user:id,name',
                'tugas.modul.mapel.batch',
            ])
            ->whereHas('tugas.modul.mapel', function ($q) use ($teacher) {
                $q->where('id_guru', $teacher->id);
            })
            ->latest('submitted_at')
            ->take(10)
            ->get();

        $pendingTasks->each(function ($task) {
            $task->batch  = optional($task->tugas->modul->mapel)->batch;
            $task->modul  = $task->tugas->modul ?? null;
            $task->student = $task->user;
        });

        $indonesianDays = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu'
        ];
        
        $todayEnglish = \Carbon\Carbon::now()->format('l');
        $todayIndonesian = $indonesianDays[$todayEnglish];
        
        $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        $todaySchedules = collect();
        
        foreach ($teacherSubjects as $subject) {
            if ($subject->status === 'Aktif') {
                $batch = $subject->batch;
                if ($batch && $batch->jadwal) {
                    $isToday = false;
                    $jadwalStr = $batch->jadwal;
                    
                    if (str_contains($jadwalStr, '-')) {
                        $parts = array_map('trim', explode('-', $jadwalStr));
                        if (count($parts) == 2) {
                            $startDayIndex = array_search($parts[0], $daysOfWeek);
                            $endDayIndex = array_search($parts[1], $daysOfWeek);
                            $todayIndex = array_search($todayIndonesian, $daysOfWeek);
                            
                            if ($startDayIndex !== false && $endDayIndex !== false && $todayIndex !== false) {
                                if ($startDayIndex <= $endDayIndex) {
                                    $isToday = ($todayIndex >= $startDayIndex && $todayIndex <= $endDayIndex);
                                } else { 
                                    $isToday = ($todayIndex >= $startDayIndex || $todayIndex <= $endDayIndex);
                                }
                            }
                        }
                    } else if (str_contains(strtolower($jadwalStr), strtolower($todayIndonesian))) {
                        $isToday = true;
                    }
                    
                    if ($isToday) {
                        $todaySchedules->push((object)[
                            'id_mapel' => $subject->id_mapel,
                            'judul_pertemuan' => $subject->nama_mapel,
                            'lokasi_pertemuan' => $batch->nama,
                            'start_time' => $batch->jam_mulai ?? '08:00:00',
                            'end_time' => $batch->jam_selesai ?? '10:00:00',
                        ]);
                    }
                }
            }
        }
        
        // Sort by start_time
        $todaySchedules = $todaySchedules->sortBy('start_time')->values();
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