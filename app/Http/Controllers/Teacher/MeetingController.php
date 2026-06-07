<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Mapel;
use App\Models\User;
use App\Notifications\KelasAkanMulai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class MeetingController extends Controller
{
    public function index()
    {
        $teacherId = Auth::user()->id;
        
        // Get all mapels for this teacher
        $mapels = Mapel::where('id_guru', $teacherId)->get();
        $mapelIds = $mapels->pluck('id_mapel');

        // Delete ended meetings based on WIB (+7)
        Meeting::where('waktu_selesai', '<', now()->addHours(7))->delete();

        $meetings = Meeting::whereIn('id_mapel', $mapelIds)
            ->with('mapel')
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        return view('teacher.meetings.index', compact('meetings', 'mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_mapel' => 'required|exists:mapel,id_mapel',
            'judul' => 'required|string|max:255',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        // Auto-generate Jitsi Meet link using a unique slug
        $meetLink = 'https://meet.jit.si/LPKSeishin-' . uniqid();

        $meeting = Meeting::create([
            'id_mapel' => $request->id_mapel,
            'judul' => $request->judul,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'meet_link' => $meetLink,
            'status' => 'scheduled',
        ]);

        // Send notification to all students in the batch
        $mapel = Mapel::with('batch')->find($request->id_mapel);
        if ($mapel && $mapel->batch) {
            $students = User::whereHas('studentBatches', function ($query) use ($mapel) {
                $query->where('student_list_batch.id_batch', $mapel->id_batch);
            })->get();

            $message = "Sensei telah menjadwalkan Video Conference: {$request->judul} pada " . \Carbon\Carbon::parse($request->waktu_mulai)->format('d M Y H:i');
            Notification::send($students, new KelasAkanMulai($mapel->batch, $message));
        }

        return redirect()->route('teacher.meetings.index')->with('success', 'Jadwal Video Conference berhasil dibuat!');
    }

    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);
        
        // Ensure this meeting belongs to the teacher's mapel
        if ($meeting->mapel->id_guru !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $meeting->delete();
        return redirect()->route('teacher.meetings.index')->with('success', 'Jadwal Video Conference berhasil dihapus!');
    }

    public function join($id)
    {
        $meeting = Meeting::findOrFail($id);
        
        // Ensure this meeting belongs to the teacher's mapel
        if ($meeting->mapel->id_guru !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('shared.video-conference', compact('meeting'));
    }
}
