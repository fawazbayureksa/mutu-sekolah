<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReportingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    protected ReportingService $reportService;

    public function __construct(ReportingService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function schoolReport(Request $request, $schoolId): JsonResponse
    {
        $validated = $request->validate([
            'year' => 'nullable|string|size:4',
        ]);

        $report = $this->reportService->generateSchoolReport(
            $schoolId,
            $validated['year'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }

    public function instrumentReport(Request $request, $instrumentId): JsonResponse
    {
        $validated = $request->validate([
            'year' => 'nullable|string|size:4',
        ]);

        $report = $this->reportService->generateInstrumentReport(
            $instrumentId,
            $validated['year'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }

    public function regionalReport(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'year' => 'nullable|string|size:4',
        ]);

        $report = $this->reportService->generateRegionalReport(
            $validated['province'] ?? null,
            $validated['city'] ?? null,
            $validated['year'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }

    public function questionAnalysis(Request $request, $questionId): JsonResponse
    {
        $validated = $request->validate([
            'year' => 'nullable|string|size:4',
        ]);

        $report = $this->reportService->generateQuestionAnalysisReport(
            $questionId,
            $validated['year'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }

    public function trendReport(Request $request, $instrumentId): JsonResponse
    {
        $validated = $request->validate([
            'start_year' => 'required|string|size:4',
            'end_year' => 'required|string|size:4',
        ]);

        $report = $this->reportService->generateTrendReport(
            $instrumentId,
            $validated['start_year'],
            $validated['end_year']
        );

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }
}
