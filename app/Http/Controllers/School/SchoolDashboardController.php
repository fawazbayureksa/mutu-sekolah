<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\InstrumentSubmissionV2;
use App\Models\School;
use Illuminate\Support\Facades\Auth;

class SchoolDashboardController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $school = $user->school;

        if (! $school) {
            $existing = School::where('npsn', $user->npsn)->whereNull('user_id')->first();

            if ($existing) {
                $existing->update(['user_id' => $user->id]);
                $school = $existing->fresh();
            } else {
                $school = School::create([
                    'user_id'     => $user->id,
                    'school_name' => 'Sekolah ' . $user->npsn,
                    'npsn'        => $user->npsn,
                    'address'     => '',
                ]);
            }
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
