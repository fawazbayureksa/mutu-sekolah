<?php

use App\Http\Controllers\PublicInstrumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('landing'))->name('landing');

Route::get('/instrumen', [PublicInstrumentController::class, 'index'])
    ->name('instrument.form');

Route::post('/instrumen', [PublicInstrumentController::class, 'store'])
    ->name('instrument.submit');
