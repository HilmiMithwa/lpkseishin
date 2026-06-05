<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\ModulController;
use App\Http\Controllers\Student\BahanAjarController;
use App\Http\Controllers\Student\PengirimanTugasController;
use App\Http\Controllers\Student\MapelController;
use App\Http\Controllers\Student\EditProfile;
use App\Http\Controllers\Teacher\TeacherDashboardController;


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
    
    Route::get('/students/subjects/{id_mapel}', [MapelController::class, 'showProgress'])->name('subjects.show');

    Route::get('/students/subjects/{id_mapel}/modules/{id_modul}', [ModulController::class, 'showModule'])->name('modules.show');

    Route::get('/students/subjects/{id_mapel}/modules/{id_modul}/evaluations/{id}/start', [StudentController::class, 'showEvaluation'])->name('evaluations.start');

    Route::get('/students/evaluations/result', function () {
        return view('students.evaluation-result');
    })->name('students.evaluation-result');

    // rute detail materi
    Route::get('/students/subjects/{id_mapel}/modules/{id_modul}/materials/{id_materi}', [BahanAjarController::class, 'showMaterial'])->name('materials.show');

    //mark materi sebagai selesai (update progress)
    Route::post('/students/materials/{id_materi}/complete', [BahanAjarController::class, 'completeMaterial'])->name('materials.complete');

    Route::get('/students/subjects/{id_mapel}/modules/{id_modul}/tasks/{id_tugas}', [StudentController::class, 'showTask'])->name('tasks.show');

    Route::post('/students/subjects/{id_mapel}/modules/{id_modul}/tasks/{id_tugas}/submit', [PengirimanTugasController::class, 'store'])->name('tasks.submit');

    Route::post('/students/subjects/{id_mapel}/modules/{id_modul}/tasks/{id_tugas}/cancel', [PengirimanTugasController::class, 'cancel'])->name('tasks.cancel');

    Route::get('/students/enrolled', function () {
        return view('students.enrolled');
    })->name('students.enrolled');

    Route::get('/students/my-tasks', [StudentController::class, 'myTasks'])->name('students.tasks');

    Route::get('/students/vocabulary-mastery', function () {
        // Mengecek apakah tabel daily_words tersedia di database menggunakan Schema bawaan Laravel
        $dailyWord = \Illuminate\Support\Facades\Schema::hasTable('daily_words')
            ? \Illuminate\Support\Facades\DB::table('daily_words')->inRandomOrder()->first()
            : null;

        // Kirim data dailyWord asli hasil query ke dalam view agar dibaca oleh Blade
        return view('students.vocabulary-mastery', compact('dailyWord'));
    })->name('students.vocabulary-mastery');

    Route::get('/students/vocabulary-mastery/level/{id}', function ($id) {
        return view('students.vocabulary-level', ['level_id' => $id]);
    })->name('students.vocabulary-level');

    Route::get('/students/profile', function () {
        return view('students.profile', ['userData' => auth()->user()]);
    })->name('students.profile');

    Route::patch('/students/profile', [EditProfile::class, 'update'])->name('students.profile.update');

    Route::get('/students/payment', function () {
        return view('students.payment');
    })->name('students.payment');
});

//Dashboard Guru
Route::middleware(['auth', 'checkRole:guru'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

    Route::get('/classes', function () {
        return view('teacher.classes');
    })->name('classes');

    Route::get('/classes/{id_batch}', function ($id_batch) {
        return view('teacher.batch-detail');
    })->name('batch.show');

    Route::get('/subjects/{id_mapel}', function ($id_mapel) {
        return view('teacher.class-detail');
    })->name('subjects.show');

    Route::get('/modules/{id_modul}', function ($id_modul) {
        return view('teacher.module-detail');
    })->name('modules.show');

    Route::get('/modules/{id_modul}/materials/create', function ($id_modul) {
        return view('teacher.material-create', ['currentModuleId' => $id_modul]);
    })->name('materials.create');

    Route::get('/modules/{id_modul}/materials/{id_materi}', function ($id_modul, $id_materi) {
        return view('teacher.material-detail', ['currentModuleId' => $id_modul, 'id_materi' => $id_materi]);
    })->name('materials.show');

    Route::get('/modules/{id_modul}/evaluations/create', function ($id_modul) {
        return view('teacher.evaluation-create', ['currentModuleId' => $id_modul]);
    })->name('evaluations.create');

    Route::get('/modules/{id_modul}/tasks/create', function ($id_modul) {
        return view('teacher.task-create', ['currentModuleId' => $id_modul]);
    })->name('tasks.create');

    Route::get('/modules/{id_modul}/tasks/{id_tugas}', function ($id_modul, $id_tugas) {
        return view('teacher.task-detail', ['currentModuleId' => $id_modul, 'currentTaskId' => $id_tugas]);
    })->name('tasks.show');

    Route::get('/vocabulary', function () {
        return view('teacher.vocabulary');
    })->name('vocabulary');

    Route::get('/vocabulary/level/{id}', function ($id) {
        return view('teacher.vocabulary-level', ['level_id' => $id]);
    })->name('vocabulary.level');

    Route::get('/progress-report', function () {
        return view('teacher.progress-report');
    })->name('progress-report');

    Route::get('/assignments', function () {
        return view('teacher.assignments');
    })->name('assignments');
    
    // Preview: Grading Workspace
    Route::get('/assignments/grade', function () {
        return view('teacher.grade-submission');
    })->name('assignments.grade');

    Route::get('/profile', function () {
        return view('teacher.profile');
    })->name('profile');
});



//buat ngetes API
Route::get('/vocabulary', [StudentController::class, 'getVocabulary']);

require __DIR__.'/auth.php';


