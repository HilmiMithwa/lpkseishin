<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();
        
        $assignedBatches = \App\Models\Batch::whereIn('id_batch', function($query) use ($teacher) {
            $query->select('id_batch')
                  ->from('mapel')
                  ->where('id_guru', $teacher->id);
        })->get();

        return view('teacher.profile', compact('assignedBatches'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'nomor_telepon' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
        ]);

        if ($request->filled('nomor_telepon')) {
            $validatedData['nomor_telepon'] = preg_replace('/[^0-9]/', '', $request->nomor_telepon);
        }

        $user->update($validatedData);

        return redirect()->route('teacher.profile')->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('teacher.profile')->with('success', 'Kata sandi berhasil diperbarui');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo_path);
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            
            $user->update([
                'profile_photo_path' => $path,
            ]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui');
    }

    public function destroyPhoto(Request $request)
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo_path);
            
            $user->update([
                'profile_photo_path' => null,
            ]);
        }

        return back()->with('success', 'Foto profil berhasil dihapus');
    }
}
