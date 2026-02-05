<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicInstrumentController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', fn() => view('landing'))->name('landing');

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

    // Add more protected routes here
    // Route::resource('assessments', AssessmentController::class);
    // Route::resource('schools', SchoolController::class);
    // Route::resource('instruments', InstrumentController::class);
});
