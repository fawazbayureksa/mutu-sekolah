<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AssessmentWorkflowService;
use App\Services\ScoreCalculationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AssessmentController extends Controller
{
    protected AssessmentWorkflowService $workflowService;
    protected ScoreCalculationService $scoreService;

    public function __construct(
        AssessmentWorkflowService $workflowService,
        ScoreCalculationService $scoreService
    ) {
        $this->workflowService = $workflowService;
        $this->scoreService = $scoreService;
    }

    public function index(Request $request): JsonResponse
    {
        $query = \App\Models\Assessment::with(['school', 'instrument', 'answers']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('year')) {
            $query->where('period_year', $request->year);
        }

        if ($request->has('type')) {
            $query->where('assessment_type', $request->type);
        }

        if ($request->has('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        $assessments = $query->latest()->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $assessments,
        ]);
    }

    public function show($id): JsonResponse
    {
        $assessment = \App\Models\Assessment::with([
            'school',
            'instrument',
            'instrument.items.question',
            'answers.question',
            'verifier',
            'approver',
        ])->findOrFail($id);

        $details = $this->workflowService->getAssessmentDetails($assessment);

        return response()->json([
            'success' => true,
            'data' => $details,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'instrument_id' => 'required|exists:instruments,id',
            'school_id' => 'required|exists:schools,id',
            'respondent_name' => 'required|string|max:255',
            'respondent_position' => 'required|string|max:255',
            'filled_at' => 'required|date',
            'period_year' => 'required|string|size:4',
            'academic_year' => 'nullable|string|max:20',
            'semester' => 'nullable|in:1,2',
            'assessment_type' => 'required|in:self-assessment,external-audit,monitoring',
        ]);

        try {
            $assessment = $this->workflowService->createAssessment($validated);

            return response()->json([
                'success' => true,
                'message' => 'Assessment created successfully',
                'data' => $assessment->load('instrument'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create assessment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($id);

        if (!$assessment->canBeEdited()) {
            return response()->json([
                'success' => false,
                'message' => 'Assessment cannot be edited in current status',
            ], 400);
        }

        $validated = $request->validate([
            'respondent_name' => 'sometimes|required|string|max:255',
            'respondent_position' => 'sometimes|required|string|max:255',
            'filled_at' => 'sometimes|required|date',
            'period_year' => 'sometimes|required|string|size:4',
            'academic_year' => 'nullable|string|max:20',
            'semester' => 'nullable|in:1,2',
        ]);

        $assessment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Assessment updated successfully',
            'data' => $assessment,
        ]);
    }

    public function submit(Request $request, $id): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($id);

        try {
            $assessment = $this->workflowService->submitAssessment($assessment);

            return response()->json([
                'success' => true,
                'message' => 'Assessment submitted successfully',
                'data' => $assessment->load('answers'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit assessment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function verify(Request $request, $id): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($id);

        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        try {
            $assessment = $this->workflowService->verifyAssessment($assessment, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Assessment verified successfully',
                'data' => $assessment->load('verifier'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify assessment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function approve(Request $request, $id): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($id);

        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        try {
            $assessment = $this->workflowService->approveAssessment($assessment, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Assessment approved successfully',
                'data' => $assessment->load('approver'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve assessment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function reject(Request $request, $id): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($id);

        $validated = $request->validate([
            'reason' => 'required|string',
        ]);

        try {
            $assessment = $this->workflowService->rejectAssessment($assessment, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Assessment rejected successfully',
                'data' => $assessment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject assessment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function recalculateScores($id): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($id);

        try {
            $assessment = $this->workflowService->recalculateScores($assessment);

            return response()->json([
                'success' => true,
                'message' => 'Scores recalculated successfully',
                'data' => $assessment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to recalculate scores',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($id);

        try {
            $assessment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Assessment deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete assessment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
