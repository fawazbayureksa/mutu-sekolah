{{-- ROW 1: 4 Primary KPI Cards --}}
<div class="row g-3 mb-4">
    {{-- Total Sekolah with Negeri vs Swasta Breakdown --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="text-muted small fw-medium">Total Sekolah</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_sekolah']) }}</h2>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-building fs-5"></i>
                </div>
            </div>
            {{-- Status Split Bar --}}
            <div class="status-split-bar mb-2">
                <div style="width: {{ $stats['negeri_percent'] }}%; background-color: #0e4a66;"
                    title="Negeri {{ $stats['negeri_percent'] }}%"></div>
                <div style="width: {{ $stats['swasta_percent'] }}%; background-color: #64748b;"
                    title="Swasta {{ $stats['swasta_percent'] }}%"></div>
                @if ($stats['null_percent'] > 0)
                    <div style="width: {{ $stats['null_percent'] }}%; background-color: #cbd5e1;"
                        title="Tidak Diketahui {{ $stats['null_percent'] }}%"></div>
                @endif
            </div>
            <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.7rem;">
                <span>Negeri: <strong class="text-dark">{{ $stats['negeri_percent'] }}%</strong> ({{ $stats['negeri_count'] }})</span>
                <span>Swasta: <strong class="text-dark">{{ $stats['swasta_percent'] }}%</strong> ({{ $stats['swasta_count'] }})</span>
                @if ($stats['null_percent'] > 0)
                    <span>Lainnya: <strong class="text-dark">{{ $stats['null_percent'] }}%</strong> ({{ $stats['null_count'] }})</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Total Pengajuan --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium">Total Pengajuan</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_submission']) }}</h2>
                    <small class="text-muted d-block mt-1">Instrumen diterima</small>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-journal-text fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Bidang Keahlian --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium">Bidang Keahlian</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_bidang']) }}</h2>
                    <small class="text-muted d-block mt-1">Kategori bidang aktif</small>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-layers fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Konsentrasi Keahlian --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-medium">Konsentrasi Keahlian</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_konsentrasi']) }}</h2>
                    <small class="text-muted d-block mt-1">Konsentrasi terdata</small>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-diagram-3 fs-5"></i>
                </div>
            </div>
        </div>
    </div>
</div>