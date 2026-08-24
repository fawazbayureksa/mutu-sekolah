<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardQueryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesertaDidikController extends Controller
{
    public function __construct(
        private readonly DashboardQueryService $queryService
    ) {}

    /**
     * Display Aspect A (Mutu Peserta Didik) Dashboard grouped by Kategori Keahlian
     */
    public function index(Request $request): View
    {
        $filters = $this->extractFilters($request);

        // 1. Fetch Aggregated Analytics for Kategori Keahlian
        $analytics = $this->queryService->getPesertaDidikCategoryAnalytics($filters, 15);

        // 2. Dropdown options for Filter Bar
        $provinces = $this->queryService->getProvinceOptions();
        $regencies = $this->queryService->getRegencyOptions($filters['province_code'] ?? null);
        $expertises = $this->queryService->getExpertiseOptions();
        $concentrations = $this->queryService->getConcentrationOptions($filters['expertise'] ?? null);
        $years = $this->queryService->getAvailableYears();

        return view('admin.dashboard.peserta-didik.index', [
            'analytics'      => $analytics,
            'kpis'           => $analytics['kpis'],
            'competency'     => $analytics['competency'] ?? [],
            'expertiseBreakdown'     => $analytics['expertiseBreakdown'] ?? $analytics['expertise_breakdown'],
            'concentrationBreakdown' => $analytics['concentrationBreakdown'] ?? $analytics['concentration_breakdown'],
            'schoolList'     => $analytics['school_list'],
            'provinces'      => $provinces,
            'regencies'      => $regencies,
            'expertises'     => $expertises,
            'concentrations' => $concentrations,
            'years'          => $years,
            'filters'        => $filters,
        ]);
    }

    /**
     * Extract filter parameters from request
     */
    private function extractFilters(Request $request): array
    {
        return [
            'search'                  => $request->query('search'),
            'province_code'           => $request->query('province_code'),
            'regency_code'            => $request->query('regency_code'),
            'expertise'               => $request->query('expertise'),
            'expertise_program'       => $request->query('expertise_program'),
            'expertise_concentration' => $request->query('expertise_concentration'),
            'school_status'           => $request->query('school_status'),
            'year'                    => $request->query('year'),
            'status'                  => $request->query('status'),
        ];
    }
}
