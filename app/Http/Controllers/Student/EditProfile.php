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
        $user->update($validatedData);

        return view('student.profile')->with('success', 'Profil berhasil diperbarui');
    }


}
