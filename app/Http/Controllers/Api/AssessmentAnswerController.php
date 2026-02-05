<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AnswerValidationService;
use App\Services\ScoreCalculationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AssessmentAnswerController extends Controller
{
    protected AnswerValidationService $validationService;
    protected ScoreCalculationService $scoreService;

    public function __construct(
        AnswerValidationService $validationService,
        ScoreCalculationService $scoreService
    ) {
        $this->validationService = $validationService;
        $this->scoreService = $scoreService;
    }

    public function index(Request $request, $assessmentId): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($assessmentId);

        $query = $assessment->answers()->with('question');

        if ($request->has('validation_status')) {
            $query->where('validation_status', $request->validation_status);
        }

        $answers = $query->get();

        return response()->json([
            'success' => true,
            'data' => $answers,
        ]);
    }

    public function store(Request $request, $assessmentId): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($assessmentId);

        if (!$assessment->canBeEdited()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot add answers to this assessment',
            ], 400);
        }

        $validated = $request->validate([
            'question_id' => 'required|exists:assessment_questions,id',
            'answer_value' => 'required',
            'notes' => 'nullable|string',
            'attachments' => 'nullable|array',
            'file_path' => 'nullable|string',
        ]);

        $question = \App\Models\AssessmentQuestion::findOrFail($validated['question_id']);

        try {
            $answer = app(\App\Services\AssessmentWorkflowService::class)
                ->saveAnswer($assessment, $question, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Answer saved successfully',
                'data' => $answer->load('question'),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save answer',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $assessmentId, $answerId): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($assessmentId);
        $answer = \App\Models\AssessmentAnswer::findOrFail($answerId);

        if ($answer->assessment_id !== $assessment->id) {
            return response()->json([
                'success' => false,
                'message' => 'Answer does not belong to this assessment',
            ], 404);
        }

        if (!$assessment->canBeEdited()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot edit answers in current status',
            ], 400);
        }

        $validated = $request->validate([
            'answer_value' => 'required',
            'notes' => 'nullable|string',
            'attachments' => 'nullable|array',
            'file_path' => 'nullable|string',
        ]);

        $question = $answer->question;

        try {
            $this->validationService->validateAnswer($validated, $question);
            $validated = $this->validationService->castAnswerValue($validated, $question);
            $validated['score'] = $this->validationService->calculateAnswerScore($validated, $question);

            $answer->update(array_merge($validated, [
                'answered_at' => now(),
                'validation_status' => 'pending',
            ]));

            $assessment->updateProgress();

            return response()->json([
                'success' => true,
                'message' => 'Answer updated successfully',
                'data' => $answer->load('question'),
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
                'message' => 'Failed to update answer',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($assessmentId, $answerId): JsonResponse
    {
        $assessment = \App\Models\Assessment::findOrFail($assessmentId);
        $answer = \App\Models\AssessmentAnswer::findOrFail($answerId);

        if ($answer->assessment_id !== $assessment->id) {
            return response()->json([
                'success' => false,
                'message' => 'Answer does not belong to this assessment',
            ], 404);
        }

        if (!$assessment->canBeEdited()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete answers in current status',
            ], 400);
        }

        try {
            $answer->delete();
            $assessment->updateProgress();

            return response()->json([
                'success' => true,
                'message' => 'Answer deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete answer',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function validateAnswer(Request $request, $answerId): JsonResponse
    {
        $answer = \App\Models\AssessmentAnswer::findOrFail($answerId);

        $validated = $request->validate([
            'validation_status' => 'required|in:validated,rejected,needs_revision',
            'validation_notes' => 'nullable|string',
        ]);

        try {
            $answer->update([
                'validation_status' => $validated['validation_status'],
                'validation_notes' => $validated['validation_notes'],
                'validated_by' => auth()->id(),
                'validated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Answer validated successfully',
                'data' => $answer->load('validator'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to validate answer',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
