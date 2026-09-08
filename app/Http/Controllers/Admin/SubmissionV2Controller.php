<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SubmissionV2BulkExport;
use App\Exports\SubmissionV2Export;
use App\Http\Controllers\Controller;
use App\Models\InstrumentSubmissionV2;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class SubmissionV2Controller extends Controller
{
    public function index(Request $request): View
    {
        $status         = $request->get('status', 'all');
        $bidangKeahlian = $request->get('bidang_keahlian', '');

        $viewPrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        $submissions = InstrumentSubmissionV2::query()
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->when($bidangKeahlian !== '', fn($q) => $q->where('expertise', $bidangKeahlian))
            ->latest('filled_at');

        if ($viewPrefix === 'verifier' && auth()->user()->province_id) {
            $submissions = $submissions->where('province_code', auth()->user()->province_id);
            $stats = [
                'total'     => InstrumentSubmissionV2::where('province_code', auth()->user()->province_id)->count(),
                'submitted' => InstrumentSubmissionV2::where('status', 'submitted')->where('province_code', auth()->user()->province_id)->count(),
                'verified'  => InstrumentSubmissionV2::where('status', 'verified')->where('province_code', auth()->user()->province_id)->count(),
                'validated' => InstrumentSubmissionV2::where('status', 'validated')->where('province_code', auth()->user()->province_id)->count(),
                'rejected'  => InstrumentSubmissionV2::where('status', 'rejected')->where('province_code', auth()->user()->province_id)->count(),
            ];
        } else {
            $stats = [
                'total'     => InstrumentSubmissionV2::count(),
                'submitted' => InstrumentSubmissionV2::where('status', 'submitted')->count(),
                'verified'  => InstrumentSubmissionV2::where('status', 'verified')->count(),
                'validated' => InstrumentSubmissionV2::where('status', 'validated')->count(),
                'rejected'  => InstrumentSubmissionV2::where('status', 'rejected')->count(),
            ];
        }

        // Distinct list of Bidang Keahlian for the filter dropdown
        $bidangKeahlianList = InstrumentSubmissionV2::query()
            ->whereNotNull('expertise')
            ->where('expertise', '!=', '')
            ->distinct()
            ->orderBy('expertise')
            ->pluck('expertise');

        $submissions = $submissions->paginate(15);

        return view("{$viewPrefix}.submissions-v2.index", compact(
            'submissions',
            'status',
            'stats',
            'bidangKeahlianList',
            'bidangKeahlian'
        ));
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
            'section_notes' => 'nullable|array',
        ]);

        if ($submission->status !== InstrumentSubmissionV2::STATUS_SUBMITTED) {
            return back()->with('error', 'Submission tidak dapat diverifikasi dengan status saat ini');
        }

        $updateData = [
            'status' => InstrumentSubmissionV2::STATUS_VERIFIED,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'verification_notes' => $request->notes,
        ];

        if (Auth::user()->role == 'admin') {
            $updateData['status'] = InstrumentSubmissionV2::STATUS_VALIDATED;
        }

        if ($request->has('section_notes')) {
            $existingNotes = $submission->section_notes ?? [];
            $updateData['section_notes'] = array_merge($existingNotes, $request->input('section_notes', []));
        }

        $submission->update($updateData);

        $routePrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        return redirect()->route("{$routePrefix}.submissions-v2.index")
            ->with('success', 'Submission berhasil diverifikasi');
    }

    public function reject(Request $request, InstrumentSubmissionV2 $submission): RedirectResponse
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'section_notes' => 'nullable|array',
        ]);

        $updateData = [
            'status' => InstrumentSubmissionV2::STATUS_REJECTED,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'verification_notes' => $request->notes,
        ];

        if ($request->has('section_notes')) {
            $existingNotes = $submission->section_notes ?? [];
            $updateData['section_notes'] = array_merge($existingNotes, $request->input('section_notes', []));
        }

        $submission->update($updateData);

        $routePrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        return redirect()->route("{$routePrefix}.submissions-v2.index")
            ->with('success', 'Pengajuan Ditolak');
    }

    public function validateSubmission(Request $request, InstrumentSubmissionV2 $submission): RedirectResponse
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
            'section_notes' => 'nullable|array',
        ]);

        if ($submission->status !== InstrumentSubmissionV2::STATUS_VERIFIED) {
            return back()->with('error', 'Submission harus diverifikasi terlebih dahulu');
        }

        $updateData = [
            'status' => InstrumentSubmissionV2::STATUS_VALIDATED,
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'validation_notes' => $request->notes,
        ];

        if ($request->has('section_notes')) {
            $existingNotes = $submission->section_notes ?? [];
            $updateData['section_notes'] = array_merge($existingNotes, $request->input('section_notes', []));
        }

        $submission->update($updateData);

        $routePrefix = $request->route()->getPrefix() === 'verifier/submissions-v2' ? 'verifier' : 'admin';

        return redirect()->route("{$routePrefix}.submissions-v2.index")
            ->with('success', 'Submission berhasil divalidasi');
    }

    public function saveSectionNotes(Request $request, InstrumentSubmissionV2 $submission): RedirectResponse
    {
        $request->validate([
            'section_notes' => 'required|array',
        ]);

        $existingNotes = $submission->section_notes ?? [];
        $newNotes = array_merge($existingNotes, $request->input('section_notes', []));

        $submission->update([
            'section_notes' => $newNotes,
        ]);

        return back()->with('success', 'Catatan per bagian berhasil disimpan.');
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
        set_time_limit(120);
        $submission->load(['school', 'province', 'regency', 'verifier', 'validator']);

        $npsn     = $submission->npsn ?? $submission->school?->npsn ?? 'unknown';
        $date     = now()->format('Ymd');
        $fileName = "pengajuan-{$npsn}-{$date}.xlsx";

        return Excel::download(new SubmissionV2Export($submission), $fileName);
    }

    public function export(Request $request)
    {
        set_time_limit(120);
        $status         = $request->get('status') ?: 'all';
        $bidangKeahlian = (string) ($request->get('bidang_keahlian') ?? '');
        $chunkSize      = max(10, min(500, (int) ($request->get('chunk_size') ?: 50)));

        $suffix  = $bidangKeahlian ? '-' . \Illuminate\Support\Str::slug($bidangKeahlian) : '';
        $dateStr = now()->format('Ymd');

        // Count matching records (cheap query — no eager-loads)
        $total = InstrumentSubmissionV2::query()
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->when($bidangKeahlian !== '', fn($q) => $q->where('expertise', $bidangKeahlian))
            ->count();

        // ── Single file ────────────────────────────────────────────────────
        if ($total <= $chunkSize) {
            $fileName = "semua-pengajuan{$suffix}-{$dateStr}.xlsx";
            return Excel::download(new SubmissionV2BulkExport($status, $bidangKeahlian), $fileName);
        }

        // ── Multiple files → ZIP ───────────────────────────────────────────
        $chunks  = (int) ceil($total / $chunkSize);
        $tempDir = storage_path('app/temp/bulk-export');

        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipName = "pengajuan{$suffix}-{$dateStr}.zip";
        $zipPath = "{$tempDir}/{$zipName}";

        $zip = new \ZipArchive();
        $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $tempFiles = [];

        for ($part = 1; $part <= $chunks; $part++) {
            $offset   = ($part - 1) * $chunkSize;
            $xlsxName = "pengajuan{$suffix}-{$dateStr}-bagian-{$part}.xlsx";
            $xlsxPath = "{$tempDir}/{$xlsxName}";

            Excel::store(
                new SubmissionV2BulkExport($status, $bidangKeahlian, $chunkSize, $offset),
                "temp/bulk-export/{$xlsxName}"
            );

            $zip->addFile($xlsxPath, $xlsxName);
            $tempFiles[] = $xlsxPath;
        }

        $zip->close();

        // Clean up individual xlsx files; the zip itself is cleaned after download
        foreach ($tempFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }
}
