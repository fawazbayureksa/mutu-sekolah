<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardQueryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OverviewController extends Controller
{
    public function __construct(
        private readonly DashboardQueryService $queryService
    ) {}

    public function index(Request $request): View
    {
        $filters = $this->extractFilters($request);

        return view('admin.dashboard.overview', [
            'stats'             => $this->queryService->getOverviewStats($filters),
            'expertiseDist'     => $this->queryService->getExpertiseDistribution($filters),
            'mutuSummary'       => $this->queryService->getMutuPesertaDidikSummary($filters),
            'sarprasSummary'    => $this->queryService->getSaranaPrasaranaSummary($filters),
            'tataKelolaSummary' => $this->queryService->getTataKelolaSummary($filters),
            'attentionCoverage' => $this->queryService->getAttentionAndCoverage($filters),
            'rekapitulasi'      => $this->queryService->getRekapitulasiList($filters, 10),
            'provinces'         => $this->queryService->getProvinceOptions(),
            'regencies'         => $this->queryService->getRegencyOptions($filters['province_code'] ?? null),
            'expertises'        => $this->queryService->getExpertiseOptions(),
            'years'             => $this->queryService->getAvailableYears(),
            'filters'           => $filters,
        ]);
    }

    private function extractFilters(Request $request): array
    {
        return $request->only([
            'province_code',
            'regency_code',
            'expertise',
            'status',
            'school_status',
            'year',
        ]);
    }
}
