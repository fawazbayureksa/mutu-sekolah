<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Services\Dashboard\DashboardQueryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KelembagaanController extends Controller
{
    public function __construct(
        private readonly DashboardQueryService $queryService
    ) {}

    /**
     * Display school directory with statistics and filters
     */
    public function index(Request $request): View
    {
        $filters = $this->extractFilters($request);

        $schools = $this->queryService->getSchoolDirectory($filters, 15);
        $stats = $this->queryService->getKelembagaanStats($filters);

        return view('admin.dashboard.kelembagaan.index', [
            'schools'    => $schools,
            'stats'      => $stats,
            'provinces'  => $this->queryService->getProvinceOptions(),
            'regencies'  => $this->queryService->getRegencyOptions($filters['province_code'] ?? null),
            'expertises' => $this->queryService->getExpertiseOptions(),
            'years'      => $this->queryService->getAvailableYears(),
            'filters'    => $filters,
        ]);
    }

    /**
     * Display detailed institutional information and expertise structure
     */
    public function show(School $school): View
    {
        $school->load([
            'province',
            'regency',
            'instrumentSubmissionsV2' => function ($q) {
                $q->orderByDesc('filled_at')->orderByDesc('id');
            },
        ]);

        // Build expertise hierarchy tree from submissions and school record
        $structure = [];
        foreach ($school->instrumentSubmissionsV2 as $sub) {
            $exp = $sub->expertise ?: 'Belum Terdefinisi';
            $prog = $sub->expertise_program ?: 'Umum';
            $conc = $sub->expertise_concentration ?: 'Umum';

            if (!isset($structure[$exp])) {
                $structure[$exp] = [];
            }
            if (!isset($structure[$exp][$prog])) {
                $structure[$exp][$prog] = [];
            }
            if (!in_array($conc, $structure[$exp][$prog])) {
                $structure[$exp][$prog][] = $conc;
            }
        }

        return view('admin.dashboard.kelembagaan.show', [
            'school'    => $school,
            'structure' => $structure,
        ]);
    }

    /**
     * Select assessment context for persistent deep-dive analytics (Phase 2 readiness)
     */
    public function selectContext(Request $request, School $school): RedirectResponse
    {
        $validated = $request->validate([
            'submission_id' => 'required|exists:instrument_submissions_v2,id',
        ]);

        $submission = $school->instrumentSubmissionsV2()->findOrFail($validated['submission_id']);

        session([
            'assessment_context' => [
                'school_id'               => $school->id,
                'school_name'             => $school->school_name,
                'npsn'                    => $school->npsn,
                'submission_id'           => $submission->id,
                'expertise'               => $submission->expertise,
                'expertise_program'       => $submission->expertise_program,
                'expertise_concentration' => $submission->expertise_concentration,
                'year'                    => $submission->filled_at ? $submission->filled_at->format('Y') : null,
            ],
        ]);

        return redirect()
            ->route('admin.dashboard.overview')
            ->with('success', "Konteks asesmen aktif: {$school->school_name} - {$submission->expertise_concentration}");
    }

    private function extractFilters(Request $request): array
    {
        return $request->only([
            'search',
            'province_code',
            'regency_code',
            'expertise',
            'status',
            'school_status',
            'year',
        ]);
    }
}
