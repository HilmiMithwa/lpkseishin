<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modul;
use App\Http\Requests\Teacher\StoreModulRequest;

class ModulController extends Controller
{
    public function store(StoreModulRequest $request)
    {
        Modul::create($request->validated());
        return redirect()->route('teacher.dashboardmodul')->with('success', 'Modul Berhasil ditambahkan!'); //buat routingan dashboard guru ini aku serahin lagi ke kamu zan. Ini sebagai contoh doang
    }


}
