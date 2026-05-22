<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\StudentController;


Route::get('/', [SesiController::class, 'index']);

Route::get('/dashboard', function() {

    $role = (int) Auth::user()->role_id;

    if ($role === 1) {
        return redirect()->route('admin.dashboard');
    }

    if ($role === 2) {
        return redirect()->route('students.dashboard');
    }

    if ($role === 3) {
        return redirect()->route('teacher.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Dashboard Admin
Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/admin/dashboard', function() {
        return view ('admin.dashboard');
    })->name('admin.dashboard');
});

//Dashboard Siswa
Route::middleware(['auth', 'checkRole:siswa'])->group(function () {
    Route::get('/students/dashboard', [StudentController::class, 'index'])->name('students.dashboard');
    
    Route::get('/students/subjects/{id_mapel}', [StudentController::class, 'show'])->name('subjects.show');

    Route::get('/students/subjects/{id_mapel}/modules/{id_modul}', [StudentController::class, 'showModule'])->name('modules.show');

    //RUTE DUMMY INI UNTUK TESTING VISUAL
    Route::get('/students/evaluations/{id}/start', function() { return 'Rute Ujian'; })->name('evaluations.start');

    // rute detail materi
    Route::get('/students/subjects/{id_mapel}/modules/{id_modul}/materials/{id_materi}', [StudentController::class, 'showMaterial'])->name('materials.show');

    //mark materi sebagai selesai (update progress)
    Route::post('/students/materials/{id_materi}/complete', [StudentController::class, 'completeMaterial'])->name('materials.complete');
});

//Dashboard Guru
Route::middleware(['auth', 'checkRole:guru'])->group(function () {
    Route::get('/teacher/dashboard', function() {
        return view ('teacher.dashboard');
    })->name('teacher.dashboard');
});


//buat ngetes API
Route::get('/vocabulary', [StudentController::class, 'getVocabulary']);


// Tugas detail
Route::get('/students/subjects/{id_mapel}/modules/{id_modul}/tasks/{id_tugas}', [StudentController::class, 'showTask'])->name('tasks.show');

// Aksi tugas (submit & cancel) 
Route::post('/students/subjects/{id_mapel}/modules/{id_modul}/tasks/{id_tugas}/submit', [StudentController::class, 'submitTask'])->name('tasks.submit');
Route::post('/students/subjects/{id_mapel}/modules/{id_modul}/tasks/{id_tugas}/cancel', [StudentController::class, 'cancelTask'])->name('tasks.cancel');



require __DIR__.'/auth.php';


