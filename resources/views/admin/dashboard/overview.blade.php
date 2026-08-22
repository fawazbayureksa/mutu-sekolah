@extends('layouts.admin')

@section('title', 'Overview - Dashboard Mutu SMK')

@push('styles')
    <style>
        .card-kpi {
            border-radius: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-kpi:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15) !important;
        }

        .kpi-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .aspect-card {
            border-radius: 16px;
            background: #fff;
        }

        .aspect-header {
            padding: 16px 20px;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .aspect-item {
            padding: 12px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            transition: background 0.15s ease;
        }

        .aspect-item:hover {
            background-color: #f8fafc;
            color: inherit;
        }

        .aspect-item:last-child {
            border-bottom: none;
        }

        .aspect-progress-container {
            width: 100px;
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 999px;
            overflow: hidden;
        }

        .aspect-progress-fill {
            height: 100%;
            border-radius: 999px;
        }

        .aspect-footer {
            padding: 12px 20px;
            text-align: center;
            background-color: #fcfdfe;
            border-top: 1px solid #f1f5f9;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
        }

        .priority-item-card {
            background: #fff;
            border: 1px solid #fee2e2;
            border-radius: 12px;
            padding: 14px;
            height: 100%;
        }

        .chart-container-card {
            border-radius: 16px;
            background: #fff;
            padding: 20px;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-split-bar {
            height: 5px;
            border-radius: 3px;
            background-color: #f1f5f9;
            display: flex;
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-0">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <div>
                <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Overview</h3>
                {{-- <p class="text-muted small mb-0">Gambaran umum mutu SMK berdasarkan data terbaru</p> --}}
            </div>
            {{-- <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light rounded-circle position-relative p-2" title="Notifikasi">
                    <i class="bi bi-bell fs-5 text-secondary"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </button>
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-dark text-white p-2 d-flex align-items-center justify-content-center"
                        style="width: 38px; height: 38px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="d-none d-sm-block text-start">
                        <span class="d-block fw-bold small text-dark lh-1">Admin Pusat</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Super Administrator</small>
                    </div>
                </div>
            </div> --}}
        </div>

        {{-- Global Filter Bar --}}
        <x-dashboard.filter-bar :action="route('admin.dashboard.overview')" :provinces="$provinces" :regencies="$regencies" :expertises="$expertises" :years="$years"
            :filters="$filters" />

        {{-- ROW 1: 4 Primary KPI Cards --}}
        <div class="row g-3 mb-4">
            {{-- Total Sekolah with Negeri vs Swasta Breakdown --}}
            <div class="col-12 col-sm-6 col-xl-6">
                <div class="card card-kpi shadow-sm border-0 bg-white p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <span class="text-muted small fw-medium">Total Sekolah</span>
                            <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_sekolah']) }}</h2>
                        </div>
                        <div class="kpi-icon-wrapper" style="background-color: #ebf5ff; color: #0066cc;">
                            <i class="bi bi-building fs-4"></i>
                        </div>
                    </div>
                    {{-- Status Split Bar --}}
                    <div class="status-split-bar mb-2">
                        <div style="width: {{ $stats['negeri_percent'] }}%; background-color: #0066cc;"
                            title="Negeri {{ $stats['negeri_percent'] }}%"></div>
                        <div style="width: {{ $stats['swasta_percent'] }}%; background-color: #ea580c;"
                            title="Swasta {{ $stats['swasta_percent'] }}%"></div>
                        @if ($stats['null_percent'] > 0)
                            <div style="width: {{ $stats['null_percent'] }}%; background-color: #9ca3af;"
                                title="Tidak Diketahui {{ $stats['null_percent'] }}%"></div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center" style="font-size: 0.7rem;">
                        <span class="text-primary fw-semibold"><i class="bi bi-dot"></i>Negeri:
                            {{ $stats['negeri_percent'] }}% <span
                                class="text-muted fw-normal">({{ $stats['negeri_count'] }})</span></span>
                        <span class="text-danger fw-semibold"><i class="bi bi-dot"></i>Swasta:
                            {{ $stats['swasta_percent'] }}% <span
                                class="text-muted fw-normal">({{ $stats['swasta_count'] }})</span></span>
                        @if ($stats['null_percent'] > 0)
                            <span class="text-secondary fw-semibold"><i class="bi bi-dot"></i>Belum Diketahui:
                                {{ $stats['null_percent'] }}% <span
                                    class="text-muted fw-normal">({{ $stats['null_count'] }})</span></span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Total Submission --}}
            <div class="col-12 col-sm-6 col-xl-6">
                <div class="card card-kpi shadow-sm border-0 bg-white p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium">Total Submission</span>
                            <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_submission']) }}</h2>
                            <small class="text-muted d-block mt-1">Sekolah yang telah mengirimkan data</small>
                        </div>
                        <div class="kpi-icon-wrapper" style="background-color: #ecfdf5; color: #059669;">
                            <i class="bi bi-journal-text fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bidang Keahlian --}}
            <div class="col-12 col-sm-6 col-xl-6">
                <div class="card card-kpi shadow-sm border-0 bg-white p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium">Bidang Keahlian</span>
                            <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_bidang']) }}</h2>
                            <small class="text-muted d-block mt-1">Kategori keahlian aktif</small>
                        </div>
                        <div class="kpi-icon-wrapper" style="background-color: #f5f3ff; color: #7c3aed;">
                            <i class="bi bi-layers fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Konsentrasi Keahlian --}}
            <div class="col-12 col-sm-6 col-xl-6">
                <div class="card card-kpi shadow-sm border-0 bg-white p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-medium">Konsentrasi Keahlian</span>
                            <h2 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($stats['total_konsentrasi']) }}</h2>
                            <small class="text-muted d-block mt-1">keahlian aktif</small>
                        </div>
                        <div class="kpi-icon-wrapper" style="background-color: #fff7ed; color: #ea580c;">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 2: Distribusi Sekolah per Bidang Keahlian (Donut Chart + Breakdown) --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card chart-container-card shadow-sm border-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="fw-bold mb-0 text-dark">Distribusi Sekolah per Bidang Keahlian</h6>
                            <i class="bi bi-info-circle text-muted small"
                                title="Proporsi sebaran bidang keahlian sekolah"></i>
                        </div>
                        <span class="badge bg-light text-secondary border px-2 py-1 font-monospace"
                            style="font-size: 0.75rem;">
                            {{ $stats['total_bidang'] }} Kategori Keahlian
                        </span>
                    </div>

                    @if ($expertiseDist->isEmpty())
                        <x-dashboard.empty-state message="Belum ada data distribusi bidang keahlian." />
                    @else
                        <div class="row align-items-center py-2">
                            <div class="col-12 col-md-4 text-center position-relative mb-3 mb-md-0">
                                <div style="height: 220px; width: 220px; margin: 0 auto; position: relative;">
                                    <canvas id="expertiseDonutChart"></canvas>
                                    <div
                                        class="position-absolute top-50 start-50 translate-middle text-center pointer-events-none">
                                        <h3 class="fw-bold mb-0 text-dark lh-1">
                                            {{ number_format($stats['total_sekolah']) }}</h3>
                                        <small class="text-muted" style="font-size: 0.7rem;">Total Sekolah</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="row g-3">
                                    @php
                                        $donutColors = [
                                            '#0066cc',
                                            '#00bcd4',
                                            '#7c3aed',
                                            '#ff5722',
                                            '#ff9800',
                                            '#10b981',
                                            '#6366f1',
                                            '#ec4899',
                                        ];
                                    @endphp
                                    @foreach ($expertiseDist as $idx => $item)
                                        @php
                                            $dotColor = $donutColors[$idx % count($donutColors)];
                                        @endphp
                                        <div class="col-12 col-sm-6">
                                            <div
                                                class="p-3 bg-light rounded-3 border-0 d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2 text-truncate me-2">
                                                    <span class="legend-dot flex-shrink-0"
                                                        style="background-color: {{ $dotColor }};"></span>
                                                    <span class="text-dark small fw-semibold text-truncate"
                                                        title="{{ $item->expertise }}">{{ $item->expertise }}</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-3 flex-shrink-0 text-end">
                                                    <strong class="text-dark small">{{ $item->total_schools }} <span
                                                            class="fw-normal text-muted"
                                                            style="font-size: 0.7rem;">Sekolah</span></strong>
                                                    <span class="badge bg-white text-dark border shadow-2xs"
                                                        style="width: 50px;">{{ $item->percentage }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ROW 3: 3 Indikator Capaian Mutu Aspek (A, B, C) --}}
        <div class="row g-4 mb-4">

            {{-- <div class="col-12 col-lg-4">
                <div class="card aspect-card shadow-sm border-0 h-100 d-flex flex-column">
                    <div class="aspect-header text-primary border-bottom">
                        <i class="bi bi-mortarboard-fill"></i>
                        <span>Mutu Peserta Didik</span>
                    </div>
                    <div class="d-flex flex-column flex-grow-1">
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-file-earmark-check text-primary fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">UKK & Sertifikasi</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Tingkat Kelulusan UKK</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-primary"
                                        style="width: {{ $mutuSummary['ukk_rate'] }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $mutuSummary['ukk_rate'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>

                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-people text-primary fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">Tracer Study</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Kesesuaian Kerja Lulusan</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-primary"
                                        style="width: {{ $mutuSummary['tracer_rate'] }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $mutuSummary['tracer_rate'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>


                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-graph-down-arrow text-danger fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">Putus Sekolah</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Tingkat Putus Sekolah</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-danger"
                                        style="width: {{ $mutuSummary['dropout_rate'] * 10 }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $mutuSummary['dropout_rate'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>

                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-book text-primary fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">TKA (Rata-rata Skor)</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Rata-rata Skor TKA</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span
                                    class="badge bg-light text-primary border fw-bold px-2 py-1">{{ $mutuSummary['tka_score'] }}</span>
                                <i class="bi bi-chevron-right text-muted small ms-1"></i>
                            </div>
                        </a>
                    </div>
                    <div class="aspect-footer">
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}"
                            class="text-primary text-decoration-none small fw-semibold">
                            Lihat Selengkapnya <i class="bi bi-chevron-right small"></i>
                        </a>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-12 col-lg-4">
                <div class="card aspect-card shadow-sm border-0 h-100 d-flex flex-column">
                    <div class="aspect-header text-success border-bottom">
                        <i class="bi bi-buildings"></i>
                        <span>Sarana Prasarana</span>
                    </div>
                    <div class="d-flex flex-column flex-grow-1">
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-file-earmark-spreadsheet text-success fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">Kesiapan Fasilitas</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Checklist Kesiapan
                                        Fasilitas</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-success"
                                        style="width: {{ $sarprasSummary['facility_readiness'] }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $sarprasSummary['facility_readiness'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>

                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-tag text-success fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">Peralatan Praktik</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Kesesuaian Standar
                                        Industri</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-success"
                                        style="width: {{ $sarprasSummary['equipment_standard'] }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $sarprasSummary['equipment_standard'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>

                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-shield-check text-success fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">K3 & Keselamatan</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Implementasi K3</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-success"
                                        style="width: {{ $sarprasSummary['k3_compliance'] }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $sarprasSummary['k3_compliance'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>

                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-diagram-2 text-success fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">Infrastruktur</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Kondisi Infrastruktur</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-success"
                                        style="width: {{ $sarprasSummary['infrastructure_rate'] }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $sarprasSummary['infrastructure_rate'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>
                    </div>
                    <div class="aspect-footer">
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}"
                            class="text-success text-decoration-none small fw-semibold">
                            Lihat Selengkapnya <i class="bi bi-chevron-right small"></i>
                        </a>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-12 col-lg-4">
                <div class="card aspect-card shadow-sm border-0 h-100 d-flex flex-column">
                    <div class="aspect-header text-warning border-bottom">
                        <i class="bi bi-people-fill"></i>
                        <span class="text-dark">Tata Kelola</span>
                    </div>
                    <div class="d-flex flex-column flex-grow-1">
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-handshake text-warning fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">Kerja Sama Industri</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Kemitraan Aktif</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-warning"
                                        style="width: {{ $tataKelolaSummary['industry_collab'] }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $tataKelolaSummary['industry_collab'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-box-seam text-warning fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">Teaching Factory (TEFA)</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Unit Produksi Aktif</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-warning"
                                        style="width: {{ $tataKelolaSummary['tefa_rate'] }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $tataKelolaSummary['tefa_rate'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-person-badge text-warning fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">Kompetensi Guru</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Guru Tersertifikasi /
                                        Terlatih</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-warning"
                                        style="width: {{ $tataKelolaSummary['teacher_comp'] }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $tataKelolaSummary['teacher_comp'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="aspect-item">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="bi bi-person-lines-fill text-warning fs-5"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block small lh-1 mb-1">Ketenagaan</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Rasio Guru : Murid</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="aspect-progress-container">
                                    <div class="aspect-progress-fill bg-warning"
                                        style="width: {{ $tataKelolaSummary['staffing_ratio'] }}%;"></div>
                                </div>
                                <span class="fw-bold text-dark small"
                                    style="width: 45px; text-align: right;">{{ $tataKelolaSummary['staffing_ratio'] }}%</span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </div>
                        </a>
                    </div>
                    <div class="aspect-footer">
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}"
                            class="text-warning text-decoration-none small fw-semibold">
                            Lihat Selengkapnya <i class="bi bi-chevron-right small"></i>
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>

        {{-- ROW 4: Prioritas Perhatian & Data Cakupan --}}
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-12">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100 bg-white">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <h6 class="fw-bold text-dark mb-0">Prioritas Perhatian</h6>
                    </div>
                    <div class="row g-2 mb-3">
                        @foreach ($attentionCoverage['priorities'] as $priority)
                            <div class="col-12 col-md-4">
                                <div class="priority-item-card">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <strong class="text-dark small lh-1">{{ $priority['title'] }}</strong>
                                    </div>
                                    <p class="text-muted mb-0" style="font-size: 0.72rem; line-height: 1.35;">
                                        {{ $priority['description'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- <div class="mt-auto text-center pt-2">
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}"
                            class="text-danger small text-decoration-none fw-semibold">
                            Lihat Semua Prioritas <i class="bi bi-chevron-right small"></i>
                        </a>
                    </div> --}}
                </div>
            </div>

            {{-- Data & Cakupan --}}
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100 bg-white">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <h6 class="fw-bold text-dark mb-0">Data & Cakupan</h6>
                    </div>
                    <div class="row g-3 align-items-center my-auto">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 p-2 bg-light text-primary fs-4">
                                    <i class="bi bi-file-earmark-check-fill"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block" style="font-size: 0.7rem;">Total Submission</span>
                                    <strong
                                        class="text-dark small d-block">{{ number_format($attentionCoverage['total_submission']) }}</strong>
                                    <small class="text-muted" style="font-size: 0.68rem;">data instrumen masuk</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 p-2 bg-light text-primary fs-4">
                                    <i class="bi bi-database-fill"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block" style="font-size: 0.7rem;">Kelengkapan Data</span>
                                    <strong class="text-dark small d-block">Rata-rata:
                                        {{ $attentionCoverage['avg_completion'] }}%</strong>
                                    <small class="text-muted" style="font-size: 0.68rem;">tingkat isian instrumen</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 p-2 bg-light text-primary fs-4">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block" style="font-size: 0.7rem;">Update Terakhir</span>
                                    <strong class="text-dark small d-block"
                                        style="font-size: 0.75rem;">{{ $attentionCoverage['last_update'] }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="mt-auto text-center pt-3">
                        <a href="{{ route('admin.dashboard.kelembagaan.index') }}"
                            class="text-primary small text-decoration-none fw-semibold">
                            Metodologi & Penjelasan <i class="bi bi-chevron-right small"></i>
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Load Chart.js from CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Expertise Donut Chart
            const donutCtx = document.getElementById('expertiseDonutChart');
            if (donutCtx) {
                const donutLabels = {!! json_encode($expertiseDist->pluck('expertise')) !!};
                const donutData = {!! json_encode($expertiseDist->pluck('total_schools')) !!};
                const donutColors = ['#0066cc', '#00bcd4', '#7c3aed', '#ff5722', '#ff9800', '#10b981', '#6366f1',
                    '#ec4899'
                ];

                new Chart(donutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: donutLabels,
                        datasets: [{
                            data: donutData,
                            backgroundColor: donutColors.slice(0, donutLabels.length),
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return ` ${context.label}: ${context.raw} Sekolah`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
