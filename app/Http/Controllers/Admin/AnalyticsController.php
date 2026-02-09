<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_released' => Submission::released()->count(),
            'total_schools' => Submission::released()->distinct('school_id')->count('school_id'),
            'by_instrument' => Submission::released()
                ->selectRaw('instrument_id, count(*) as count')
                ->groupBy('instrument_id')
                ->with('instrument')
                ->get(),
        ];

        $recentReleased = Submission::with(['school', 'instrument'])
            ->released()
            ->latest('released_at')
            ->take(10)
            ->get();

        return view('admin.analytics.index', compact('stats', 'recentReleased'));
    }
}
