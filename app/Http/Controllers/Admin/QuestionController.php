<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentIndicator;
use App\Models\AssessmentAspect;
use App\Models\ScaleTemplate;
use App\Models\InstrumentItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index(Request $request): View
    {
        $query = AssessmentQuestion::with(['indicator.aspect']);

        // Search filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('question_text', 'like', "%{$request->search}%")
                    ->orWhere('question_code', 'like', "%{$request->search}%");
            });
        }

        // Aspect filter
        if ($request->filled('aspect_id')) {
            $query->whereHas('indicator', function ($q) use ($request) {
                $q->where('aspect_id', $request->aspect_id);
            });
        }

        // Indicator filter
        if ($request->filled('indicator_id')) {
            $query->where('indicator_id', $request->indicator_id);
        }

        // Answer type filter
        if ($request->filled('answer_type')) {
            $query->where('answer_type', $request->answer_type);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $questions = $query->latest()->paginate(15);
        $aspects = AssessmentAspect::all();
        $indicators = AssessmentIndicator::all();

        return view('admin.questions.index', compact('questions', 'aspects', 'indicators'));
    }

    public function create(): View
    {
        $aspects = AssessmentAspect::with('indicators')->get();
        $scaleTemplates = ScaleTemplate::where('is_active', true)->get();

        return view('admin.questions.create', compact('aspects', 'scaleTemplates'));
    }

    public function store(QuestionRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $question = AssessmentQuestion::create([
                'question_code' => $request->question_code,
                'indicator_id' => $request->indicator_id,
                'question_text' => $request->question_text,
                'answer_type' => $request->answer_type,
                'weight' => $request->weight ?? 1,
                'order' => $request->order ?? 999,
                'help_text' => $request->help_text,
                'is_required' => $request->boolean('is_required', true),
                'max_score' => $request->max_score,
                'min_score' => $request->min_score,
                'scale_template_id' => $request->scale_template_id,
                'answer_options' => $request->answer_options,
                'is_active' => true,
            ]);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'model_type' => AssessmentQuestion::class,
                'model_id' => $question->id,
                'description' => "Created question: {$question->question_code}",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return redirect()->route('admin.questions.index')
                ->with('success', 'Question created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create question: ' . $e->getMessage());
        }
    }

    public function show(AssessmentQuestion $question): View
    {
        $question->load(['indicator.aspect', 'scaleTemplate']);

        // Get usage statistics
        $usageCount = InstrumentItem::where('assessment_question_id', $question->id)->count();
        $instruments = InstrumentItem::where('assessment_question_id', $question->id)
            ->with('instrument')
            ->get()
            ->pluck('instrument')
            ->unique('id');

        return view('admin.questions.show', compact('question', 'usageCount', 'instruments'));
    }

    public function edit(AssessmentQuestion $question): View
    {
        $question->load(['indicator.aspect', 'scaleTemplate']);
        $aspects = AssessmentAspect::with('indicators')->get();
        $scaleTemplates = ScaleTemplate::where('is_active', true)->get();

        return view('admin.questions.edit', compact('question', 'aspects', 'scaleTemplates'));
    }

    public function update(QuestionRequest $request, AssessmentQuestion $question): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $oldData = $question->toArray();

            $question->update([
                'question_code' => $request->question_code,
                'indicator_id' => $request->indicator_id,
                'question_text' => $request->question_text,
                'answer_type' => $request->answer_type,
                'weight' => $request->weight ?? 1,
                'order' => $request->order ?? $question->order,
                'help_text' => $request->help_text,
                'is_required' => $request->boolean('is_required', true),
                'max_score' => $request->max_score,
                'min_score' => $request->min_score,
                'scale_template_id' => $request->scale_template_id,
                'answer_options' => $request->answer_options,
            ]);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'model_type' => AssessmentQuestion::class,
                'model_id' => $question->id,
                'description' => "Updated question: {$question->question_code}",
                'ip_address' => request()->ip(),
                'old_values' => json_encode($oldData),
                'new_values' => json_encode($question->toArray()),
            ]);

            DB::commit();

            return redirect()->route('admin.questions.index')
                ->with('success', 'Question updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update question: ' . $e->getMessage());
        }
    }

    public function destroy(AssessmentQuestion $question): RedirectResponse
    {
        try {
            // Check if question is being used
            $usageCount = InstrumentItem::where('assessment_question_id', $question->id)->count();

            if ($usageCount > 0) {
                return back()->with('error', "Cannot delete question. It is being used in {$usageCount} instrument(s).");
            }

            DB::beginTransaction();

            $questionCode = $question->question_code;
            $question->delete();

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'delete',
                'model_type' => AssessmentQuestion::class,
                'model_id' => $question->id,
                'description' => "Deleted question: {$questionCode}",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return redirect()->route('admin.questions.index')
                ->with('success', 'Question deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete question: ' . $e->getMessage());
        }
    }

    public function activate(AssessmentQuestion $question): RedirectResponse
    {
        $question->update(['is_active' => true]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'activate',
            'model_type' => AssessmentQuestion::class,
            'model_id' => $question->id,
            'description' => "Activated question: {$question->question_code}",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'Question activated successfully.');
    }

    public function deactivate(AssessmentQuestion $question): RedirectResponse
    {
        $question->update(['is_active' => false]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deactivate',
            'model_type' => AssessmentQuestion::class,
            'model_id' => $question->id,
            'description' => "Deactivated question: {$question->question_code}",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'Question deactivated successfully.');
    }

    public function duplicate(Request $request, AssessmentQuestion $question): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Generate new unique code
            $baseCode = $question->question_code;
            $counter = 1;
            $newCode = $baseCode . '_copy' . $counter;

            while (AssessmentQuestion::where('question_code', $newCode)->exists()) {
                $counter++;
                $newCode = $baseCode . '_copy' . $counter;
            }

            $newQuestion = $question->replicate();
            $newQuestion->question_code = $newCode;
            $newQuestion->is_active = false;
            $newQuestion->save();

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'duplicate',
                'model_type' => AssessmentQuestion::class,
                'model_id' => $newQuestion->id,
                'description' => "Duplicated question from {$question->question_code} to {$newQuestion->question_code}",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return redirect()->route('admin.questions.edit', $newQuestion)
                ->with('success', 'Question duplicated successfully. Please review and update as needed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to duplicate question: ' . $e->getMessage());
        }
    }

    public function showImport(): View
    {
        return view('admin.questions.import');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            $service = new \App\Services\QuestionImportService();
            $result = $service->import($request->file('file'));

            if ($result['success']) {
                $message = $result['message'];

                if (!empty($result['warnings'])) {
                    $message .= ' Warnings: ' . implode('; ', $result['warnings']);
                }

                return redirect()->route('admin.questions.index')
                    ->with('success', $message);
            } else {
                $errorMessage = $result['message'];

                if (!empty($result['errors'])) {
                    $errorMessage .= ' Errors: ' . implode('; ', array_slice($result['errors'], 0, 5));

                    if (count($result['errors']) > 5) {
                        $errorMessage .= ' (and ' . (count($result['errors']) - 5) . ' more errors)';
                    }
                }

                return back()->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import questions: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $query = AssessmentQuestion::with(['indicator.aspect']);

            // Apply filters
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('question_text', 'like', "%{$request->search}%")
                        ->orWhere('question_code', 'like', "%{$request->search}%");
                });
            }

            if ($request->filled('aspect_id')) {
                $query->whereHas('indicator', function ($q) use ($request) {
                    $q->where('aspect_id', $request->aspect_id);
                });
            }

            if ($request->filled('answer_type')) {
                $query->where('answer_type', $request->answer_type);
            }

            if ($request->filled('status')) {
                $query->where('is_active', $request->status === 'active');
            }

            $questions = $query->get();

            // Export as CSV
            $filename = 'questions_' . date('Y-m-d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($questions) {
                $file = fopen('php://output', 'w');

                // CSV headers
                fputcsv($file, [
                    'question_code',
                    'indicator_code',
                    'aspect_name',
                    'question_text',
                    'answer_type',
                    'weight',
                    'order',
                    'is_required',
                    'min_score',
                    'max_score',
                    'help_text',
                    'answer_options',
                    'status'
                ]);

                // CSV data
                foreach ($questions as $question) {
                    $answerOptions = is_array($question->answer_options)
                        ? implode(', ', $question->answer_options)
                        : '';

                    fputcsv($file, [
                        $question->question_code,
                        $question->indicator->indicator_code ?? '',
                        $question->indicator->aspect->aspect_name ?? '',
                        $question->question_text,
                        $question->answer_type,
                        $question->weight,
                        $question->order,
                        $question->is_required ? 'true' : 'false',
                        $question->min_score,
                        $question->max_score,
                        $question->help_text,
                        $answerOptions,
                        $question->is_active ? 'active' : 'inactive'
                    ]);
                }

                fclose($file);
            };

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'questions.exported',
                'model_type' => AssessmentQuestion::class,
                'description' => "Exported {$questions->count()} questions to CSV",
                'ip_address' => request()->ip(),
            ]);

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export questions: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:assessment_questions,id',
        ]);

        try {
            DB::beginTransaction();

            $questions = AssessmentQuestion::whereIn('id', $request->question_ids)->get();
            $count = $questions->count();

            switch ($request->action) {
                case 'activate':
                    AssessmentQuestion::whereIn('id', $request->question_ids)->update(['is_active' => true]);
                    $message = "{$count} question(s) activated successfully.";
                    break;

                case 'deactivate':
                    AssessmentQuestion::whereIn('id', $request->question_ids)->update(['is_active' => false]);
                    $message = "{$count} question(s) deactivated successfully.";
                    break;

                case 'delete':
                    // Check usage for all questions
                    $usedQuestions = InstrumentItem::whereIn('assessment_question_id', $request->question_ids)
                        ->pluck('assessment_question_id')
                        ->unique();

                    if ($usedQuestions->isNotEmpty()) {
                        $usedCount = $usedQuestions->count();
                        return back()->with('error', "{$usedCount} question(s) cannot be deleted because they are in use.");
                    }

                    AssessmentQuestion::whereIn('id', $request->question_ids)->delete();
                    $message = "{$count} question(s) deleted successfully.";
                    break;
            }

            // Log bulk activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'bulk_' . $request->action,
                'model_type' => AssessmentQuestion::class,
                'description' => "Bulk {$request->action} on {$count} questions",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }
}
