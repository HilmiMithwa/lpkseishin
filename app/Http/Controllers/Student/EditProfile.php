<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Student\EditProfileRequest;

class EditProfile extends Controller
{
    public function index(EditProfileRequest $request) 
    {
        $user = Auth::user();
        return view('students.profile');
    }


}
