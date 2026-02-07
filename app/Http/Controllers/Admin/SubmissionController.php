<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
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
        $submission->load(['school', 'instrument', 'responses.instrumentItem.question']);

        // Group responses by aspect/indicator if possible, or just pass them
        // For now, we'll just pass the submission with loaded relationships

        return view('admin.submissions.show', compact('submission'));
    }
}
