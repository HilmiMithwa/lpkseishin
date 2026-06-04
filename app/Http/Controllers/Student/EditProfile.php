<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Student\EditProfileRequest;

class EditProfile extends Controller
{
    

    public function update(EditProfileRequest $request) 
    {
        $user = Auth::user();

        $validatedData = $request->validated();

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        }

        if ($request->filled('nomor_telepon')) {
            $validatedData['nomor_telepon'] = preg_replace('/[^0-9]/', '', $request->nomor_telepon);
        }

        $user->update($validatedData);

        return redirect()->route('students.profile')->with('success', 'Profil berhasil diperbarui');
    }
}
