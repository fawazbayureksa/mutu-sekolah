<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssessmentAnswerRequest;
use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\InstrumentItem;
use App\Services\AnswerValidationService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AssessmentAnswerController extends Controller
{
    protected $validationService;

    public function __construct(AnswerValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(Assessment $assessment): View
    {
        // Load assessment with all necessary relationships
        $assessment->load([
            'school',
            'instrument.items.question.indicator.aspect',
            'answers.question'
        ]);

        // Group items by aspect for better organization
        $itemsByAspect = $assessment->instrument->items()
            ->with(['question.indicator.aspect'])
            ->get()
            ->groupBy(function ($item) {
                return $item->question->indicator->aspect->aspect_name ?? 'Uncategorized';
            });

        // Get existing answers
        $existingAnswers = $assessment->answers->keyBy('instrument_item_id');

        return view('admin.assessments.answer', compact('assessment', 'itemsByAspect', 'existingAnswers'));
    }

    public function store(AssessmentAnswerRequest $request, Assessment $assessment): JsonResponse
    {
        // Only allow answering for draft or rejected assessments
        if (!in_array($assessment->status, ['draft', 'rejected'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only draft or rejected assessments can be edited.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            $instrumentItem = InstrumentItem::findOrFail($request->instrument_item_id);

            // Validate answer based on question type
            $validation = $this->validationService->validateAnswer(
                $instrumentItem->question,
                $request->answer_value,
                $request->answer_text
            );

            if (!$validation['valid']) {
                return response()->json([
                    'success' => false,
                    'message' => $validation['message']
                ], 422);
            }

            // Create or update answer
            $answer = AssessmentAnswer::updateOrCreate(
                [
                    'assessment_id' => $assessment->id,
                    'instrument_item_id' => $request->instrument_item_id,
                ],
                [
                    'assessment_question_id' => $instrumentItem->assessment_question_id,
                    'answer_value' => $request->answer_value,
                    'answer_text' => $request->answer_text,
                    'score' => $validation['score'] ?? null,
                    'answered_by' => auth()->id(),
                    'answered_at' => now(),
                ]
            );

            // Calculate completion percentage
            $totalQuestions = $assessment->instrument->items()->count();
            $answeredQuestions = $assessment->answers()->whereNotNull('answer_value')->count();
            $completionPercentage = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100, 2) : 0;

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Answer saved successfully.',
                'data' => [
                    'answer' => $answer,
                    'completion_percentage' => $completionPercentage,
                    'answered_questions' => $answeredQuestions,
                    'total_questions' => $totalQuestions,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save answer: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Assessment $assessment, AssessmentAnswer $answer): JsonResponse
    {
        if ($answer->assessment_id !== $assessment->id) {
            return response()->json([
                'success' => false,
                'message' => 'Answer not found for this assessment.'
            ], 404);
        }

        $answer->load(['question', 'instrumentItem']);

        return response()->json([
            'success' => true,
            'data' => $answer
        ]);
    }

    public function update(AssessmentAnswerRequest $request, Assessment $assessment, AssessmentAnswer $answer): JsonResponse
    {
        if ($answer->assessment_id !== $assessment->id) {
            return response()->json([
                'success' => false,
                'message' => 'Answer not found for this assessment.'
            ], 404);
        }

        // Only allow updating for draft or rejected assessments
        if (!in_array($assessment->status, ['draft', 'rejected'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only draft or rejected assessments can be edited.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            // Validate answer based on question type
            $validation = $this->validationService->validateAnswer(
                $answer->question,
                $request->answer_value,
                $request->answer_text
            );

            if (!$validation['valid']) {
                return response()->json([
                    'success' => false,
                    'message' => $validation['message']
                ], 422);
            }

            $answer->update([
                'answer_value' => $request->answer_value,
                'answer_text' => $request->answer_text,
                'score' => $validation['score'] ?? null,
                'answered_by' => auth()->id(),
                'answered_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Answer updated successfully.',
                'data' => $answer
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update answer: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Assessment $assessment, AssessmentAnswer $answer): JsonResponse
    {
        if ($answer->assessment_id !== $assessment->id) {
            return response()->json([
                'success' => false,
                'message' => 'Answer not found for this assessment.'
            ], 404);
        }

        // Only allow deleting for draft or rejected assessments
        if (!in_array($assessment->status, ['draft', 'rejected'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only draft or rejected assessments can be edited.'
            ], 403);
        }

        try {
            $answer->delete();

            // Calculate updated completion percentage
            $totalQuestions = $assessment->instrument->items()->count();
            $answeredQuestions = $assessment->answers()->whereNotNull('answer_value')->count();
            $completionPercentage = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100, 2) : 0;

            return response()->json([
                'success' => true,
                'message' => 'Answer deleted successfully.',
                'data' => [
                    'completion_percentage' => $completionPercentage,
                    'answered_questions' => $answeredQuestions,
                    'total_questions' => $totalQuestions,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete answer: ' . $e->getMessage()
            ], 500);
        }
    }

    public function validateAnswer(Request $request, Assessment $assessment): JsonResponse
    {
        $request->validate([
            'instrument_item_id' => 'required|exists:instrument_items,id',
            'answer_value' => 'nullable',
            'answer_text' => 'nullable|string',
        ]);

        try {
            $instrumentItem = InstrumentItem::with('question')->findOrFail($request->instrument_item_id);

            // Validate answer based on question type
            $validation = $this->validationService->validateAnswer(
                $instrumentItem->question,
                $request->answer_value,
                $request->answer_text
            );

            return response()->json([
                'success' => $validation['valid'],
                'message' => $validation['message'],
                'score' => $validation['score'] ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkStore(Request $request, Assessment $assessment): JsonResponse
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*.instrument_item_id' => 'required|exists:instrument_items,id',
            'answers.*.answer_value' => 'nullable',
            'answers.*.answer_text' => 'nullable|string',
        ]);

        // Only allow for draft or rejected assessments
        if (!in_array($assessment->status, ['draft', 'rejected'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only draft or rejected assessments can be edited.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            $saved = 0;
            $errors = [];

            foreach ($request->answers as $answerData) {
                try {
                    $instrumentItem = InstrumentItem::with('question')->findOrFail($answerData['instrument_item_id']);

                    // Validate answer
                    $validation = $this->validationService->validateAnswer(
                        $instrumentItem->question,
                        $answerData['answer_value'] ?? null,
                        $answerData['answer_text'] ?? null
                    );

                    if ($validation['valid']) {
                        AssessmentAnswer::updateOrCreate(
                            [
                                'assessment_id' => $assessment->id,
                                'instrument_item_id' => $answerData['instrument_item_id'],
                            ],
                            [
                                'assessment_question_id' => $instrumentItem->assessment_question_id,
                                'answer_value' => $answerData['answer_value'] ?? null,
                                'answer_text' => $answerData['answer_text'] ?? null,
                                'score' => $validation['score'] ?? null,
                                'answered_by' => auth()->id(),
                                'answered_at' => now(),
                            ]
                        );
                        $saved++;
                    } else {
                        $errors[] = "Item {$answerData['instrument_item_id']}: {$validation['message']}";
                    }
                } catch (\Exception $e) {
                    $errors[] = "Item {$answerData['instrument_item_id']}: {$e->getMessage()}";
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "{$saved} answer(s) saved successfully.",
                'data' => [
                    'saved' => $saved,
                    'errors' => $errors,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Bulk save failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
