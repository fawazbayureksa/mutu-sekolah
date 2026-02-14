<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function index(): View
    {
        $submissions = Submission::with(['school', 'instrument'])
            ->latest('filled_at')
            ->paginate(15);

        return view('admin.submissions.index', compact('submissions'));
    }

    public function show(Submission $submission): View
    {
        // Eager load the hierarchy for the view
        $submission->load([
            'school',
            'instrument.aspects.indicators.questions', // Load hierarchy
            'instrument.items', // Load items map
            'responses' // Load actual responses
        ]);

        // Map responses by instrument_item_id or question_id for easy lookup
        $responses = $submission->responses->keyBy('instrument_item_id');

        return view('admin.submissions.show', compact('submission', 'responses'));
    }
}
