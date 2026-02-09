<?php

use App\Http\Controllers\Admin\AdminValidationController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AssessmentAnswerController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\InstrumentController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicInstrumentController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', fn () => view('landing'))->name('landing');

Route::get('/instrumen', [PublicInstrumentController::class, 'index'])
    ->name('instrument.form');

Route::post('/instrumen', [PublicInstrumentController::class, 'store'])
    ->name('instrument.submit');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Protected routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Verifier routes
    Route::prefix('verifier')->middleware(['role:verifier'])->name('verifier.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Verifier\VerifierDashboardController::class, 'index'])->name('dashboard');
        Route::get('/submissions', [\App\Http\Controllers\Verifier\VerifierSubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{submission}', [\App\Http\Controllers\Verifier\VerifierSubmissionController::class, 'show'])->name('submissions.show');
        Route::post('/submissions/{submission}/verify', [\App\Http\Controllers\Verifier\VerifierSubmissionController::class, 'verify'])->name('submissions.verify');
        Route::post('/submissions/{submission}/reject', [\App\Http\Controllers\Verifier\VerifierSubmissionController::class, 'reject'])->name('submissions.reject');
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
            Route::post('/bulk', [InstrumentController::class, 'bulkAction'])->name('bulk');
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
            Route::post('/bulk', [AssessmentController::class, 'bulkAction'])->name('bulk');

            // Assessment Answers
            Route::prefix('{assessmentId}/answers')->name('answers.')->group(function () {
                Route::get('/', [AssessmentAnswerController::class, 'index'])->name('index');
                Route::get('/form', [AssessmentAnswerController::class, 'answer'])->name('form');
                Route::post('/', [AssessmentAnswerController::class, 'store'])->name('store');
                Route::get('/{answer}', [AssessmentAnswerController::class, 'show'])->name('show');
                Route::put('/{answer}', [AssessmentAnswerController::class, 'update'])->name('update');
                Route::delete('/{answer}', [AssessmentAnswerController::class, 'destroy'])->name('destroy');
                Route::post('/{answer}/validate', [AssessmentAnswerController::class, 'validate'])->name('validate');
            });
        });
        // Submission Management
        Route::resource('submissions', \App\Http\Controllers\Admin\SubmissionController::class)->only(['index', 'show']);

        // Validation routes
        Route::get('/validations', [AdminValidationController::class, 'index'])->name('validations.index');
        Route::get('/validations/{submission}', [AdminValidationController::class, 'show'])->name('validations.show');
        Route::post('/validations/{submission}/validate', [AdminValidationController::class, 'validateSubmission'])->name('validations.validate');
        Route::post('/validations/{submission}/reject', [AdminValidationController::class, 'reject'])->name('validations.reject');
        Route::post('/validations/{submission}/release', [AdminValidationController::class, 'release'])->name('validations.release');
        Route::post('/validations/bulk-release', [AdminValidationController::class, 'bulkRelease'])->name('validations.bulk-release');

        // Analytics routes
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    });
});
