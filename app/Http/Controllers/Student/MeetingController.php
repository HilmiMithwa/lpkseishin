<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all mapel IDs the student is enrolled in through active batches
        $enrolledMapelIds = $user->activeMapels()->pluck('id_mapel');

        $meetings = Meeting::whereIn('id_mapel', $enrolledMapelIds)
            ->with(['mapel', 'mapel.guru'])
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        return view('students.meetings.index', compact('meetings'));
    }

    public function join($id)
    {
        $user = Auth::user();
        $meeting = Meeting::findOrFail($id);
        
        // Verify the student has access to this meeting's mapel
        $hasAccess = $user->activeMapels()->where('id_mapel', $meeting->id_mapel)->exists();
        
        if (!$hasAccess) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        return view('shared.video-conference', compact('meeting'));
    }
}
