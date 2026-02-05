<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssessmentRequest;
use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\Instrument;
use App\Models\School;
use App\Models\User;
use App\Models\ActivityLog;
use App\Services\AssessmentService;
use App\Services\ScoreCalculationService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    protected $assessmentService;
    protected $scoreService;

    public function __construct(AssessmentService $assessmentService, ScoreCalculationService $scoreService)
    {
        $this->assessmentService = $assessmentService;
        $this->scoreService = $scoreService;
    }

    public function index(Request $request): View
    {
        $query = Assessment::with(['school', 'instrument', 'assessor']);

        // Search filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('assessment_code', 'like', "%{$request->search}%")
                    ->orWhereHas('school', function ($sq) use ($request) {
                        $sq->where('school_name', 'like', "%{$request->search}%");
                    });
            });
        }

        // School filter
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        // Instrument filter
        if ($request->filled('instrument_id')) {
            $query->where('instrument_id', $request->instrument_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Assessment period filter
        if ($request->filled('assessment_year')) {
            $query->where('assessment_year', $request->assessment_year);
        }

        if ($request->filled('assessment_period')) {
            $query->where('assessment_period', $request->assessment_period);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('assessment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('assessment_date', '<=', $request->date_to);
        }

        $assessments = $query->latest('assessment_date')->paginate(15);
        $schools = School::all();
        $instruments = Instrument::where('status', 'published')->get();

        return view('admin.assessments.index', compact('assessments', 'schools', 'instruments'));
    }

    public function create(): View
    {
        $schools = School::where('is_active', true)->get();
        $instruments = Instrument::where('status', 'published')->get();
        $assessors = User::where('role', 'assessor')->where('is_active', true)->get();

        return view('admin.assessments.create', compact('schools', 'instruments', 'assessors'));
    }

    public function store(AssessmentRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Generate unique assessment code
            $code = $this->generateAssessmentCode($request->school_id, $request->assessment_year);

            $assessment = Assessment::create([
                'assessment_code' => $code,
                'school_id' => $request->school_id,
                'instrument_id' => $request->instrument_id,
                'assessor_id' => $request->assessor_id ?? auth()->id(),
                'assessment_date' => $request->assessment_date,
                'assessment_year' => $request->assessment_year,
                'assessment_period' => $request->assessment_period,
                'status' => 'draft',
                'notes' => $request->notes,
            ]);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'model_type' => Assessment::class,
                'model_id' => $assessment->id,
                'description' => "Created assessment: {$assessment->assessment_code}",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return redirect()->route('admin.assessments.show', $assessment)
                ->with('success', 'Assessment created successfully. You can now start filling in the answers.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create assessment: ' . $e->getMessage());
        }
    }

    public function show(Assessment $assessment): View
    {
        $assessment->load([
            'school',
            'instrument.items.question.indicator.aspect',
            'assessor',
            'verifier',
            'approver',
            'answers.question'
        ]);

        // Calculate completion percentage
        $totalQuestions = $assessment->instrument->items()->count();
        $answeredQuestions = $assessment->answers()->whereNotNull('answer_value')->count();
        $completionPercentage = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100, 2) : 0;

        // Get score breakdown by aspect
        $scoreByAspect = $this->scoreService->calculateScoreByAspect($assessment);

        return view('admin.assessments.show', compact('assessment', 'completionPercentage', 'scoreByAspect'));
    }

    public function edit(Assessment $assessment)
    {
        // Only drafts can be edited
        if (!in_array($assessment->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Only draft or rejected assessments can be edited.');
        }

        $assessment->load(['school', 'instrument', 'assessor', 'answers.question']);
        $schools = School::where('is_active', true)->get();
        $instruments = Instrument::where('status', 'published')->get();
        $assessors = User::where('role', 'assessor')->where('is_active', true)->get();

        return view('admin.assessments.edit', compact('assessment', 'schools', 'instruments', 'assessors'));
    }

    public function update(AssessmentRequest $request, Assessment $assessment): RedirectResponse
    {
        // Only drafts can be updated
        if (!in_array($assessment->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Only draft or rejected assessments can be updated.');
        }

        try {
            DB::beginTransaction();

            $oldData = $assessment->toArray();

            $assessment->update([
                'school_id' => $request->school_id,
                'instrument_id' => $request->instrument_id,
                'assessor_id' => $request->assessor_id ?? $assessment->assessor_id,
                'assessment_date' => $request->assessment_date,
                'assessment_year' => $request->assessment_year,
                'assessment_period' => $request->assessment_period,
                'notes' => $request->notes,
            ]);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'model_type' => Assessment::class,
                'model_id' => $assessment->id,
                'description' => "Updated assessment: {$assessment->assessment_code}",
                'ip_address' => request()->ip(),
                'old_values' => json_encode($oldData),
                'new_values' => json_encode($assessment->toArray()),
            ]);

            DB::commit();

            return redirect()->route('admin.assessments.show', $assessment)
                ->with('success', 'Assessment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update assessment: ' . $e->getMessage());
        }
    }

    public function destroy(Assessment $assessment): RedirectResponse
    {
        // Only drafts can be deleted
        if ($assessment->status !== 'draft') {
            return back()->with('error', 'Only draft assessments can be deleted.');
        }

        try {
            DB::beginTransaction();

            $assessmentCode = $assessment->assessment_code;

            // Delete all answers first
            $assessment->answers()->delete();

            // Delete the assessment
            $assessment->delete();

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'delete',
                'model_type' => Assessment::class,
                'model_id' => $assessment->id,
                'description' => "Deleted assessment: {$assessmentCode}",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return redirect()->route('admin.assessments.index')
                ->with('success', 'Assessment deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete assessment: ' . $e->getMessage());
        }
    }

    public function submit(Assessment $assessment): RedirectResponse
    {
        if ($assessment->status !== 'draft') {
            return back()->with('error', 'Only draft assessments can be submitted.');
        }

        // Check if all required questions are answered
        $totalQuestions = $assessment->instrument->items()->count();
        $answeredQuestions = $assessment->answers()->whereNotNull('answer_value')->count();

        if ($answeredQuestions < $totalQuestions) {
            return back()->with('error', "Please answer all questions before submitting. {$answeredQuestions}/{$totalQuestions} answered.");
        }

        try {
            DB::beginTransaction();

            $assessment->update([
                'status' => 'submitted',
                'submitted_at' => now(),
                'submitted_by' => auth()->id(),
            ]);

            // Calculate scores
            $this->scoreService->calculateAndStoreScores($assessment);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'submit',
                'model_type' => Assessment::class,
                'model_id' => $assessment->id,
                'description' => "Submitted assessment: {$assessment->assessment_code}",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return redirect()->route('admin.assessments.show', $assessment)
                ->with('success', 'Assessment submitted successfully and is now pending verification.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to submit assessment: ' . $e->getMessage());
        }
    }

    public function verify(Request $request, Assessment $assessment): RedirectResponse
    {
        if ($assessment->status !== 'submitted') {
            return back()->with('error', 'Only submitted assessments can be verified.');
        }

        try {
            DB::beginTransaction();

            $assessment->update([
                'status' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
                'verification_notes' => $request->verification_notes,
            ]);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'verify',
                'model_type' => Assessment::class,
                'model_id' => $assessment->id,
                'description' => "Verified assessment: {$assessment->assessment_code}",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return redirect()->route('admin.assessments.show', $assessment)
                ->with('success', 'Assessment verified successfully and is now pending approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to verify assessment: ' . $e->getMessage());
        }
    }

    public function approve(Request $request, Assessment $assessment): RedirectResponse
    {
        if ($assessment->status !== 'verified') {
            return back()->with('error', 'Only verified assessments can be approved.');
        }

        try {
            DB::beginTransaction();

            $assessment->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
                'approval_notes' => $request->approval_notes,
            ]);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'approve',
                'model_type' => Assessment::class,
                'model_id' => $assessment->id,
                'description' => "Approved assessment: {$assessment->assessment_code}",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return redirect()->route('admin.assessments.show', $assessment)
                ->with('success', 'Assessment approved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve assessment: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, Assessment $assessment): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        if (!in_array($assessment->status, ['submitted', 'verified'])) {
            return back()->with('error', 'Only submitted or verified assessments can be rejected.');
        }

        try {
            DB::beginTransaction();

            $assessment->update([
                'status' => 'rejected',
                'rejected_at' => now(),
                'rejected_by' => auth()->id(),
                'rejection_reason' => $request->rejection_reason,
            ]);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'reject',
                'model_type' => Assessment::class,
                'model_id' => $assessment->id,
                'description' => "Rejected assessment: {$assessment->assessment_code}",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return redirect()->route('admin.assessments.show', $assessment)
                ->with('success', 'Assessment rejected. The assessor can now make corrections.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to reject assessment: ' . $e->getMessage());
        }
    }

    public function recalculateScores(Assessment $assessment): RedirectResponse
    {
        try {
            $this->scoreService->calculateAndStoreScores($assessment);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'recalculate_scores',
                'model_type' => Assessment::class,
                'model_id' => $assessment->id,
                'description' => "Recalculated scores for assessment: {$assessment->assessment_code}",
                'ip_address' => request()->ip(),
            ]);

            return back()->with('success', 'Scores recalculated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to recalculate scores: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            // TODO: Implement export using Laravel Excel
            return back()->with('info', 'Export functionality will be implemented.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export assessments: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:delete,export',
            'assessment_ids' => 'required|array',
            'assessment_ids.*' => 'exists:assessments,id',
        ]);

        try {
            DB::beginTransaction();

            $assessments = Assessment::whereIn('id', $request->assessment_ids)->get();
            $count = $assessments->count();

            switch ($request->action) {
                case 'delete':
                    // Only delete drafts
                    $drafts = $assessments->where('status', 'draft');
                    $draftCount = $drafts->count();

                    if ($draftCount === 0) {
                        return back()->with('error', 'No draft assessments to delete. Only drafts can be deleted.');
                    }

                    foreach ($drafts as $assessment) {
                        $assessment->answers()->delete();
                        $assessment->delete();
                    }

                    $message = "{$draftCount} draft assessment(s) deleted successfully.";
                    break;

                case 'export':
                    // TODO: Implement bulk export
                    return back()->with('info', 'Bulk export functionality will be implemented.');
            }

            // Log bulk activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'bulk_' . $request->action,
                'model_type' => Assessment::class,
                'description' => "Bulk {$request->action} on {$count} assessments",
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    protected function generateAssessmentCode($schoolId, $year): string
    {
        $school = School::find($schoolId);
        $schoolCode = $school ? substr($school->school_code, 0, 4) : 'SCH';
        $yearShort = substr($year, -2);

        // Find the last assessment for this school and year
        $lastAssessment = Assessment::where('school_id', $schoolId)
            ->where('assessment_year', $year)
            ->latest('id')
            ->first();

        $sequence = $lastAssessment ? (int) substr($lastAssessment->assessment_code, -3) + 1 : 1;

        return sprintf('%s-%s-%03d', $schoolCode, $yearShort, $sequence);
    }
}
