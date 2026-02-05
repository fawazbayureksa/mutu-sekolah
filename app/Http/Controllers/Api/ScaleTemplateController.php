<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScaleTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ScaleTemplateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ScaleTemplate::query();

        if ($request->has('scale_type')) {
            $query->where('scale_type', $request->scale_type);
        }

        if ($request->has('is_default')) {
            $query->where('is_default', filter_var($request->is_default, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->has('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        $templates = $query->latest()->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $templates,
        ]);
    }

    public function show($id): JsonResponse
    {
        $template = ScaleTemplate::with(['questions', 'answerOptions'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $template,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:scale_templates,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scale_type' => 'required|in:likert,rating,frequency,satisfaction,quality,boolean,custom',
            'scale_options' => 'required|array',
            'scale_options.*.value' => 'required|string',
            'scale_options.*.label' => 'required|string',
            'scale_options.*.score' => 'required|numeric',
            'min_score' => 'nullable|numeric',
            'max_score' => 'nullable|numeric',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['scale_options'] = json_encode($validated['scale_options']);

        $template = ScaleTemplate::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Scale template created successfully',
            'data' => $template,
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $template = ScaleTemplate::findOrFail($id);

        $validated = $request->validate([
            'code' => 'sometimes|required|string|max:50|unique:scale_templates,code,' . $id,
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'scale_type' => 'sometimes|required|in:likert,rating,frequency,satisfaction,quality,boolean,custom',
            'scale_options' => 'sometimes|required|array',
            'scale_options.*.value' => 'required|string',
            'scale_options.*.label' => 'required|string',
            'scale_options.*.score' => 'required|numeric',
            'min_score' => 'nullable|numeric',
            'max_score' => 'nullable|numeric',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if (isset($validated['scale_options'])) {
            $validated['scale_options'] = json_encode($validated['scale_options']);
        }

        $template->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Scale template updated successfully',
            'data' => $template,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $template = ScaleTemplate::findOrFail($id);

        if ($template->questions()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete template that is being used by questions',
            ], 400);
        }

        try {
            $template->delete();

            return response()->json([
                'success' => true,
                'message' => 'Scale template deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete scale template',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
