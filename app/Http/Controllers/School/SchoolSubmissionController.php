<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\InstrumentSubmissionV2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolSubmissionController extends Controller
{
    private function getSchool()
    {
        $school = Auth::user()->school;

        if (! $school) {
            abort(403, 'Akun ini tidak terhubung dengan data sekolah.');
        }

        return $school;
    }

    private function authorizeSubmission(InstrumentSubmissionV2 $submission): void
    {
        if ($submission->school_id !== $this->getSchool()->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }

    public function index()
    {
        $school = $this->getSchool();

        $submissions = InstrumentSubmissionV2::where('school_id', $school->id)
            ->latest('filled_at')
            ->paginate(15);

        return view('school.submissions.index', compact('school', 'submissions'));
    }

    public function show(InstrumentSubmissionV2 $submission)
    {
        $school = $this->getSchool();

        if ($submission->school_id !== $school->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $submission->load(['province', 'regency', 'details']);

        return view('school.submissions.show', compact('school', 'submission'));
    }

    public function edit(InstrumentSubmissionV2 $submission)
    {
        $school = $this->getSchool();

        if ($submission->school_id !== $school->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        if (! $submission->isEditable()) {
            return redirect()->route('school.submissions.show', $submission)
                ->with('error', 'Pengajuan ini tidak dapat diedit pada status saat ini.');
        }

        return view('school.submissions.edit', compact('school', 'submission'));
    }

    public function update(Request $request, InstrumentSubmissionV2 $submission)
    {
        $school = $this->getSchool();

        if ($submission->school_id !== $school->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        if (! $submission->isEditable()) {
            return redirect()->route('school.submissions.show', $submission)
                ->with('error', 'Pengajuan ini tidak dapat diedit pada status saat ini.');
        }

        $request->validate([
            'respondent_name'     => ['required', 'string', 'max:255'],
            'respondent_position' => ['required', 'string', 'max:255'],
        ]);

        $submission->update([
            'respondent_name'     => $request->input('respondent_name'),
            'respondent_position' => $request->input('respondent_position'),
            'status'              => 'submitted',
        ]);

        return redirect()->route('school.submissions.show', $submission)
            ->with('success', 'Pengajuan berhasil diperbarui.');
    }
}
