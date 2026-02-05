<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\InstrumentManagementService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InstrumentController extends Controller
{
    protected InstrumentManagementService $service;

    public function __construct(InstrumentManagementService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $query = \App\Models\Instrument::with(['aspects', 'items.question']);

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('is_published')) {
            $query->where('is_published', filter_var($request->is_published, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->has('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        $instruments = $query->latest()->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $instruments,
        ]);
    }

    public function show($id): JsonResponse
    {
        $instrument = \App\Models\Instrument::with([
            'aspects',
            'items.question',
            'items.question.indicator',
            'items.question.indicator.aspect',
            'items.question.scaleTemplate',
            'creator',
            'updater',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $instrument,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:instruments,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'version' => 'nullable|string|max:20',
            'instructions' => 'nullable|string',
            'estimated_duration' => 'nullable|integer',
            'scoring_method' => 'nullable|in:simple_sum,weighted_sum,average,percentage,custom',
            'aspects' => 'nullable|array',
            'aspects.*.aspect_id' => 'required|exists:assessment_aspects,id',
            'aspects.*.order' => 'nullable|integer',
            'aspects.*.weight' => 'nullable|numeric',
            'questions' => 'nullable|array',
            'questions.*.question_id' => 'nullable|exists:assessment_questions,id',
            'questions.*.section' => 'nullable|string',
        ]);

        try {
            $instrument = $this->service->createInstrument($validated);

            return response()->json([
                'success' => true,
                'message' => 'Instrument created successfully',
                'data' => $instrument->load(['aspects', 'items']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create instrument',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $instrument = \App\Models\Instrument::findOrFail($id);

        $validated = $request->validate([
            'code' => 'sometimes|required|string|max:50|unique:instruments,code,' . $id,
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'version' => 'nullable|string|max:20',
            'instructions' => 'nullable|string',
            'estimated_duration' => 'nullable|integer',
            'scoring_method' => 'nullable|in:simple_sum,weighted_sum,average,percentage,custom',
            'aspects' => 'nullable|array',
            'aspects.*.aspect_id' => 'required|exists:assessment_aspects,id',
            'aspects.*.order' => 'nullable|integer',
            'aspects.*.weight' => 'nullable|numeric',
            'questions' => 'nullable|array',
            'questions.*.question_id' => 'nullable|exists:assessment_questions,id',
            'questions.*.section' => 'nullable|string',
        ]);

        try {
            $instrument = $this->service->updateInstrument($instrument, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Instrument updated successfully',
                'data' => $instrument->load(['aspects', 'items']),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update instrument',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function publish($id): JsonResponse
    {
        $instrument = \App\Models\Instrument::findOrFail($id);

        try {
            $instrument = $this->service->publishInstrument($instrument);

            return response()->json([
                'success' => true,
                'message' => 'Instrument published successfully',
                'data' => $instrument,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to publish instrument',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function unpublish($id): JsonResponse
    {
        $instrument = \App\Models\Instrument::findOrFail($id);

        try {
            $instrument = $this->service->unpublishInstrument($instrument);

            return response()->json([
                'success' => true,
                'message' => 'Instrument unpublished successfully',
                'data' => $instrument,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to unpublish instrument',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function duplicate(Request $request, $id): JsonResponse
    {
        $instrument = \App\Models\Instrument::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:instruments,code',
            'name' => 'nullable|string|max:255',
        ]);

        try {
            $newInstrument = $this->service->duplicateInstrument($instrument, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Instrument duplicated successfully',
                'data' => $newInstrument->load(['aspects', 'items']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to duplicate instrument',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $instrument = \App\Models\Instrument::findOrFail($id);

        try {
            $this->service->deleteInstrument($instrument);

            return response()->json([
                'success' => true,
                'message' => 'Instrument deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete instrument',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
