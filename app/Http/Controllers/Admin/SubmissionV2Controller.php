<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SubmissionV2BulkExport;
use App\Exports\SubmissionV2Export;
use App\Http\Controllers\Controller;
use App\Models\InstrumentSubmissionV2;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class SubmissionV2Controller extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', 'all');

        $viewPrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        $submissions = InstrumentSubmissionV2::query()
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest('filled_at');

        if ($viewPrefix === 'verifier' && auth()->user()->province_id) {
            $submissions = $submissions->where('province_code', auth()->user()->province_id);
            $stats = [
                'total' => InstrumentSubmissionV2::where('province_code', auth()->user()->province_id)->count(),
                'submitted' => InstrumentSubmissionV2::where('status', 'submitted')->where('province_code', auth()->user()->province_id)->count(),
                'verified' => InstrumentSubmissionV2::where('status', 'verified')->where('province_code', auth()->user()->province_id)->count(),
                'validated' => InstrumentSubmissionV2::where('status', 'validated')->where('province_code', auth()->user()->province_id)->count(),
                'rejected' => InstrumentSubmissionV2::where('status', 'rejected')->where('province_code', auth()->user()->province_id)->count(),
            ];
        } else {
            $stats = [
                'total' => InstrumentSubmissionV2::count(),
                'submitted' => InstrumentSubmissionV2::where('status', 'submitted')->count(),
                'verified' => InstrumentSubmissionV2::where('status', 'verified')->count(),
                'validated' => InstrumentSubmissionV2::where('status', 'validated')->count(),
                'rejected' => InstrumentSubmissionV2::where('status', 'rejected')->count(),
            ];
        }

        $submissions = $submissions->paginate(15);


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
            ->with('success', 'Pengajuan Ditolak');
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
        $token = $submission->generateUpdateToken();

        $updateUrl = route('submissions-v2.update.show', $token);

        return back()
            ->with('success', 'Token berhasil dibuat. URL update akan berlaku selama 5 hari.')
            ->with('update_url', $updateUrl);
    }

    public function destroy(Request $request, InstrumentSubmissionV2 $submission): RedirectResponse
    {
        $submission->delete();

        $routePrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        return redirect()->route("{$routePrefix}.submissions-v2.index")
            ->with('success', 'Submission berhasil dihapus');
    }

    public function exportSingle(InstrumentSubmissionV2 $submission)
    {
        $submission->load(['school', 'province', 'regency', 'verifier', 'validator']);

        $npsn     = $submission->npsn ?? $submission->school?->npsn ?? 'unknown';
        $date     = now()->format('Ymd');
        $fileName = "pengajuan-{$npsn}-{$date}.xlsx";

        return Excel::download(new SubmissionV2Export($submission), $fileName);
    }

    public function export(Request $request)
    {
        $fileName = 'semua-pengajuan-' . now()->format('Ymd') . '.xlsx';

        return Excel::download(new SubmissionV2BulkExport(), $fileName);
    }
}
