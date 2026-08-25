<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardQueryService;
use App\Services\Dashboard\TataKelolaAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TataKelolaController extends Controller
{
    public function __construct(
        private readonly DashboardQueryService $queryService,
        private readonly TataKelolaAnalyticsService $analyticsService
    ) {}

    /**
     * Display Aspect C (Tata Kelola) Analytics Dashboard
     */
    public function index(Request $request): View
    {
        $filters = $this->extractFilters($request);

        // Fetch comprehensive Tata Kelola analytics across the 4 pillars
        $tataKelolaData = $this->analyticsService->getTataKelolaAnalytics($filters);

        // Options for Filter Bar
        $provinces = $this->queryService->getProvinceOptions();
        $regencies = $this->queryService->getRegencyOptions($filters['province_code'] ?? null);
        $expertises = $this->queryService->getExpertiseOptions();
        $concentrations = $this->queryService->getConcentrationOptions($filters['expertise'] ?? null);
        $years = $this->queryService->getAvailableYears();

        return view('admin.dashboard.tata-kelola.index', [
            'stats'          => $tataKelolaData['stats'],
            'industri'       => $tataKelolaData['industri'],
            'tefa'           => $tataKelolaData['tefa'],
            'guru'           => $tataKelolaData['guru'],
            'ketenagaan'     => $tataKelolaData['ketenagaan'],
            'totalSub'       => $tataKelolaData['total_sub'],
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
