{{-- ROW 1: 4 Primary KPI Cards --}}
<div class="row g-3 mb-4">
    {{-- Kesiapan Fasilitas --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium">Kesiapan Fasilitas</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ $stats['avg_facility_readiness'] }}%</h2>
                    <small class="text-muted d-block mt-1">Kelengkapan ruang & sarana</small>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-building-check fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Standar Peralatan Praktik --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium">Standar Peralatan Praktik</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ $stats['avg_equipment_standard'] }}%</h2>
                    <small class="text-muted d-block mt-1">Kesesuaian standar industri</small>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-tools fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Kepatuhan K3 & Keselamatan --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium">Kepatuhan K3 & Safety</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ $stats['avg_k3_compliance'] }}%</h2>
                    <small class="text-muted d-block mt-1">Standar proteksi & keselamatan</small>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-shield-check fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Kelengkapan SOP Praktik --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium">Kelengkapan SOP Praktik</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ $stats['sop_compliance_rate'] }}%</h2>
                    <small class="text-muted d-block mt-1">Ketersediaan SOP penggunaan alat</small>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-file-earmark-check fs-5"></i>
                </div>
            </div>
        </div>
    </div>
</div>
