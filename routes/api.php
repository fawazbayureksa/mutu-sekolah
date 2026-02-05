<?php

use App\Http\Controllers\Api\AssessmentController;
use App\Http\Controllers\Api\AssessmentAnswerController;
use App\Http\Controllers\Api\InstrumentController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ScaleTemplateController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('instruments')->group(function () {
    Route::get('/', [InstrumentController::class, 'index']);
    Route::post('/', [InstrumentController::class, 'store']);
    Route::get('/{id}', [InstrumentController::class, 'show']);
    Route::put('/{id}', [InstrumentController::class, 'update']);
    Route::delete('/{id}', [InstrumentController::class, 'destroy']);
    Route::post('/{id}/publish', [InstrumentController::class, 'publish']);
    Route::post('/{id}/unpublish', [InstrumentController::class, 'unpublish']);
    Route::post('/{id}/duplicate', [InstrumentController::class, 'duplicate']);
});

Route::prefix('questions')->group(function () {
    Route::get('/', [QuestionController::class, 'index']);
    Route::post('/', [QuestionController::class, 'store']);
    Route::get('/{id}', [QuestionController::class, 'show']);
    Route::put('/{id}', [QuestionController::class, 'update']);
    Route::delete('/{id}', [QuestionController::class, 'destroy']);
});

Route::prefix('scale-templates')->group(function () {
    Route::get('/', [ScaleTemplateController::class, 'index']);
    Route::post('/', [ScaleTemplateController::class, 'store']);
    Route::get('/{id}', [ScaleTemplateController::class, 'show']);
    Route::put('/{id}', [ScaleTemplateController::class, 'update']);
    Route::delete('/{id}', [ScaleTemplateController::class, 'destroy']);
});

Route::prefix('assessments')->group(function () {
    Route::get('/', [AssessmentController::class, 'index']);
    Route::post('/', [AssessmentController::class, 'store']);
    Route::get('/{id}', [AssessmentController::class, 'show']);
    Route::put('/{id}', [AssessmentController::class, 'update']);
    Route::delete('/{id}', [AssessmentController::class, 'destroy']);
    Route::post('/{id}/submit', [AssessmentController::class, 'submit']);
    Route::post('/{id}/verify', [AssessmentController::class, 'verify']);
    Route::post('/{id}/approve', [AssessmentController::class, 'approve']);
    Route::post('/{id}/reject', [AssessmentController::class, 'reject']);
    Route::post('/{id}/recalculate-scores', [AssessmentController::class, 'recalculateScores']);

    Route::prefix('{assessmentId}/answers')->group(function () {
        Route::get('/', [AssessmentAnswerController::class, 'index']);
        Route::post('/', [AssessmentAnswerController::class, 'store']);
        Route::put('/{answerId}', [AssessmentAnswerController::class, 'update']);
        Route::delete('/{answerId}', [AssessmentAnswerController::class, 'destroy']);
        Route::post('/{answerId}/validate', [AssessmentAnswerController::class, 'validateAnswer']);
    });
});
