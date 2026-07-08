<?php

namespace App\Http\Controllers;

use App\Models\InstrumentSubmissionV2;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicSchoolController extends Controller
{
    public function show(Request $request, string $token): View
    {
        $school = School::where('share_token', $token)
            ->where('share_token_expires_at', '>', now())
            ->with(['province', 'regency', 'instrumentSubmissionsV2'])
            ->firstOrFail();

        $recentSubmissions = $school->instrumentSubmissionsV2()
            ->latest('filled_at')
            ->take(10)
            ->get();

        return view('public.schools.show', compact('school', 'recentSubmissions'));
    }

    public function submissionShow(Request $request, string $token, InstrumentSubmissionV2 $submission): View
    {
        $school = School::where('share_token', $token)
            ->where('share_token_expires_at', '>', now())
            ->firstOrFail();

        abort_if($submission->school_id !== $school->id, 404);

        $answers = $submission->answers ?? [];

        return view('public.schools.submission', compact('school', 'submission', 'answers'));
    }
}
