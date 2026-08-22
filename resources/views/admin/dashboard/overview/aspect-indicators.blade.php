{{-- ROW 3: 3 Indikator Capaian Mutu Aspek (A, B, C) --}}
<div class="row g-4 mb-4">
    {{-- Aspek A: Mutu Peserta Didik --}}
    <div class="col-12 col-lg-4">
        <div class="card aspect-card shadow-sm h-100 d-flex flex-column">
            <div class="aspect-header">
                <span>Mutu Peserta Didik</span>
            </div>
            <div class="d-flex flex-column flex-grow-1">
                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">UKK & Sertifikasi</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Tingkat Kelulusan UKK</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ $mutuSummary['ukk_rate'] }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $mutuSummary['ukk_rate'] }}%</span>
                    </div>
                </div>

                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">Tracer Study</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Kesesuaian Kerja Lulusan</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ $mutuSummary['tracer_rate'] }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $mutuSummary['tracer_rate'] }}%</span>
                    </div>
                </div>

                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">Putus Sekolah</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Tingkat Putus Sekolah</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ min(100, $mutuSummary['dropout_rate'] * 10) }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $mutuSummary['dropout_rate'] }}%</span>
                    </div>
                </div>

                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">TKA (Rata-rata Skor)</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Rata-rata Skor TKA</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark border fw-bold px-2 py-1">
                            {{ $mutuSummary['tka_score'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Aspek B: Sarana Prasarana --}}
    <div class="col-12 col-lg-4">
        <div class="card aspect-card shadow-sm h-100 d-flex flex-column">
            <div class="aspect-header">
                <span>Sarana Prasarana</span>
            </div>
            <div class="d-flex flex-column flex-grow-1">
                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">Kesiapan Fasilitas</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Checklist Kesiapan Fasilitas</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ $sarprasSummary['facility_readiness'] }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $sarprasSummary['facility_readiness'] }}%</span>
                    </div>
                </div>

                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">Peralatan Praktik</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Kesesuaian Standar Industri</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ $sarprasSummary['equipment_standard'] }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $sarprasSummary['equipment_standard'] }}%</span>
                    </div>
                </div>

                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">K3 & Keselamatan</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Implementasi K3</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ $sarprasSummary['k3_compliance'] }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $sarprasSummary['k3_compliance'] }}%</span>
                    </div>
                </div>

                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">Infrastruktur</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Kondisi Infrastruktur</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ $sarprasSummary['infrastructure_rate'] }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $sarprasSummary['infrastructure_rate'] }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Aspek C: Tata Kelola --}}
    <div class="col-12 col-lg-4">
        <div class="card aspect-card shadow-sm h-100 d-flex flex-column">
            <div class="aspect-header">
                <span>Tata Kelola</span>
            </div>
            <div class="d-flex flex-column flex-grow-1">
                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">Kerja Sama Industri</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Kemitraan Aktif</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ $tataKelolaSummary['industry_collab'] }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $tataKelolaSummary['industry_collab'] }}%</span>
                    </div>
                </div>

                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">Teaching Factory (TEFA)</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Unit Produksi Aktif</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ $tataKelolaSummary['tefa_rate'] }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $tataKelolaSummary['tefa_rate'] }}%</span>
                    </div>
                </div>

                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">Kompetensi Guru</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Guru Tersertifikasi / Terlatih</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ $tataKelolaSummary['teacher_comp'] }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $tataKelolaSummary['teacher_comp'] }}%</span>
                    </div>
                </div>

                <div class="aspect-item">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-dark d-block small lh-1 mb-1">Ketenagaan</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Rasio Guru : Murid</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="aspect-progress-container">
                            <div class="aspect-progress-fill"
                                style="width: {{ $tataKelolaSummary['staffing_ratio'] }}%;"></div>
                        </div>
                        <span class="fw-bold text-dark small"
                            style="width: 45px; text-align: right;">{{ $tataKelolaSummary['staffing_ratio'] }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>