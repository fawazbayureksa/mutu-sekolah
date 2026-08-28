{{-- 4 Primary Summary Metric Cards --}}
<div class="row g-3 mb-4">
    {{-- Total Pengajuan & Sekolah --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="text-muted small fw-medium">Total Pengajuan Data</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($analytics['total_submissions']) }}</h2>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-journal-check fs-5"></i>
                </div>
            </div>
            <small class="text-muted d-block" style="font-size: 0.75rem;">
                Mencakup <strong>{{ number_format($analytics['total_schools']) }}</strong> sekolah terdata
            </small>
        </div>
    </div>

    {{-- Rata-rata Kelulusan UKK --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="text-muted small fw-medium">Kelulusan UKK</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($kpis['avg_ukk_rate'], 1) }}%</h2>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-award fs-5"></i>
                </div>
            </div>
            <small class="text-muted d-block" style="font-size: 0.75rem;">
                {{ number_format($kpis['total_ukk_passed']) }} lulus dari {{ number_format($kpis['total_ukk_participants']) }} peserta
            </small>
        </div>
    </div>

    {{-- Penyerapan Tracer BMW --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="text-muted small fw-medium">Keterserapan Lulusan (BMW)</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($kpis['avg_tracer_rate'], 1) }}%</h2>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-briefcase fs-5"></i>
                </div>
            </div>
            <small class="text-muted d-block" style="font-size: 0.75rem;">
                Bekerja: {{ $kpis['employed_rate'] }}% &bull; Wirausaha: {{ $kpis['entrepreneur_rate'] }}%
            </small>
        </div>
    </div>

    {{-- Angka Putus Sekolah --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-kpi shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="text-muted small fw-medium">Angka Putus Sekolah</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($kpis['avg_dropout_rate'], 2) }}%</h2>
                </div>
                <div class="kpi-icon-wrapper">
                    <i class="bi bi-person-x fs-5"></i>
                </div>
            </div>
            <small class="text-muted d-block" style="font-size: 0.75rem;">
                {{ number_format($kpis['total_dropout_count']) }} total siswa putus sekolah
            </small>
        </div>
    </div>
</div>
