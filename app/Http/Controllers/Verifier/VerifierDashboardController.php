<?php

namespace App\Http\Controllers\Verifier;

use App\Http\Controllers\Controller;
use App\Models\InstrumentSubmissionV2;
use App\Models\Submission;
use Illuminate\View\View;

class VerifierDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'pending_verification' => InstrumentSubmissionV2::pendingVerification()->count(),
            'verified' => InstrumentSubmissionV2::where('status', InstrumentSubmissionV2::STATUS_VERIFIED)->count(),
            'rejected' => InstrumentSubmissionV2::where('status', InstrumentSubmissionV2::STATUS_REJECTED)->count(),
        ];

        $recentSubmissions = InstrumentSubmissionV2::with(['school'])
            ->pendingVerification()
            ->latest('filled_at')
            ->take(3)
            ->get();

        return view('verifier.dashboard', compact('stats', 'recentSubmissions'));
    }
}
