{{-- 4 Primary Summary Metric Cards for Tata Kelola --}}
<div class="row g-3 mb-4">
    {{-- Total Mitra Industri --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100 border-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="text-muted small fw-medium">Kerja Sama Industri (C.1)</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_mitra']) }}</h2>
                </div>
                <div class="kpi-icon-wrapper text-primary bg-primary-subtle rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="bi bi-buildings fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem;">
                <span>Mitra Aktif: <strong class="text-success">{{ $industri['mou_aktif_pct'] }}%</strong></span>
                <span>Avg Durasi: <strong>{{ $industri['avg_duration'] }} Thn</strong></span>
            </div>
        </div>
    </div>

    {{-- Unit Produksi / TEFA --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100 border-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="text-muted small fw-medium">Teaching Factory / TEFA (C.2)</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_tefa_unit']) }}</h2>
                </div>
                <div class="kpi-icon-wrapper text-info bg-info-subtle rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="bi bi-shop fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem;">
                <span>Standarisasi: <strong>{{ $tefa['standarisasi_pct'] }}%</strong></span>
                <span>Ber-HAKI: <strong>{{ $tefa['haki_pct'] }}%</strong></span>
            </div>
        </div>
    </div>

    {{-- Pelatihan Guru Produktif --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100 border-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="text-muted small fw-medium">Guru Terlatih & Tersertifikasi (C.3.1)</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_guru_trained']) }}</h2>
                </div>
                <div class="kpi-icon-wrapper text-warning bg-warning-subtle rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="bi bi-person-badge fs-5"></i>
                </div>
            </div>
            <small class="text-muted d-block" style="font-size: 0.75rem;">
                Tercatat di {{ number_format($stats['total_schools']) }} sekolah terfilter
            </small>
        </div>
    </div>

    {{-- Rasio Guru : Murid --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100 border-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="text-muted small fw-medium">Rasio Guru:Murid (G:M) (C.3.3)</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ $stats['avg_ratio_gm'] }}</h2>
                </div>
                <div class="kpi-icon-wrapper {{ $stats['is_ratio_ideal'] ? 'text-success bg-success-subtle' : 'text-danger bg-danger-subtle' }} rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="bi {{ $stats['is_ratio_ideal'] ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' }} fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between" style="font-size: 0.75rem;">
                <span class="text-muted">Target Ideal: 1:15.0</span>
                <span class="badge {{ $stats['is_ratio_ideal'] ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} border-0">
                    {{ $stats['is_ratio_ideal'] ? 'Sangat Memadai' : 'Perlu Perhatian' }}
                </span>
            </div>
        </div>
    </div>
</div>
