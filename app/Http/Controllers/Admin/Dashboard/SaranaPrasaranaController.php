<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardQueryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaranaPrasaranaController extends Controller
{
    public function __construct(
        private readonly DashboardQueryService $queryService
    ) {}

    /**
     * Display Aspect B (Sarana Prasarana) Analytics Dashboard
     * Supports all Bidang Keahlian from config/constant.php and config/sapras_data.php
     */
    public function index(Request $request): View
    {
        $filters = $this->extractFilters($request);
        $activeTab = $request->query('tab', 'analisis');
        $catalogKey = $request->query('catalog_key', 'Teknik_Komputer_dan_Jaringan');

        // 1. Fetch Universal Sarana Prasarana Analytics
        $sarprasData = $this->queryService->getSaranaPrasaranaAnalytics($filters);

        // 2. Fetch Standard Sarpras Catalog from config/sapras_data.php
        $catalogData = $this->queryService->getSarprasStandardsCatalog($catalogKey);

        // 3. Dropdown options for Filter Bar
        $provinces = $this->queryService->getProvinceOptions();
        $regencies = $this->queryService->getRegencyOptions($filters['province_code'] ?? null);
        $expertises = $this->queryService->getExpertiseOptions();
        $concentrations = $this->queryService->getConcentrationOptions($filters['expertise'] ?? null);
        $years = $this->queryService->getAvailableYears();

        return view('admin.dashboard.sarana-prasarana.index', [
            'stats'               => $sarprasData['stats'],
            'expertiseDist'       => $sarprasData['expertise_distribution'],
            'activeConcentration' => $sarprasData['active_concentration'],
            'concentrationCards'  => $sarprasData['concentration_cards'],
            'comparisonMatrix'    => $sarprasData['comparison_matrix'],
            'priorities'          => $sarprasData['priorities'],
            'catalogData'         => $catalogData,
            'provinces'           => $provinces,
            'regencies'           => $regencies,
            'expertises'          => $expertises,
            'concentrations'      => $concentrations,
            'years'               => $years,
            'filters'             => $filters,
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
