<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // Max 5MB
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($user->profile_photo_path) {
                Storage::disk('s3')->delete($user->profile_photo_path);
                Storage::disk('public')->delete($user->profile_photo_path); // Cleanup old public disk just in case
            }

            // Upload new photo to S3
            $path = $request->file('photo')->store('profile-photos', 's3');
            
            $user->update([
                'profile_photo_path' => $path,
            ]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::disk('s3')->delete($user->profile_photo_path);
            Storage::disk('public')->delete($user->profile_photo_path); // Cleanup old public disk just in case
            
            $user->update([
                'profile_photo_path' => null,
            ]);
        }

        return back()->with('success', 'Foto profil berhasil dihapus');
    }
}
