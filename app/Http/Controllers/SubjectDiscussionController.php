<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectDiscussion;
use Illuminate\Support\Facades\Auth;

class SubjectDiscussionController extends Controller
{
    /**
     * Get all discussions for a subject
     */
    public function index($id_mapel)
    {
        $discussions = SubjectDiscussion::with('user')
            ->where('id_mapel', $id_mapel)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return $this->formatMessage($msg);
            });

        return response()->json($discussions);
    }

    /**
     * Store a new discussion message
     */
    public function store(Request $request, $id_mapel)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $discussion = SubjectDiscussion::create([
            'id_mapel' => $id_mapel,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        $discussion->load('user');

        return response()->json($this->formatMessage($discussion), 201);
    }

    /**
     * Poll for new messages after a given ID
     */
    public function poll($id_mapel, $lastId)
    {
        $discussions = SubjectDiscussion::with('user')
            ->where('id_mapel', $id_mapel)
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return $this->formatMessage($msg);
            });

        return response()->json($discussions);
    }

    /**
     * Format a message for JSON response
     */
    private function formatMessage($msg)
    {
        // Check if user is a guru (role_id = 3 for guru)
        $isGuru = $msg->user && $msg->user->role_id == 3;

        return [
            'id' => $msg->id,
            'user_id' => $msg->user_id,
            'user_name' => $msg->user->name ?? 'Unknown',
            'user_photo' => $msg->user->profile_photo_path ?? null,
            'message' => $msg->message,
            'is_guru' => $isGuru,
            'is_own' => $msg->user_id == Auth::id(),
            'created_at' => $msg->created_at->format('H:i'),
            'created_at_full' => $msg->created_at->translatedFormat('d M Y, H:i'),
        ];
    }
}
