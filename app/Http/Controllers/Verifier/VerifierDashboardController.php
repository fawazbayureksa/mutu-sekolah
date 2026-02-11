<?php

namespace App\Http\Controllers\Verifier;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\View\View;

class VerifierDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'pending_verification' => Submission::pendingVerification()->count(),
            'verified' => Submission::where('status', Submission::STATUS_VERIFIED)->count(),
            'rejected' => Submission::where('status', Submission::STATUS_REJECTED)->count(),
        ];

        $recentSubmissions = Submission::with(['school', 'instrument'])
            ->pendingVerification()
            ->latest('filled_at')
            ->take(5)
            ->get();

        return view('verifier.dashboard', compact('stats', 'recentSubmissions'));
    }
}
