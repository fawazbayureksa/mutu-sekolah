<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminValidationController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', 'verified');

        $submissions = Submission::with(['school', 'instrument', 'verifier'])
            ->when($status === 'verified', fn ($q) => $q->pendingValidation())
            ->when($status === 'validated', fn ($q) => $q->where('status', Submission::STATUS_VALIDATED))
            ->when($status === 'released', fn ($q) => $q->released())
            ->latest('filled_at')
            ->paginate(15);

        return view('admin.validations.index', compact('submissions', 'status'));
    }

    public function show(Submission $submission): View
    {
        $submission->load(['school', 'instrument', 'verifier', 'responses']);

        return view('admin.validations.show', compact('submission'));
    }

    public function validateSubmission(Request $request, Submission $submission)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $submission->update([
            'status' => Submission::STATUS_VALIDATED,
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'validation_notes' => $request->notes,
        ]);

        return back()->with('success', 'Data berhasil divalidasi');
    }

    public function reject(Request $request, Submission $submission)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $submission->update([
            'status' => Submission::STATUS_REJECTED,
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'validation_notes' => $request->notes,
        ]);

        return back()->with('success', 'Submission ditolak');
    }

    public function release(Submission $submission)
    {
        $submission->update([
            'status' => Submission::STATUS_RELEASED,
            'released_by' => auth()->id(),
            'released_at' => now(),
        ]);

        return back()->with('success', 'Data berhasil dirilis untuk analytics');
    }

    public function bulkRelease(Request $request)
    {
        $request->validate([
            'submission_ids' => 'required|array',
            'submission_ids.*' => 'exists:submissions,id',
        ]);

        $count = Submission::whereIn('id', $request->submission_ids)
            ->where('status', Submission::STATUS_VALIDATED)
            ->update([
                'status' => Submission::STATUS_RELEASED,
                'released_by' => auth()->id(),
                'released_at' => now(),
            ]);

        return back()->with('success', $count.' data berhasil dirilis');
    }
}
