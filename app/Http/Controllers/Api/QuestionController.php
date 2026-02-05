<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentQuestion;
use App\Models\ScaleTemplate;
use App\Models\AnswerOption;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = AssessmentQuestion::with(['indicator.aspect', 'scaleTemplate']);

        if ($request->has('aspect_id')) {
            $query->whereHas('indicator', function ($q) use ($request) {
                $q->where('aspect_id', $request->aspect_id);
            });
        }

        if ($request->has('indicator_id')) {
            $query->where('indicator_id', $request->indicator_id);
        }

        if ($request->has('answer_type')) {
            $query->where('answer_type', $request->answer_type);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        $questions = $query->orderBy('order')->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $questions,
        ]);
    }

    public function show($id): JsonResponse
    {
        $question = AssessmentQuestion::with([
            'indicator.aspect',
            'scaleTemplate',
            'answerOptions',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $question,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'indicator_id' => 'nullable|exists:assessment_indicators,id',
            'question_code' => 'nullable|string|max:20|unique:assessment_questions,question_code',
            'question_text' => 'required|string',
            'answer_type' => 'required|in:boolean,scale,number,text,multiple_choice,percentage,file',
            'weight' => 'nullable|numeric',
            'order' => 'nullable|integer',
            'help_text' => 'nullable|string',
            'is_required' => 'nullable|boolean',
            'max_score' => 'nullable|numeric',
            'min_score' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
            'answer_options' => 'nullable|array',
            'scale_template_id' => 'nullable|exists:scale_templates,id',
        ]);

        $question = AssessmentQuestion::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Question created successfully',
            'data' => $question->load(['indicator.aspect', 'scaleTemplate']),
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $question = AssessmentQuestion::findOrFail($id);

        $validated = $request->validate([
            'indicator_id' => 'nullable|exists:assessment_indicators,id',
            'question_code' => 'nullable|string|max:20|unique:assessment_questions,question_code,' . $id,
            'question_text' => 'sometimes|required|string',
            'answer_type' => 'sometimes|required|in:boolean,scale,number,text,multiple_choice,percentage,file',
            'weight' => 'nullable|numeric',
            'order' => 'nullable|integer',
            'help_text' => 'nullable|string',
            'is_required' => 'nullable|boolean',
            'max_score' => 'nullable|numeric',
            'min_score' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
            'answer_options' => 'nullable|array',
            'scale_template_id' => 'nullable|exists:scale_templates,id',
        ]);

        $question->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Question updated successfully',
            'data' => $question->load(['indicator.aspect', 'scaleTemplate']),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $question = AssessmentQuestion::findOrFail($id);

        try {
            $question->delete();

            return response()->json([
                'success' => true,
                'message' => 'Question deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete question',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
