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
        if (auth()->user()->province_id) {
            $stats = [
                'pending_verification' => InstrumentSubmissionV2::pendingVerification()->where('province_code', auth()->user()->province_id)->count(),
                'verified' => InstrumentSubmissionV2::where('status', InstrumentSubmissionV2::STATUS_VERIFIED)->where('province_code', auth()->user()->province_id)->count(),
                'rejected' => InstrumentSubmissionV2::where('status', InstrumentSubmissionV2::STATUS_REJECTED)->where('province_code', auth()->user()->province_id)->count(),
            ];

            $recentSubmissions = InstrumentSubmissionV2::with(['school'])
                ->pendingVerification()
                ->where('province_code', auth()->user()->province_id)
                ->latest('filled_at')
                ->take(3)
                ->get();
        } else {
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
        }

        return view('verifier.dashboard', compact('stats', 'recentSubmissions'));
    }
}
