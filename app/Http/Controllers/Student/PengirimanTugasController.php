<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Student\SubmitPengirimanTugasRequest;
use App\Models\Pengiriman_Tugas;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class PengirimanTugasController extends Controller
{
    public function store(SubmitPengirimanTugasRequest $request, $id_mapel, $id_modul, $id_tugas)
    {
        $alreadySubmitted = Pengiriman_Tugas::where('id_tugas', $id_tugas)
            ->where('id_user', Auth::id())
            ->exists();

        if ($alreadySubmitted) {
            return back()->with('error', 'Kamu sudah mengumpulkan tugas ini.');
        }

        $task = Tugas::find($id_tugas);
        $status = 'dikirim';
        $disk = env('FILESYSTEM_DISK', 's3');

        if ($task && Carbon::now()->greaterThan(Carbon::parse($task->waktu_pengumpulan))) {
            $status = 'terlambat';
        }

        $filePath = null;
        if ($request->hasFile('task_files')) {
            $file = $request->file('task_files')[0];
            $originalName = $file->getClientOriginalName();
            $filename = str_replace(' ', '_', $originalName);
            $filePath = $file->storeAs('submissions', $filename, $disk);
        }

        $textContent = $request->input('text_content');
        if ($request->has('task_links') && is_array($request->input('task_links'))) {
            $links = $request->input('task_links');
            $linksStr = implode("\n", $links);
            if (!empty($textContent)) {
                $textContent .= "\n\nTautan Lampiran:\n" . $linksStr;
            } else {
                $textContent = "Tautan Lampiran:\n" . $linksStr;
            }
        }

        Pengiriman_Tugas::create([
            'text_content' => $textContent,
            'file_path' => $filePath,
            'submitted_at' => Carbon::now(),
            'status' => $status,
            'nilai' => null,
            'id_tugas' => $id_tugas,
            'id_user' => Auth::id(),
        ]);

        if ($task && $task->modul && $task->modul->mapel) {
            $guruId = $task->modul->mapel->id_guru;
            $guru = \App\Models\User::find($guruId);
            if ($guru) {
                $guru->notify(new \App\Notifications\TugasDikumpulkan(Auth::user(), $task));
            }
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan');
    }

    public function cancel($id_mapel, $id_modul, $id_tugas)
    {
        $disk = env('FILESYSTEM_DISK', 's3');
        $submission = Pengiriman_Tugas::where('id_tugas', $id_tugas)
            ->where('id_user', Auth::id())
            ->first();

        if (!$submission) {
            return back()->with('error', 'Tidak ada pengiriman tugas yang ditemukan untuk dibatalkan.');
        }

        // Hapus file dari storage jika ada
        if ($submission->file_path) {
            Storage::disk($disk)->delete($submission->file_path);
        }

        $submission->delete();

        return back()->with('success', 'Pengiriman tugas berhasil dibatalkan.');
    }

    public function download($id_pengiriman)
    {
        $submission = Pengiriman_Tugas::find($id_pengiriman);
        $disk = env('FILESYSTEM_DISK', 's3');

        if (!$submission) {
            abort(404);
        }

        // Authorization: allow owner or teachers (role_id == 3)
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        if ($user->id !== $submission->id_user && (int)$user->role_id !== 3) {
            abort(403);
        }

        if (!$submission->file_path) {
            abort(404);
        }

        
        if (!Storage::disk($disk)->exists($submission->file_path)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        return Storage::disk($disk)->download($submission->file_path, basename($submission->file_path));
    }
}
