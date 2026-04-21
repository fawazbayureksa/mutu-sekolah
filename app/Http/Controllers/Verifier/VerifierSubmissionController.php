<?php

namespace App\Http\Controllers\Verifier;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifierSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', 'pending');

        $submissions = Submission::with(['school', 'instrument'])
            ->when($status === 'pending', fn($q) => $q->pendingVerification())
            ->when($status === 'verified', fn($q) => $q->where('status', Submission::STATUS_VERIFIED))
            ->when($status === 'rejected', fn($q) => $q->where('status', Submission::STATUS_REJECTED))
            ->latest('filled_at')
            ->paginate(15);

        return view('verifier.submissions.index', compact('submissions', 'status'));
    }

    public function show(Submission $submission): View
    {
        $submission->load(['school', 'instrument', 'responses.instrumentItem']);

        return view('verifier.submissions.show', compact('submission'));
    }

    public function verify(Request $request, Submission $submission)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $submission->update([
            'status' => Submission::STATUS_VERIFIED,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'verification_notes' => $request->notes,
        ]);

        return redirect()->route('verifier.submissions.index')
            ->with('success', 'Submission berhasil diverifikasi');
    }

    public function reject(Request $request, Submission $submission)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $submission->update([
            'status' => Submission::STATUS_REJECTED,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'verification_notes' => $request->notes,
        ]);

        return redirect()->route('verifier.submissions.index')
            ->with('success', 'Pengajuan Ditolak');
    }

    public function generateUpdateToken(Submission $submission)
    {
        // Only allow token generation for rejected submissions
        if (!$submission->isRejected()) {
            return back()->with('error', 'Token hanya dapat dibuat untuk submission yang ditolak');
        }

        $token = $submission->generateUpdateToken();
        $updateUrl = route('submission.update.show', $token);

        return back()->with('success', 'Token berhasil dibuat')
            ->with('update_url', $updateUrl);
    }
}
