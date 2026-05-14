<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Modul;


class ModulController extends Controller
{
    public function index()
    {
        $moduls = Modul::with('mapel')->latest()->get();
    }
}
