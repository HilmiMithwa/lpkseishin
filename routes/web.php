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
use App\Http\Controllers\Teacher\ProgressReportController;
use App\Http\Controllers\Teacher\TugasController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\SubjectDiscussionController;



Route::get('/', [SesiController::class, 'index']);

// Registration Landing Page
Route::get('/pendaftaran', function() {
    return view('registration-landing');
})->name('registration-landing');

// Registration Routes
Route::prefix('registration')->name('registration.')->group(function () {
    Route::get('/step1', [RegistrationController::class, 'step1'])->name('step1');
    Route::post('/step1', [RegistrationController::class, 'storeStep1'])->name('store-step1');
    
    Route::get('/step2', [RegistrationController::class, 'step2'])->name('step2');
    Route::post('/step2', [RegistrationController::class, 'storeStep2'])->name('store-step2');
    
    Route::get('/step3', [RegistrationController::class, 'step3'])->name('step3');
    Route::post('/step3', [RegistrationController::class, 'storeStep3'])->name('store-step3');
    
    Route::get('/step4', [RegistrationController::class, 'step4'])->name('step4');
    Route::post('/step4', [RegistrationController::class, 'storeStep4'])->name('store-step4');
    
    Route::get('/complete', [RegistrationController::class, 'complete'])->name('complete');
    Route::get('/success/{id}', [RegistrationController::class, 'success'])->name('success');
    Route::get('/clear', [RegistrationController::class, 'clearSession'])->name('clear');
});

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
    Route::post('/profile/photo', [\App\Http\Controllers\ProfilePhotoController::class, 'store'])->name('profile.photo.update');
    Route::delete('/profile/photo', [\App\Http\Controllers\ProfilePhotoController::class, 'destroy'])->name('profile.photo.destroy');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Dashboard Admin
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function(\Illuminate\Http\Request $request) {
        $year = $request->query('year', date('Y'));
        
        $enrollmentData = array_fill(0, 12, 0);
        $users = \App\Models\User::where('role_id', 2)
            ->whereYear('created_at', $year)
            ->get();
        foreach ($users as $user) {
            $month = $user->created_at->format('n') - 1;
            $enrollmentData[$month]++;
        }

        $total_siswa_aktif = \App\Models\User::where('role_id', 2)->whereRaw('LOWER(status) = ?', ['active'])->count();
        $batch_berjalan = \App\Models\Batch::whereRaw('LOWER(status) IN (?, ?)', ['active', 'pendaftaran'])->count();
        $total_sensei = \App\Models\User::where('role_id', 3)->count();
        $total_alumni = \App\Models\User::where('role_id', 2)->whereRaw('LOWER(status) = ?', ['completed'])->count();
        $siswa_berisiko = 4; // Dummy
        $tingkat_kelulusan = 94; // Dummy

        // Calculate Menunggu Pembayaran and Pendapatan Bulanan
        $activeStudents = \App\Models\User::where('role_id', 2)->whereRaw('LOWER(status) = ?', ['active'])->with('studentBatches')->get();
        $totalSppExpected = 0;
        foreach ($activeStudents as $student) {
            foreach ($student->studentBatches as $batch) {
                $totalSppExpected += $batch->spp_nominal;
            }
        }
        $totalSppPaid = \App\Models\Payment::whereIn('id_user', $activeStudents->pluck('id'))
                          ->where('status', 'lunas')
                          ->sum('amount');
        
        $menunggu_pembayaran = max(0, $totalSppExpected - $totalSppPaid);
        $pendapatan_bulanan = $totalSppExpected;

        $siswaMenungguPembayaranCount = 0;
        foreach ($activeStudents as $student) {
            $expected = $student->studentBatches->sum('spp_nominal');
            $paid = \App\Models\Payment::where('id_user', $student->id)->where('status', 'lunas')->sum('amount');
            if ($expected > $paid) {
                $siswaMenungguPembayaranCount++;
            }
        }

        $paymentData = [(int) $totalSppPaid, 0, (int) $menunggu_pembayaran];

        $dbYears = \App\Models\User::where('role_id', 2)
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->distinct()
            ->pluck('year')
            ->toArray();
            
        $currentYear = (int) date('Y');
        $generatedYears = [$currentYear - 2, $currentYear - 1, $currentYear, $currentYear + 1];
        
        $availableYears = array_unique(array_merge($generatedYears, $dbYears));
        rsort($availableYears);

        return view('admin.dashboard', compact(
            'enrollmentData', 
            'total_siswa_aktif', 
            'batch_berjalan', 
            'total_sensei', 
            'total_alumni', 
            'siswa_berisiko', 
            'tingkat_kelulusan', 
            'menunggu_pembayaran', 
            'pendapatan_bulanan',
            'siswaMenungguPembayaranCount',
            'paymentData',
            'year',
            'availableYears'
        ));
    })->name('dashboard');

    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');

    Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'adminIndex'])->name('payments');
    Route::post('/payments/{id}/verify', [\App\Http\Controllers\PaymentController::class, 'adminVerify'])->name('payments.verify');

    Route::get('/bank-accounts', [\App\Http\Controllers\Admin\BankAccountController::class, 'index'])->name('bank_accounts');
    Route::post('/bank-accounts', [\App\Http\Controllers\Admin\BankAccountController::class, 'store'])->name('bank_accounts.store');
    Route::put('/bank-accounts/{id}', [\App\Http\Controllers\Admin\BankAccountController::class, 'update'])->name('bank_accounts.update');
    Route::delete('/bank-accounts/{id}', [\App\Http\Controllers\Admin\BankAccountController::class, 'destroy'])->name('bank_accounts.destroy');

    Route::get('/batches', [\App\Http\Controllers\Admin\BatchController::class, 'index'])->name('batches');
    Route::post('/batches', [\App\Http\Controllers\Admin\BatchController::class, 'store'])->name('batches.store');
    Route::put('/batches/{id}', [\App\Http\Controllers\Admin\BatchController::class, 'update'])->name('batches.update');
    Route::delete('/batches/{id}', [\App\Http\Controllers\Admin\BatchController::class, 'destroy'])->name('batches.destroy');

    Route::get('/programs', [\App\Http\Controllers\Admin\ProgramController::class, 'index'])->name('programs');
    Route::post('/programs', [\App\Http\Controllers\Admin\ProgramController::class, 'store'])->name('programs.store');
    Route::put('/programs/{id}', [\App\Http\Controllers\Admin\ProgramController::class, 'update'])->name('programs.update');
    Route::delete('/programs/{id}', [\App\Http\Controllers\Admin\ProgramController::class, 'destroy'])->name('programs.destroy');

    Route::get('/announcements', function() {
        return view('admin.announcements.index');
    })->name('announcements');
    
    Route::get('/profile', function() {
        return view('admin.profile');
    })->name('profile');

    // Student Registrations
    Route::get('/registrations', [\App\Http\Controllers\Admin\RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{id}', [\App\Http\Controllers\Admin\RegistrationController::class, 'show'])->name('registrations.show');
    Route::post('/registrations/{id}/approve', [\App\Http\Controllers\Admin\RegistrationController::class, 'approve'])->name('registrations.approve');
    Route::put('/registrations/{id}/reject', [\App\Http\Controllers\Admin\RegistrationController::class, 'reject'])->name('registrations.reject');
    Route::delete('/registrations/{id}', [\App\Http\Controllers\Admin\RegistrationController::class, 'destroy'])->name('registrations.destroy');
});

//Dashboard Siswa
Route::middleware(['auth', 'checkRole:siswa'])->group(function () {
    Route::get('/students/dashboard', [StudentController::class, 'index'])->name('students.dashboard');
    
    Route::get('/students/subjects/{id_mapel}', [MapelController::class, 'showProgress'])->name('subjects.show');

    Route::get('/students/subjects/{id_mapel}/modules/{id_modul}', [ModulController::class, 'showModule'])->name('modules.show');

    Route::get('/students/subjects/{id_mapel}/modules/{id_modul}/evaluations/{id}/start', [StudentController::class, 'showEvaluation'])->name('evaluations.start');

    Route::post('/students/subjects/{id_mapel}/modules/{id_modul}/evaluations/{id}/submit', [StudentController::class, 'submitEvaluation'])->name('evaluations.submit');

    Route::get('/students/evaluations/result', function () {
        return view('students.evaluation-result');
    })->name('students.evaluation-result');

    // rute detail materi
    Route::get('/students/subjects/{id_mapel}/modules/{id_modul}/materials/{id_materi}', [BahanAjarController::class, 'showMaterial'])->name('materials.show');

    // rute download materi
    Route::get('/students/materials/{id_materi}/download', [BahanAjarController::class, 'downloadMaterial'])->name('materials.download');

    //mark materi sebagai selesai (update progress)
    Route::post('/students/materials/{id_materi}/complete', [BahanAjarController::class, 'completeMaterial'])->name('materials.complete');

    // Diskusi materi (chat) - Student
    Route::get('/students/subjects/{id}/discussions', [SubjectDiscussionController::class, 'index'])->name('students.discussions.index');
    Route::post('/students/subjects/{id}/discussions', [SubjectDiscussionController::class, 'store'])->name('students.discussions.store');
    Route::get('/students/subjects/{id}/discussions/poll/{lastId}', [SubjectDiscussionController::class, 'poll'])->name('students.discussions.poll');

    Route::get('/students/subjects/{id_mapel}/modules/{id_modul}/tasks/{id_tugas}', [StudentController::class, 'showTask'])->name('tasks.show');

    Route::post('/students/subjects/{id_mapel}/modules/{id_modul}/tasks/{id_tugas}/submit', [PengirimanTugasController::class, 'store'])->name('tasks.submit');

    Route::post('/students/subjects/{id_mapel}/modules/{id_modul}/tasks/{id_tugas}/cancel', [PengirimanTugasController::class, 'cancel'])->name('tasks.cancel');

    Route::get('/students/enrolled', [\App\Http\Controllers\Student\StudentController::class, 'enrolled'])->name('students.enrolled');

    Route::get('/students/my-tasks', [StudentController::class, 'myTasks'])->name('students.tasks');
    Route::get('/students/tasks/{id_tugas}/download', [StudentController::class, 'downloadTaskAttachment'])->name('students.tasks.download');

    Route::get('/students/vocabulary-mastery', [StudentController::class, 'vocabularyMastery'])->name('students.vocabulary-mastery');
    Route::get('/students/vocabulary-mastery/favorites', [StudentController::class, 'vocabularyFavorites'])->name('students.vocabulary-favorites');
    Route::get('/students/vocabulary-mastery/level/{id}', [StudentController::class, 'vocabularyLevel'])->name('students.vocabulary-level');
    Route::post('/students/vocabulary/{id_vocabulary}/toggle-mastered', [StudentController::class, 'toggleMastered'])->name('students.vocabulary.toggle-mastered');
    Route::post('/students/vocabulary/{id_vocabulary}/toggle-favorite', [StudentController::class, 'toggleFavorite'])->name('students.vocabulary.toggle-favorite');

    Route::get('/students/profile', function () {
        return view('students.profile', ['userData' => auth()->user()]);
    })->name('students.profile');

    Route::patch('/students/profile', [EditProfile::class, 'update'])->name('students.profile.update');

    Route::get('/students/payment', [\App\Http\Controllers\PaymentController::class, 'studentIndex'])->name('students.payment');
    Route::post('/students/payment/store', [\App\Http\Controllers\PaymentController::class, 'studentStore'])->name('students.payment.store');
    Route::get('/students/invoice', [\App\Http\Controllers\PaymentController::class, 'studentInvoice'])->name('students.invoice');
    Route::get('/students/invoice/{id}', [\App\Http\Controllers\PaymentController::class, 'historyInvoice'])->name('students.invoice.history');

    Route::get('/students/meetings', [\App\Http\Controllers\Student\MeetingController::class, 'index'])->name('students.meetings.index');
    Route::get('/students/meetings/{id}/join', [\App\Http\Controllers\Student\MeetingController::class, 'join'])->name('students.meetings.join');
    
    Route::post('/students/notifications/read', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('students.notifications.read');

});

//Dashboard Guru
Route::middleware(['auth', 'checkRole:guru'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

    Route::get('/meetings', [\App\Http\Controllers\Teacher\MeetingController::class, 'index'])->name('meetings.index');
    Route::post('/meetings', [\App\Http\Controllers\Teacher\MeetingController::class, 'store'])->name('meetings.store');
    Route::delete('/meetings/{id}', [\App\Http\Controllers\Teacher\MeetingController::class, 'destroy'])->name('meetings.destroy');
    Route::get('/meetings/{id}/join', [\App\Http\Controllers\Teacher\MeetingController::class, 'join'])->name('meetings.join');

    Route::get('/classes', [BatchController::class, 'index'])->name('classes');
    Route::get('/classes/{id_batch}', [BatchController::class, 'show'])->name('batch.show');
    Route::post('/classes/{id_batch}/add', [BatchController::class, 'storeClass'])->name('classes.store');
    Route::put('/students/{id_studentbatch}/status', [BatchController::class, 'updateStudentStatus'])->name('students.status.update');

    Route::get('/subjects/{id_mapel}', [\App\Http\Controllers\Teacher\MapelController::class, 'show'])->name('subjects.show');
    Route::put('/subjects/{id_mapel}', [\App\Http\Controllers\Teacher\MapelController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{id_mapel}', [\App\Http\Controllers\Teacher\MapelController::class, 'destroy'])->name('subjects.destroy');
    Route::post('/subjects/modules', [\App\Http\Controllers\Teacher\MapelController::class, 'addModul'])->name('modules.store');
    Route::delete('/subjects/modules/{id_modul}', [\App\Http\Controllers\Teacher\MapelController::class, 'deleteModul'])->name('modules.destroy');
    Route::post('/subjects/{id_mapel}/announcements', [\App\Http\Controllers\Teacher\MapelController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::delete('/announcements/{id}', [\App\Http\Controllers\Teacher\MapelController::class, 'destroyAnnouncement'])->name('announcements.destroy');

    Route::get('/modules/{id_modul}', [\App\Http\Controllers\Teacher\ModulController::class, 'showModule'])->name('modules.show');
    Route::put('/modules/{id_modul}', [\App\Http\Controllers\Teacher\ModulController::class, 'update'])->name('modules.update');

    Route::get('/modules/{id_modul}/materials/create', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'create'])->name('materials.create');

    Route::post('/modules/{id_modul}/materials', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'store'])->name('materials.store');

    Route::get('/modules/{id_modul}/materials/{id_materi}', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'show'])->name('materials.show');

    Route::get('/modules/{id_modul}/materials/{id_materi}/edit', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'edit'])->name('materials.edit');

    Route::put('/modules/{id_modul}/materials/{id_materi}', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'update'])->name('materials.update');

    Route::delete('/modules/{id_modul}/materials/{id_materi}', [\App\Http\Controllers\Teacher\BahanAjarController::class, 'destroy'])->name('materials.destroy');

    // Diskusi materi (chat) - Teacher
    Route::get('/subjects/{id}/discussions', [SubjectDiscussionController::class, 'index'])->name('teacher.discussions.index');
    Route::post('/subjects/{id}/discussions', [SubjectDiscussionController::class, 'store'])->name('teacher.discussions.store');
    Route::get('/subjects/{id}/discussions/poll/{lastId}', [SubjectDiscussionController::class, 'poll'])->name('teacher.discussions.poll');

    Route::get('/modules/{id_modul}/evaluations/create', [\App\Http\Controllers\Teacher\EvaluasiController::class, 'create'])->name('evaluations.create');
    Route::post('/modules/{id_modul}/evaluations', [\App\Http\Controllers\Teacher\EvaluasiController::class, 'store'])->name('evaluations.store');
    Route::get('/modules/{id_modul}/evaluations/{id}', [\App\Http\Controllers\Teacher\EvaluasiController::class, 'show'])->name('evaluations.show');
    Route::delete('/modules/{id_modul}/evaluations/{id}', [\App\Http\Controllers\Teacher\EvaluasiController::class, 'destroy'])->name('evaluations.destroy');

    // Tugas (Tasks) CRUD
    Route::get('/modules/{id_modul}/tasks/create', [TugasController::class, 'create'])->name('tasks.create');
    Route::post('/modules/{id_modul}/tasks', [TugasController::class, 'store'])->name('tasks.store');
    Route::get('/modules/{id_modul}/tasks/{id_tugas}', [TugasController::class, 'showTask'])->name('tasks.show');
    Route::get('/modules/{id_modul}/tasks/{id_tugas}/edit', [TugasController::class, 'edit'])->name('tasks.edit');
    Route::put('/modules/{id_modul}/tasks/{id_tugas}', [TugasController::class, 'update'])->name('tasks.update');
    Route::delete('/modules/{id_modul}/tasks/{id_tugas}', [TugasController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/modules/{id_modul}/tasks/{id_tugas}/grade', [TugasController::class, 'gradeTaskSubmission'])->name('tasks.grade');

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
        
        $words = $query->paginate(18)->appends(request()->except(['open_first', 'open_last']));
        
        return view('teacher.vocabulary-level', ['level_id' => $id, 'words' => $words]);
    })->name('vocabulary.level');

    Route::get('/progress-report', [ProgressReportController::class, 'index'])->name('progress-report');
    Route::get('/progress-report/student/{id_user}/mapel/{id_mapel}', [ProgressReportController::class, 'getStudentDetails'])->name('progress-report.student-details');
    Route::post('/progress-report/weekly-log', [ProgressReportController::class, 'storeWeeklyLog'])->name('progress-report.weekly-log.store');
    Route::put('/progress-report/weekly-log/{id}', [ProgressReportController::class, 'updateWeeklyLog'])->name('progress-report.weekly-log.update');
    Route::delete('/progress-report/weekly-log/{id}', [ProgressReportController::class, 'destroyWeeklyLog'])->name('progress-report.weekly-log.destroy');
    Route::post('/progress-report/evaluation-log', [ProgressReportController::class, 'storeEvaluationLog'])->name('progress-report.evaluation-log.store');
    Route::put('/progress-report/evaluation-log/{id}', [ProgressReportController::class, 'updateEvaluationLog'])->name('progress-report.evaluation-log.update');
    Route::delete('/progress-report/evaluation-log/{id}', [ProgressReportController::class, 'destroyEvaluationLog'])->name('progress-report.evaluation-log.destroy');
    Route::get('/progress-report/online-evaluations/{classId}', [ProgressReportController::class, 'getOnlineEvaluations'])->name('progress-report.online-evaluations');
    Route::get('/progress-report/online-submissions/{classId}', [ProgressReportController::class, 'getEvaluationSubmissions'])->name('progress-report.online-submissions');
    Route::post('/vocabulary/level/store', [\App\Http\Controllers\Teacher\VocabularyController::class, 'storeLevel'])->name('vocabulary.level.store');
    Route::post('/vocabulary/level/{id}/store', [\App\Http\Controllers\Teacher\VocabularyController::class, 'store'])->name('vocabulary.store');
    Route::put('/vocabulary/{id}', [\App\Http\Controllers\Teacher\VocabularyController::class, 'update'])->name('vocabulary.update');
    Route::delete('/vocabulary/{id}', [\App\Http\Controllers\Teacher\VocabularyController::class, 'destroy'])->name('vocabulary.destroy');


    Route::get('/assignments',[TugasController::class, 'show'])->name('assignments');
    Route::post('/assignments',[TugasController::class, 'createAssignment'])->name('assignments.store');
    Route::put('/assignments/{id}',[TugasController::class, 'updateAssignment'])->name('assignments.update');
    Route::delete('/assignments/{id}',[TugasController::class, 'destroyAssignment'])->name('assignments.destroy');
    // Preview: Grading Workspace
    Route::get('/assignments/{id}/grade', [TugasController::class, 'gradePage'])->name('assignments.grade');
    Route::post('/submissions/{id}/grade', [TugasController::class, 'gradeAssignment'])->name('assignments.grade.store');

    Route::get('/profile', [\App\Http\Controllers\Teacher\ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [\App\Http\Controllers\Teacher\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Teacher\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::post('/notifications/read', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read');
});



//buat ngetes API
Route::get('/vocabulary', [StudentController::class, 'getVocabulary']);

require __DIR__.'/auth.php';

// Route to download submission files (authenticated users)
Route::get('/submissions/{id_pengiriman}/download', [PengirimanTugasController::class, 'download'])
    ->middleware('auth')
    ->name('submissions.download');