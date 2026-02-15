<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstrumentSubmissionV2;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubmissionV2Controller extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', 'all');

        $submissions = InstrumentSubmissionV2::query()
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest('filled_at')
            ->paginate(15);

        $stats = [
            'total' => InstrumentSubmissionV2::count(),
            'submitted' => InstrumentSubmissionV2::where('status', 'submitted')->count(),
            'verified' => InstrumentSubmissionV2::where('status', 'verified')->count(),
            'validated' => InstrumentSubmissionV2::where('status', 'validated')->count(),
            'rejected' => InstrumentSubmissionV2::where('status', 'rejected')->count(),
        ];

        $viewPrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        return view("{$viewPrefix}.submissions-v2.index", compact('submissions', 'status', 'stats'));
    }

    public function show(Request $request, InstrumentSubmissionV2 $submission): View
    {
        $submission->load(['details', 'verifier', 'validator', 'school', 'province', 'regency']);

        $viewPrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        return view("{$viewPrefix}.submissions-v2.show", compact('submission'));
    }

    public function verify(Request $request, InstrumentSubmissionV2 $submission): RedirectResponse
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($submission->status !== InstrumentSubmissionV2::STATUS_SUBMITTED) {
            return back()->with('error', 'Submission tidak dapat diverifikasi dengan status saat ini');
        }

        $submission->update([
            'status' => InstrumentSubmissionV2::STATUS_VERIFIED,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'verification_notes' => $request->notes,
        ]);

        $routePrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        return redirect()->route("{$routePrefix}.submissions-v2.index")
            ->with('success', 'Submission berhasil diverifikasi');
    }

    public function reject(Request $request, InstrumentSubmissionV2 $submission): RedirectResponse
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $submission->update([
            'status' => InstrumentSubmissionV2::STATUS_REJECTED,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'verification_notes' => $request->notes,
        ]);

        $routePrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        return redirect()->route("{$routePrefix}.submissions-v2.index")
            ->with('success', 'Submission ditolak');
    }

    public function validateSubmission(Request $request, InstrumentSubmissionV2 $submission): RedirectResponse
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($submission->status !== InstrumentSubmissionV2::STATUS_VERIFIED) {
            return back()->with('error', 'Submission harus diverifikasi terlebih dahulu');
        }

        $submission->update([
            'status' => InstrumentSubmissionV2::STATUS_VALIDATED,
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'validation_notes' => $request->notes,
        ]);

        $routePrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        return redirect()->route("{$routePrefix}.submissions-v2.index")
            ->with('success', 'Submission berhasil divalidasi');
    }

    public function generateUpdateToken(InstrumentSubmissionV2 $submission): RedirectResponse
    {
        if ($submission->status !== InstrumentSubmissionV2::STATUS_REJECTED) {
            return back()->with('error', 'Token hanya dapat dibuat untuk submission yang ditolak');
        }

        $token = $submission->generateUpdateToken();

        $updateUrl = route('submissions-v2.update.show', $token);

        return back()
            ->with('success', 'Token berhasil dibuat. URL update akan berlaku selama 24 jam.')
            ->with('update_url', $updateUrl);
    }

    public function destroy(Request $request, InstrumentSubmissionV2 $submission): RedirectResponse
    {
        $submission->delete();

        $routePrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        return redirect()->route("{$routePrefix}.submissions-v2.index")
            ->with('success', 'Submission berhasil dihapus');
    }

    public function export(Request $request)
    {
        // TODO: Implement export functionality
        return back()->with('info', 'Fitur export akan segera tersedia');
    }
}
