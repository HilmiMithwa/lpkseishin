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
use App\Http\Controllers\Teacher\BatchController;
use App\Http\Controllers\Teacher\TugasController;



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
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/users/{id}/edit', function($id) {
        return view('admin.users.edit', ['id' => $id]);
    })->name('users.edit');

    Route::get('/payments', function() {
        return view('admin.payments.index');
    })->name('payments');

    Route::get('/batches', [\App\Http\Controllers\Admin\BatchController::class, 'index'])->name('batches');
    Route::post('/batches', [\App\Http\Controllers\Admin\BatchController::class, 'store'])->name('batches.store');
    Route::put('/batches/{id}', [\App\Http\Controllers\Admin\BatchController::class, 'update'])->name('batches.update');
    Route::delete('/batches/{id}', [\App\Http\Controllers\Admin\BatchController::class, 'destroy'])->name('batches.destroy');

    Route::get('/programs', function() {
        return view('admin.programs.index');
    })->name('programs');

    Route::get('/announcements', function() {
        return view('admin.announcements.index');
    })->name('announcements');
    
    Route::get('/profile', function() {
        return view('admin.profile');
    })->name('profile');
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

    Route::get('/students/enrolled', [\App\Http\Controllers\Student\StudentController::class, 'enrolled'])->name('students.enrolled');

    Route::get('/students/my-tasks', [StudentController::class, 'myTasks'])->name('students.tasks');

    Route::get('/students/vocabulary-mastery', [StudentController::class, 'vocabularyMastery'])->name('students.vocabulary-mastery');
    Route::get('/students/vocabulary-mastery/level/{id}', [StudentController::class, 'vocabularyLevel'])->name('students.vocabulary-level');
    Route::post('/students/vocabulary/{id_vocabulary}/toggle-mastered', [StudentController::class, 'toggleMastered'])->name('students.vocabulary.toggle-mastered');
    Route::post('/students/vocabulary/{id_vocabulary}/toggle-favorite', [StudentController::class, 'toggleFavorite'])->name('students.vocabulary.toggle-favorite');

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

    Route::get('/classes', [BatchController::class, 'index'])->name('classes');
    Route::get('/classes/{id_batch}', [BatchController::class, 'show'])->name('batch.show');
    Route::post('/classes/{id_batch}/add', [BatchController::class, 'storeClass'])->name('classes.store');

    Route::get('/subjects/{id_mapel}', [\App\Http\Controllers\Teacher\MapelController::class, 'show'])->name('subjects.show');
    Route::post('/subjects/modules', [\App\Http\Controllers\Teacher\MapelController::class, 'addModul'])->name('modules.store');

    Route::get('/modules/{id_modul}', [\App\Http\Controllers\Teacher\ModulController::class, 'showModule'])->name('modules.show');

    Route::get('/modules/{id_modul}/materials/create', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'create'])->name('materials.create');

    Route::post('/modules/{id_modul}/materials', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'store'])->name('materials.store');

    Route::get('/modules/{id_modul}/materials/{id_materi}', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'show'])->name('materials.show');

    Route::put('/modules/{id_modul}/materials/{id_materi}', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'update'])->name('materials.update');

    Route::delete('/modules/{id_modul}/materials/{id_materi}', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'destroy'])->name('materials.destroy');


    Route::get('/modules/{id_modul}/evaluations/create', function ($id_modul) {
        return view('teacher.evaluation-create', ['currentModuleId' => $id_modul]);
    })->name('evaluations.create');

    Route::get('/modules/{id_modul}/tasks/create', function ($id_modul) {
        return view('teacher.task-create', ['currentModuleId' => $id_modul]);
    })->name('tasks.create');

    Route::get('/modules/{id_modul}/tasks/{id_tugas}', function ($id_modul, $id_tugas) {
        return view('teacher.task-detail', ['currentModuleId' => $id_modul, 'currentTaskId' => $id_tugas]);
    })->name('tasks.show');

    Route::get('/vocabulary', [\App\Http\Controllers\Teacher\VocabularyController::class, 'index'])->name('vocabulary');
    Route::put('/vocabulary/level/{level}/update', [\App\Http\Controllers\Teacher\VocabularyController::class, 'updateLevel'])->name('vocabulary.level.update');
    Route::delete('/vocabulary/level/{level}', [\App\Http\Controllers\Teacher\VocabularyController::class, 'destroyLevel'])->name('vocabulary.level.destroy');

    Route::get('/vocabulary/level/{id}', function ($id) {
        $query = \App\Models\Vocabulary::where('level', $id)->orderBy('id_vocabulary', 'asc');
        
        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('kanji', 'ilike', "%{$search}%")
                  ->orWhere('furigana', 'ilike', "%{$search}%")
                  ->orWhere('romaji', 'ilike', "%{$search}%")
                  ->orWhere('meaning_id', 'ilike', "%{$search}%");
            });
        }
        
        if (request()->has('category') && request('category') != '') {
            $query->where('category', request('category'));
        }
        
        $words = $query->paginate(18)->appends(request()->query());
        
        return view('teacher.vocabulary-level', ['level_id' => $id, 'words' => $words]);
    })->name('vocabulary.level');

    Route::post('/vocabulary/level/{id}/store', [\App\Http\Controllers\Teacher\VocabularyController::class, 'store'])->name('vocabulary.store');
    Route::put('/vocabulary/{id}', [\App\Http\Controllers\Teacher\VocabularyController::class, 'update'])->name('vocabulary.update');
    Route::delete('/vocabulary/{id}', [\App\Http\Controllers\Teacher\VocabularyController::class, 'destroy'])->name('vocabulary.destroy');

    Route::get('/progress-report', function () {
        return view('teacher.progress-report');
    })->name('progress-report');

    Route::get('/assignments',[TugasController::class, 'show'])->name('assignments');
    Route::post('/assignments',[TugasController::class, 'createAssignment'])->name('assignments.store');
    // Preview: Grading Workspace
    Route::get('/assignments/{id}/grade', [TugasController::class, 'gradePage'])->name('assignments.grade');
    Route::post('/submissions/{id}/grade', [TugasController::class, 'gradeAssignment'])->name('assignments.grade.store');

    Route::get('/profile', function () {
        return view('teacher.profile');
    })->name('profile');
    Route::patch('/profile', [\App\Http\Controllers\Teacher\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Teacher\ProfileController::class, 'updatePassword'])->name('profile.password.update');
});



//buat ngetes API
Route::get('/vocabulary', [StudentController::class, 'getVocabulary']);

require __DIR__.'/auth.php';

// Route to download submission files (authenticated users)
Route::get('/submissions/{id_pengiriman}/download', [PengirimanTugasController::class, 'download'])
    ->name('submissions.download')
    ->middleware('auth');