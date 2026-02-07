<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstrumentRequest;
use App\Models\Instrument;
use App\Models\InstrumentItem;
use App\Models\InstrumentAspect;
use App\Models\AssessmentQuestion;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InstrumentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Instrument::with(['creator', 'updater']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('code', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('version')) {
            $query->where('version', $request->version);
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        $instruments = $query->latest()->paginate(15);

        return view('admin.instruments.index', compact('instruments'));
    }

    public function create(): View
    {
        $questions = \App\Models\AssessmentQuestion::active()->get();

        return view('admin.instruments.create', compact('questions'));
    }

    public function store(InstrumentRequest $request): RedirectResponse
    {
        $instrument = Instrument::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'version' => $request->version ?? '1.0',
            'instructions' => $request->instructions,
            'estimated_duration' => $request->estimated_duration,
            'scoring_method' => $request->scoring_method ?? 'weighted_sum',
            'created_by' => auth()->id(),
            'is_active' => $request->has('is_active') ? true : false,
            'is_published' => false,
        ]);

        if ($request->filled('questions')) {
            foreach ($request->questions as $index => $questionData) {
                if (isset($questionData['question_id'])) {
                    InstrumentItem::create([
                        'instrument_id' => $instrument->id,
                        'assessment_question_id' => $questionData['question_id'],
                        'section' => $questionData['section'] ?? 'default',
                        'order' => $index + 1,
                        'uses_master_question' => true,
                    ]);
                }
            }
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'instrument.created',
            'model_type' => Instrument::class,
            'model_id' => $instrument->id,
            'description' => "Created instrument: {$instrument->name}",
            'new_values' => $instrument->toArray(),
        ]);

        return redirect()
            ->route('admin.instruments.show', $instrument)
            ->with('success', 'Instrument created successfully');
    }

    public function show(Instrument $instrument): View
    {
        $instrument->load([
            'aspects',
            'items.question.indicator.aspect',
            'items.question.scaleTemplate',
            'creator',
            'updater',
        ]);

        return view('admin.instruments.show', compact('instrument'));
    }

    public function edit(Instrument $instrument): View
    {
        $instrument->load(['items.question']);
        $questions = \App\Models\AssessmentQuestion::active()->get();

        return view('admin.instruments.edit', compact('instrument', 'questions'));
    }

    public function update(Request $request, Instrument $instrument): RedirectResponse
    {
        $oldValues = $instrument->toArray();
        $instrument->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'version' => $request->version,
            'instructions' => $request->instructions,
            'estimated_duration' => $request->estimated_duration,
            'scoring_method' => $request->scoring_method,
            'updated_by' => auth()->id(),
            'is_active' => $request->has('is_active') ? true : $instrument->is_active,
        ]);

        if ($request->has('questions')) {
            $instrument->items()->delete();

            foreach ($request->questions as $index => $questionData) {
                if (isset($questionData['question_id'])) {
                    InstrumentItem::create([
                        'instrument_id' => $instrument->id,
                        'assessment_question_id' => $questionData['question_id'],
                        'section' => $questionData['section'] ?? 'default',
                        'order' => $index + 1,
                        'answer_type' => $questionData['answer_type'] ?? null,
                        'uses_master_question' => true,
                    ]);
                }
            }
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'instrument.updated',
            'model_type' => Instrument::class,
            'model_id' => $instrument->id,
            'description' => "Updated instrument: {$instrument->name}",
            'old_values' => $oldValues,
            'new_values' => $instrument->toArray(),
        ]);

        return redirect()
            ->route('admin.instruments.show', $instrument)
            ->with('success', 'Instrument updated successfully');
    }

    public function publish(Instrument $instrument): RedirectResponse
    {
        $instrument->publish();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'instrument.published',
            'model_type' => Instrument::class,
            'model_id' => $instrument->id,
            'description' => "Published instrument: {$instrument->name}",
        ]);

        return back()->with('success', 'Instrument published successfully');
    }

    public function unpublish(Instrument $instrument): RedirectResponse
    {
        $instrument->unpublish();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'instrument.unpublished',
            'model_type' => Instrument::class,
            'model_id' => $instrument->id,
            'description' => "Unpublished instrument: {$instrument->name}",
        ]);

        return back()->with('success', 'Instrument unpublished successfully');
    }

    public function duplicate(Request $request, Instrument $instrument): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:instruments,code',
            'name' => 'nullable|string|max:255',
        ]);

        $newInstrument = Instrument::create([
            'code' => $validated['code'],
            'name' => $validated['name'] ?? $instrument->name . ' (Copy)',
            'description' => $instrument->description,
            'category' => $instrument->category,
            'version' => '1.0',
            'instructions' => $instrument->instructions,
            'estimated_duration' => $instrument->estimated_duration,
            'scoring_method' => $instrument->scoring_method,
            'created_by' => auth()->id(),
            'is_active' => true,
            'is_published' => false,
        ]);

        foreach ($instrument->aspects as $aspect) {
            InstrumentAspect::create([
                'instrument_id' => $newInstrument->id,
                'aspect_id' => $aspect->id,
                'order' => $aspect->pivot->order,
                'weight' => $aspect->pivot->weight,
            ]);
        }

        $order = 1;
        foreach ($instrument->items as $item) {
            InstrumentItem::create([
                'instrument_id' => $newInstrument->id,
                'assessment_question_id' => $item->assessment_question_id,
                'section' => $item->section,
                'order' => $order++,
                'uses_master_question' => $item->uses_master_question,
                'custom_help_text' => $item->custom_help_text,
                'custom_answer_options' => $item->custom_answer_options,
            ]);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'instrument.duplicated',
            'model_type' => Instrument::class,
            'model_id' => $newInstrument->id,
            'description' => "Duplicated instrument from: {$instrument->name}",
        ]);

        return redirect()
            ->route('admin.instruments.show', $newInstrument)
            ->with('success', 'Instrument duplicated successfully');
    }

    public function destroy(Instrument $instrument): RedirectResponse
    {
        $name = $instrument->name;
        $id = $instrument->id;

        $instrument->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'instrument.deleted',
            'model_type' => Instrument::class,
            'model_id' => $id,
            'description' => "Deleted instrument: {$name}",
        ]);

        return redirect()
            ->route('admin.instruments.index')
            ->with('success', 'Instrument deleted successfully');
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $action = $request->action;
        $instrumentIds = $request->instruments ?? [];

        if (empty($instrumentIds)) {
            return back()->with('error', 'No instruments selected');
        }

        $instruments = Instrument::whereIn('id', $instrumentIds)->get();

        switch ($action) {
            case 'activate':
                $instruments->each->update(['is_active' => true]);
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'instruments.bulk_activated',
                    'description' => "Activated {$instruments->count()} instruments",
                    'new_values' => $instruments->pluck('id')->toArray(),
                ]);
                break;

            case 'deactivate':
                $instruments->each->update(['is_active' => false]);
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'instruments.bulk_deactivated',
                    'description' => "Deactivated {$instruments->count()} instruments",
                    'new_values' => $instruments->pluck('id')->toArray(),
                ]);
                break;

            case 'delete':
                $instruments->each->delete();
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'instruments.bulk_deleted',
                    'description' => "Deleted {$instruments->count()} instruments",
                    'new_values' => $instruments->pluck('id')->toArray(),
                ]);
                break;
        }

        return back()->with('success', 'Bulk action completed successfully');
    }

    public function export(Request $request)
    {
        try {
            $query = Instrument::with(['items.question', 'aspects']);

            // Apply filters
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%")
                        ->orWhere('code', 'like', "%{$request->search}%");
                });
            }

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            if ($request->filled('status')) {
                $query->where('is_published', $request->status === 'published');
            }

            $instruments = $query->get();

            // TODO: Implement Laravel Excel export
            // For now, return CSV format
            $filename = 'instruments_' . date('Y-m-d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($instruments) {
                $file = fopen('php://output', 'w');

                // CSV headers
                fputcsv($file, [
                    'Code',
                    'Name',
                    'Category',
                    'Version',
                    'Status',
                    'Total Questions',
                    'Scoring Method',
                    'Created At',
                    'Created By'
                ]);

                // CSV data
                foreach ($instruments as $instrument) {
                    fputcsv($file, [
                        $instrument->code,
                        $instrument->name,
                        $instrument->category,
                        $instrument->version,
                        $instrument->is_published ? 'Published' : 'Draft',
                        $instrument->items->count(),
                        $instrument->scoring_method,
                        $instrument->created_at->format('Y-m-d H:i:s'),
                        $instrument->creator->name ?? 'N/A'
                    ]);
                }

                fclose($file);
            };

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'instruments.exported',
                'description' => "Exported {$instruments->count()} instruments to CSV",
            ]);

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export instruments: ' . $e->getMessage());
        }
    }
}
