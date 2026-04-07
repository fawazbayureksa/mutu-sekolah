<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\InstrumentSubmissionV2;
use Illuminate\Support\Facades\Auth;

class SchoolDashboardController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $school = $user->school;

        if (! $school) {
            return view('school.dashboard', [
                'school'            => null,
                'stats'             => ['total' => 0, 'submitted' => 0, 'verified' => 0, 'validated' => 0, 'rejected' => 0],
                'recentSubmissions' => collect(),
            ]);
        }

        $stats = [
            'total'    => InstrumentSubmissionV2::where('school_id', $school->id)->count(),
            'submitted' => InstrumentSubmissionV2::where('school_id', $school->id)->where('status', 'submitted')->count(),
            'verified' => InstrumentSubmissionV2::where('school_id', $school->id)->where('status', 'verified')->count(),
            'validated' => InstrumentSubmissionV2::where('school_id', $school->id)->where('status', 'validated')->count(),
            'rejected' => InstrumentSubmissionV2::where('school_id', $school->id)->where('status', 'rejected')->count(),
        ];

        $recentSubmissions = InstrumentSubmissionV2::where('school_id', $school->id)
            ->latest('filled_at')
            ->limit(5)
            ->get();

        return view('school.dashboard', compact('school', 'stats', 'recentSubmissions'));
    }
}
