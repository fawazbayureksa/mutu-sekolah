<?php

use App\Http\Controllers\Admin\AdminValidationController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AssessmentAnswerController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\InstrumentController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Admin\SubmissionV2Controller;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicInstrumentController;
use App\Http\Controllers\PublicInstrumentV2Controller;
use App\Http\Controllers\SubmissionUpdateController;
use App\Http\Controllers\SubmissionV2UpdateController;
use App\Http\Controllers\Verifier\VerifierDashboardController;
use App\Http\Controllers\Verifier\VerifierSubmissionController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', fn () => view('landing'))->name('landing');

Route::get('/instrumen', [PublicInstrumentController::class, 'index'])
    ->name('instrument.form');

Route::post('/instrumen', [PublicInstrumentController::class, 'store'])
    ->name('instrument.submit');

Route::get('/instrumen/v2', [PublicInstrumentV2Controller::class, 'index'])
    ->name('instrument.v2.form');

Route::post('/instrumen/v2', [PublicInstrumentV2Controller::class, 'store'])
    ->name('instrument.v2.submit')
    ->middleware('throttle:5,1'); // Limit to 5 requests per minute per IP

Route::get('/api/regencies/{provinceCode}', [PublicInstrumentV2Controller::class, 'getRegencies'])
    ->name('api.regencies');

Route::get('/api/sapras-data/{concentration}', [PublicInstrumentV2Controller::class, 'getSaprasData'])
    ->name('api.sapras-data');

// Submission update via one-time token
Route::get('/submission/update/{token}', [SubmissionUpdateController::class, 'show'])
    ->name('submission.update.show');

Route::post('/submission/update/{token}', [SubmissionUpdateController::class, 'update'])
    ->name('submission.update.store');

// Submission V2 update via one-time token
Route::get('/submission-v2/update/{token}', [SubmissionV2UpdateController::class, 'show'])
    ->name('submissions-v2.update.show');

Route::post('/submission-v2/update/{token}', [SubmissionV2UpdateController::class, 'update'])
    ->name('submissions-v2.update.store');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Protected routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Verifier routes
    Route::prefix('verifier')->middleware(['role:verifier'])->name('verifier.')->group(function () {
        Route::get('/dashboard', [VerifierDashboardController::class, 'index'])->name('dashboard');
        Route::get('/submissions', [VerifierSubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{submission}', [VerifierSubmissionController::class, 'show'])->name('submissions.show');
        Route::post('/submissions/{submission}/verify', [VerifierSubmissionController::class, 'verify'])->name('submissions.verify');
        Route::post('/submissions/{submission}/reject', [VerifierSubmissionController::class, 'reject'])->name('submissions.reject');
        Route::post('/submissions/{submission}/generate-token', [VerifierSubmissionController::class, 'generateUpdateToken'])->name('submissions.generate-token');

        // Submission V2 routes for verifier
        Route::prefix('submissions-v2')->name('submissions-v2.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SubmissionV2Controller::class, 'index'])->name('index');
            Route::get('/{submission}', [\App\Http\Controllers\Admin\SubmissionV2Controller::class, 'show'])->name('show');
            Route::post('/{submission}/verify', [\App\Http\Controllers\Admin\SubmissionV2Controller::class, 'verify'])->name('verify');
            Route::post('/{submission}/reject', [\App\Http\Controllers\Admin\SubmissionV2Controller::class, 'reject'])->name('reject');
            Route::post('/{submission}/validate', [\App\Http\Controllers\Admin\SubmissionV2Controller::class, 'validateSubmission'])->name('validate');
            Route::post('/{submission}/generate-token', [\App\Http\Controllers\Admin\SubmissionV2Controller::class, 'generateUpdateToken'])->name('generate-token');
        });
    });

    // Admin routes
    Route::prefix('admin')->middleware(['role:admin'])->name('admin.')->group(function () {
        // School Management
        Route::prefix('schools')->name('schools.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SchoolController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\SchoolController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\SchoolController::class, 'store'])->name('store');
            Route::get('/{school}', [\App\Http\Controllers\Admin\SchoolController::class, 'show'])->name('show');
            Route::get('/{school}/edit', [\App\Http\Controllers\Admin\SchoolController::class, 'edit'])->name('edit');
            Route::put('/{school}', [\App\Http\Controllers\Admin\SchoolController::class, 'update'])->name('update');
            Route::delete('/{school}', [\App\Http\Controllers\Admin\SchoolController::class, 'destroy'])->name('destroy');
            Route::get('/{school}/assessments', [\App\Http\Controllers\Admin\SchoolController::class, 'assessments'])->name('assessments');
            Route::get('/{school}/submissions', [\App\Http\Controllers\Admin\SchoolController::class, 'submissions'])->name('submissions');
            Route::post('/bulk', [\App\Http\Controllers\Admin\SchoolController::class, 'bulkAction'])->name('bulk');
        });

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('/{user}/activate', [UserController::class, 'activate'])->name('activate');
            Route::post('/{user}/deactivate', [UserController::class, 'deactivate'])->name('deactivate');
            Route::post('/{user}/password', [UserController::class, 'changePassword'])->name('password');
            Route::get('/{user}/activity', [UserController::class, 'activity'])->name('activity');
            Route::post('/bulk', [UserController::class, 'bulkAction'])->name('bulk');
        });

        // Question Library
        Route::prefix('questions')->name('questions.')->group(function () {
            Route::get('/', [QuestionController::class, 'index'])->name('index');
            Route::get('/create', [QuestionController::class, 'create'])->name('create');
            Route::post('/', [QuestionController::class, 'store'])->name('store');
            Route::get('/{question}', [QuestionController::class, 'show'])->name('show');
            Route::get('/{question}/edit', [QuestionController::class, 'edit'])->name('edit');
            Route::put('/{question}', [QuestionController::class, 'update'])->name('update');
            Route::delete('/{question}', [QuestionController::class, 'destroy'])->name('destroy');
            Route::patch('/{question}/activate', [QuestionController::class, 'activate'])->name('activate');
            Route::patch('/{question}/deactivate', [QuestionController::class, 'deactivate'])->name('deactivate');
            Route::post('/{question}/duplicate', [QuestionController::class, 'duplicate'])->name('duplicate');
            Route::get('/import', [QuestionController::class, 'showImport'])->name('import');
            Route::post('/import', [QuestionController::class, 'import'])->name('import.store');
            Route::get('/export', [QuestionController::class, 'export'])->name('export');
            Route::post('/bulk', [QuestionController::class, 'bulkAction'])->name('bulkAction');
        });

        // Instrument Management
        Route::prefix('instruments')->name('instruments.')->group(function () {
            Route::get('/', [InstrumentController::class, 'index'])->name('index');
            Route::get('/create', [InstrumentController::class, 'create'])->name('create');
            Route::post('/', [InstrumentController::class, 'store'])->name('store');
            Route::get('/{instrument}', [InstrumentController::class, 'show'])->name('show');
            Route::get('/{instrument}/edit', [InstrumentController::class, 'edit'])->name('edit');
            Route::put('/{instrument}', [InstrumentController::class, 'update'])->name('update');
            Route::delete('/{instrument}', [InstrumentController::class, 'destroy'])->name('destroy');
            Route::post('/{instrument}/publish', [InstrumentController::class, 'publish'])->name('publish');
            Route::post('/{instrument}/unpublish', [InstrumentController::class, 'unpublish'])->name('unpublish');
            Route::post('/{instrument}/duplicate', [InstrumentController::class, 'duplicate'])->name('duplicate');
            Route::get('/export', [InstrumentController::class, 'export'])->name('export');
            Route::post('/bulk', [InstrumentController::class, 'bulkAction'])->name('bulkAction');
        });

        // Assessment Management
        Route::prefix('assessments')->name('assessments.')->group(function () {
            Route::get('/', [AssessmentController::class, 'index'])->name('index');
            Route::get('/create', [AssessmentController::class, 'create'])->name('create');
            Route::post('/', [AssessmentController::class, 'store'])->name('store');
            Route::get('/{assessment}', [AssessmentController::class, 'show'])->name('show');
            Route::get('/{assessment}/edit', [AssessmentController::class, 'edit'])->name('edit');
            Route::put('/{assessment}', [AssessmentController::class, 'update'])->name('update');
            Route::delete('/{assessment}', [AssessmentController::class, 'destroy'])->name('destroy');
            Route::post('/{assessment}/submit', [AssessmentController::class, 'submit'])->name('submit');
            Route::post('/{assessment}/verify', [AssessmentController::class, 'verify'])->name('verify');
            Route::post('/{assessment}/approve', [AssessmentController::class, 'approve'])->name('approve');
            Route::post('/{assessment}/reject', [AssessmentController::class, 'reject'])->name('reject');
            Route::post('/{assessment}/recalculate', [AssessmentController::class, 'recalculateScores'])->name('recalculate');
            Route::get('/{assessment}/export', [AssessmentController::class, 'export'])->name('export');
            Route::post('/bulk', [AssessmentController::class, 'bulkAction'])->name('bulkAction');

            // Assessment Answers
            Route::prefix('{assessment}/answers')->name('answers.')->group(function () {
                Route::get('/', [AssessmentAnswerController::class, 'index'])->name('index');
                Route::get('/form', [AssessmentAnswerController::class, 'answer'])->name('form');
                Route::post('/', [AssessmentAnswerController::class, 'store'])->name('store');
                Route::get('/{answer}', [AssessmentAnswerController::class, 'show'])->name('show');
                Route::put('/{answer}', [AssessmentAnswerController::class, 'update'])->name('update');
                Route::delete('/{answer}', [AssessmentAnswerController::class, 'destroy'])->name('destroy');
                Route::post('/{answer}/validate', [AssessmentAnswerController::class, 'validate'])->name('validate');
            });
        });

        // Submission Management V1
        Route::prefix('submissions')->name('submissions.')->group(function () {
            Route::get('/', [SubmissionController::class, 'index'])->name('index');
            Route::get('/{submission}', [SubmissionController::class, 'show'])->name('show');
        });

        // Submission V2 Management
        Route::prefix('submissions-v2')->name('submissions-v2.')->group(function () {
            Route::get('/', [SubmissionV2Controller::class, 'index'])->name('index');
            Route::get('/{submission}', [SubmissionV2Controller::class, 'show'])->name('show');
            Route::post('/{submission}/verify', [SubmissionV2Controller::class, 'verify'])->name('verify');
            Route::post('/{submission}/reject', [SubmissionV2Controller::class, 'reject'])->name('reject');
            Route::post('/{submission}/validate', [SubmissionV2Controller::class, 'validateSubmission'])->name('validate');
            Route::post('/{submission}/generate-token', [SubmissionV2Controller::class, 'generateUpdateToken'])->name('generate-token');
            Route::get('/export/all', [SubmissionV2Controller::class, 'export'])->name('export');
            Route::delete('/{submission}', [SubmissionV2Controller::class, 'destroy'])->name('destroy');
        });

        // Validation routes
        Route::prefix('validations')->name('validations.')->group(function () {
            Route::get('/', [AdminValidationController::class, 'index'])->name('index');
            Route::get('/{submission}', [AdminValidationController::class, 'show'])->name('show');
            Route::post('/{submission}/validate', [AdminValidationController::class, 'validateSubmission'])->name('validate');
            Route::post('/{submission}/reject', [AdminValidationController::class, 'reject'])->name('reject');
            Route::post('/{submission}/release', [AdminValidationController::class, 'release'])->name('release');
            Route::post('/bulk-release', [AdminValidationController::class, 'bulkRelease'])->name('bulk-release');
        });

        // Analytics routes
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    });
});
