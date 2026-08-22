@extends('layouts.admin')

@section('title', 'Mutu Peserta Didik - Kategori Keahlian - Dashboard Mutu SMK')

@push('styles')
    <style>
        .card-kpi-sub {
            border-radius: 14px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-kpi-sub:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06) !important;
        }

        .nav-pills-custom .nav-link {
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
            font-size: 0.875rem;
            color: #475569;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            margin-right: 8px;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }

        .nav-pills-custom .nav-link:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .nav-pills-custom .nav-link.active {
            background: #0066cc;
            color: #ffffff;
            border-color: #0066cc;
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.25);
        }

        .bmw-card {
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 18px;
            height: 100%;
        }

        .badge-gap-positive {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
            font-weight: 600;
        }

        .badge-gap-negative {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-0">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.overview') }}">Dashboard Mutu</a></li>
                        <li class="breadcrumb-item active">Mutu Peserta Didik</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.5px;">Mutu Peserta Didik per Kategori Keahlian</h3>
            </div>

            @if (!empty($filters['expertise']))
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2">
                        <i class="bi bi-layers-fill me-1"></i> Bidang: <strong>{{ $filters['expertise'] }}</strong>
                    </span>
                </div>
            @endif
        </div>

        {{-- Global Filter Bar --}}
        <x-dashboard.filter-bar :action="route('admin.dashboard.peserta-didik.index')" :provinces="$provinces" :regencies="$regencies" :expertises="$expertises"
            :years="$years" :filters="$filters" />

        {{-- 5 High-Level Aggregated KPI Cards --}}
        <div class="row g-3 mb-4">
            {{-- A.1.1 UKK Pass Rate --}}
            <div class="col-12 col-sm-6 col-xl">
                <div class="card card-kpi-sub shadow-sm border-0 bg-white p-3 h-100">
                    <span class="text-uppercase fw-semibold text-muted small" style="font-size: 0.7rem;">A.1.1 Rata-rata UKK</span>
                    <h3 class="fw-bold mb-0 mt-1 text-primary">{{ $kpis['avg_ukk_rate'] }}%</h3>
                    <small class="text-muted d-block mt-1">
                        {{ number_format($kpis['total_ukk_passed']) }} lulus / {{ number_format($kpis['total_ukk_participants']) }} peserta
                    </small>
                </div>
            </div>

            {{-- A.1.2 Skema Sertifikasi KKNI --}}
            <div class="col-12 col-sm-6 col-xl">
                <div class="card card-kpi-sub shadow-sm border-0 bg-white p-3 h-100">
                    <span class="text-uppercase fw-semibold text-muted small" style="font-size: 0.7rem;">A.1.2 Total Skema KKNI</span>
                    <h3 class="fw-bold mb-0 mt-1 text-dark">{{ number_format($kpis['total_certification_schemes']) }}</h3>
                    <small class="text-muted d-block mt-1">Skema sertifikasi terdaftar</small>
                </div>
            </div>

            {{-- A.2.1 Tracer Study BMW --}}
            <div class="col-12 col-sm-6 col-xl">
                <div class="card card-kpi-sub shadow-sm border-0 bg-white p-3 h-100">
                    <span class="text-uppercase fw-semibold text-muted small" style="font-size: 0.7rem;">A.2.1 Tracer Study (BMW)</span>
                    <h3 class="fw-bold mb-0 mt-1 text-success">{{ $kpis['avg_tracer_rate'] }}%</h3>
                    <small class="text-muted d-block mt-1">
                        Bekerja {{ $kpis['employed_rate'] }}% &bull; Wirausaha {{ $kpis['entrepreneur_rate'] }}%
                    </small>
                </div>
            </div>

            {{-- A.3 Putus Sekolah --}}
            <div class="col-12 col-sm-6 col-xl">
                <div class="card card-kpi-sub shadow-sm border-0 bg-white p-3 h-100">
                    <span class="text-uppercase fw-semibold text-muted small" style="font-size: 0.7rem;">A.3 Angka Putus Sekolah</span>
                    <h3 class="fw-bold mb-0 mt-1 {{ $kpis['avg_dropout_rate'] > 3 ? 'text-danger' : 'text-dark' }}">
                        {{ $kpis['avg_dropout_rate'] }}%
                    </h3>
                    <small class="text-muted d-block mt-1">{{ number_format($kpis['total_dropout_count']) }} total siswa putus sekolah</small>
                </div>
            </div>

            {{-- A.4 Skor TKA Gap --}}
            <div class="col-12 col-sm-6 col-xl">
                <div class="card card-kpi-sub shadow-sm border-0 bg-white p-3 h-100">
                    <span class="text-uppercase fw-semibold text-muted small" style="font-size: 0.7rem;">A.4 Nilai TKA (Gap vs Nas)</span>
                    <h3 class="fw-bold mb-0 mt-1 {{ $kpis['avg_tka_score'] >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $kpis['avg_tka_score'] >= 0 ? '+' : '' }}{{ number_format($kpis['avg_tka_score'], 2) }}
                    </h3>
                    <small class="text-muted d-block mt-1">Sekolah ({{ number_format($kpis['avg_tka_school'], 2) }}) vs Nas ({{ number_format($kpis['avg_tka_national'], 2) }})</small>
                </div>
            </div>
        </div>

        {{-- Main Category Tabs --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom p-3">
                <ul class="nav nav-pills nav-pills-custom" id="categoryTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-bidang-tab" data-bs-toggle="pill"
                            data-bs-target="#tab-bidang" type="button" role="tab">
                            <i class="bi bi-layers me-1"></i> Per Bidang Keahlian
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-konsentrasi-tab" data-bs-toggle="pill"
                            data-bs-target="#tab-konsentrasi" type="button" role="tab">
                            <i class="bi bi-mortarboard me-1"></i> Per Konsentrasi Keahlian
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-indikator-tab" data-bs-toggle="pill"
                            data-bs-target="#tab-indikator" type="button" role="tab">
                            <i class="bi bi-bar-chart-line me-1"></i> Analisis Indikator Aspek A
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-sekolah-tab" data-bs-toggle="pill"
                            data-bs-target="#tab-sekolah" type="button" role="tab">
                            <i class="bi bi-buildings me-1"></i> Direktori Pengajuan Sekolah
                            <span class="badge bg-light text-dark border ms-1">{{ $schoolList->total() }}</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="categoryTabsContent">

                    {{-- TAB 1: PER BIDANG KEAHLIAN --}}
                    <div class="tab-pane fade show active" id="tab-bidang" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Komparasi Capaian Mutu per Bidang Keahlian</h5>
                                <small class="text-muted">Rata-rata capaian indikator mutu siswa berdasarkan kategori bidang keahlian</small>
                            </div>
                        </div>

                        @if ($expertiseBreakdown->isEmpty())
                            <x-dashboard.empty-state message="Belum ada data bidang keahlian yang terdata." />
                        @else
                            <x-dashboard.data-table>
                                <x-slot:thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Bidang Keahlian</th>
                                        <th class="text-center">Jumlah Submission</th>
                                        <th class="text-center">Jumlah Sekolah</th>
                                        <th class="text-center">Rata-rata UKK</th>
                                        <th class="text-center">Tracer BMW</th>
                                        <th class="text-center">Putus Sekolah</th>
                                        <th class="text-center">Skor TKA (Gap)</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </x-slot:thead>

                                @foreach ($expertiseBreakdown as $idx => $item)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td>
                                            <strong class="text-dark">{{ $item->expertise }}</strong>
                                        </td>
                                        <td class="text-center font-monospace">{{ number_format($item->total_submissions) }}</td>
                                        <td class="text-center font-monospace">{{ number_format($item->total_schools) }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 fw-bold">
                                                {{ number_format((float) $item->avg_ukk_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 fw-bold">
                                                {{ number_format((float) $item->avg_tracer_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ (float) $item->avg_dropout_rate > 3 ? 'bg-danger text-white' : 'bg-light text-dark border' }}">
                                                {{ number_format((float) $item->avg_dropout_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php $tkaDiff = (float) $item->avg_tka_score; @endphp
                                            <span class="badge {{ $tkaDiff >= 0 ? 'badge-gap-positive' : 'badge-gap-negative' }}">
                                                {{ $tkaDiff >= 0 ? '+' : '' }}{{ number_format($tkaDiff, 2) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.dashboard.peserta-didik.index', array_merge($filters, ['expertise' => $item->expertise])) }}"
                                                class="btn btn-sm btn-outline-primary" title="Filter Khusus Bidang Ini">
                                                <i class="bi bi-funnel me-1"></i> Filter
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-dashboard.data-table>
                        @endif
                    </div>

                    {{-- TAB 2: PER KONSENTRASI KEAHLIAN --}}
                    <div class="tab-pane fade" id="tab-konsentrasi" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Komparasi Capaian Mutu per Konsentrasi Keahlian</h5>
                                <small class="text-muted">Capaian indikator mutu spesifik pada setiap konsentrasi / program keahlian</small>
                            </div>
                        </div>

                        @if ($concentrationBreakdown->isEmpty())
                            <x-dashboard.empty-state message="Belum ada data konsentrasi keahlian yang terdata." />
                        @else
                            <x-dashboard.data-table>
                                <x-slot:thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Konsentrasi Keahlian</th>
                                        <th>Bidang & Program</th>
                                        <th class="text-center">Submission</th>
                                        <th class="text-center">Sekolah</th>
                                        <th class="text-center">Rata-rata UKK</th>
                                        <th class="text-center">Tracer BMW</th>
                                        <th class="text-center">Putus Sekolah</th>
                                        <th class="text-center">Skor TKA (Gap)</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </x-slot:thead>

                                @foreach ($concentrationBreakdown as $idx => $item)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td>
                                            <strong class="text-dark">{{ $item->expertise_concentration }}</strong>
                                        </td>
                                        <td>
                                            <span class="small text-muted">{{ $item->expertise_program }} &bull; {{ $item->expertise }}</span>
                                        </td>
                                        <td class="text-center font-monospace">{{ number_format($item->total_submissions) }}</td>
                                        <td class="text-center font-monospace">{{ number_format($item->total_schools) }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 fw-bold">
                                                {{ number_format((float) $item->avg_ukk_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 fw-bold">
                                                {{ number_format((float) $item->avg_tracer_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ (float) $item->avg_dropout_rate > 3 ? 'bg-danger text-white' : 'bg-light text-dark border' }}">
                                                {{ number_format((float) $item->avg_dropout_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php $tkaDiff = (float) $item->avg_tka_score; @endphp
                                            <span class="badge {{ $tkaDiff >= 0 ? 'badge-gap-positive' : 'badge-gap-negative' }}">
                                                {{ $tkaDiff >= 0 ? '+' : '' }}{{ number_format($tkaDiff, 2) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.dashboard.peserta-didik.index', array_merge($filters, ['expertise_concentration' => $item->expertise_concentration])) }}"
                                                class="btn btn-sm btn-outline-primary" title="Filter Konsentrasi Ini">
                                                <i class="bi bi-funnel me-1"></i> Filter
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-dashboard.data-table>
                        @endif
                    </div>

                    {{-- TAB 3: ANALISIS INDIKATOR MUTU (A.1 - A.4) --}}
                    <div class="tab-pane fade" id="tab-indikator" role="tabpanel">
                        {{-- 3 BMW Pillar Cards --}}
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3">A.2.1 Rata-rata Penelusuran Alumni (Tracer Study BMW)</h6>
                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <div class="bmw-card">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded p-2 bg-primary bg-opacity-10 text-primary">
                                                    <i class="bi bi-briefcase fs-4"></i>
                                                </div>
                                                <strong class="text-dark">Bekerja (Karyawan)</strong>
                                            </div>
                                            <h4 class="fw-bold mb-0 text-primary">{{ $kpis['employed_rate'] }}%</h4>
                                        </div>
                                        <div class="progress mb-2" style="height: 6px;">
                                            <div class="progress-bar bg-primary" style="width: {{ min(100, $kpis['employed_rate']) }}%"></div>
                                        </div>
                                        <small class="text-muted d-block">Penyerapan industri / institusi kerja</small>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="bmw-card">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded p-2 bg-success bg-opacity-10 text-success">
                                                    <i class="bi bi-mortarboard fs-4"></i>
                                                </div>
                                                <strong class="text-dark">Melanjutkan Kuliah</strong>
                                            </div>
                                            <h4 class="fw-bold mb-0 text-success">{{ $kpis['continuing_rate'] }}%</h4>
                                        </div>
                                        <div class="progress mb-2" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: {{ min(100, $kpis['continuing_rate']) }}%"></div>
                                        </div>
                                        <small class="text-muted d-block">Studi lanjut perguruan tinggi</small>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="bmw-card">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded p-2 bg-warning bg-opacity-10 text-warning">
                                                    <i class="bi bi-shop fs-4"></i>
                                                </div>
                                                <strong class="text-dark">Wirausaha</strong>
                                            </div>
                                            <h4 class="fw-bold mb-0 text-warning">{{ $kpis['entrepreneur_rate'] }}%</h4>
                                        </div>
                                        <div class="progress mb-2" style="height: 6px;">
                                            <div class="progress-bar bg-warning" style="width: {{ min(100, $kpis['entrepreneur_rate']) }}%"></div>
                                        </div>
                                        <small class="text-muted d-block">Usaha mandiri & rintisan bisnis</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- TKA Subject Averages --}}
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">A.4 Nilai Rata-rata TKA (Tes Kemampuan Akademik) 2025</h6>
                                    <small class="text-muted">Perbandingan capaian nilai rata-rata sekolah terhadap standar nasional</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-light text-dark border">
                                        Rata-rata Sekolah: <strong>{{ number_format($kpis['avg_tka_school'], 2) }}</strong>
                                    </span>
                                    <span class="badge bg-light text-muted border">
                                        Rata-rata Nasional: <strong>{{ number_format($kpis['avg_tka_national'], 2) }}</strong>
                                    </span>
                                </div>
                            </div>

                            @php
                                $tkaSubjects = [
                                    ['type' => 'header',  'label' => 'Mata Pelajaran Wajib'],
                                    ['type' => 'subject', 'label' => 'Bahasa Indonesia',               'national_avg' => 55.38],
                                    ['type' => 'subject', 'label' => 'Matematika',                     'national_avg' => 36.10],
                                    ['type' => 'subject', 'label' => 'Bahasa Inggris',                 'national_avg' => 24.93],
                                    ['type' => 'header',  'label' => 'Mata Pelajaran Pilihan'],
                                    ['type' => 'subject', 'label' => 'PPKN',                           'national_avg' => 60.91],
                                    ['type' => 'subject', 'label' => 'Antropologi',                    'national_avg' => 70.43],
                                    ['type' => 'subject', 'label' => 'Projek Kreatif & Kewirausahaan', 'national_avg' => 56.34],
                                    ['type' => 'subject', 'label' => 'Bahasa Indonesia Lanjut',        'national_avg' => 68.02],
                                    ['type' => 'subject', 'label' => 'Matematika Lanjut',              'national_avg' => 39.32],
                                    ['type' => 'subject', 'label' => 'Bahasa Inggris Lanjut',          'national_avg' => 45.23],
                                    ['type' => 'subject', 'label' => 'Biologi',                        'national_avg' => 54.40],
                                    ['type' => 'subject', 'label' => 'Sosiologi',                      'national_avg' => 60.07],
                                    ['type' => 'subject', 'label' => 'Ekonomi',                        'national_avg' => 31.68],
                                    ['type' => 'subject', 'label' => 'Kimia',                          'national_avg' => 34.92],
                                    ['type' => 'subject', 'label' => 'Sejarah',                        'national_avg' => 62.72],
                                    ['type' => 'subject', 'label' => 'Fisika',                         'national_avg' => 37.65],
                                    ['type' => 'subject', 'label' => 'Geografi',                       'national_avg' => 70.36],
                                ];
                            @endphp

                            <x-dashboard.data-table>
                                <x-slot:thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Mata Pelajaran</th>
                                        <th class="text-center">Standar Nasional 2025</th>
                                        <th class="text-center">Rata-rata Sekolah Kategori Ini</th>
                                        <th class="text-center">Selisih (+ / -)</th>
                                    </tr>
                                </x-slot:thead>

                                @php $rowNum = 0; @endphp
                                @foreach ($tkaSubjects as $subj)
                                    @if ($subj['type'] === 'header')
                                        <tr class="table-light">
                                            <td colspan="5" class="fw-bold text-secondary small text-uppercase py-2"
                                                style="letter-spacing: 0.5px;">
                                                <i class="bi bi-bookmark-check me-1"></i>{{ $subj['label'] }}
                                            </td>
                                        </tr>
                                    @else
                                        @php
                                            $rowNum++;
                                            $natScore = (float) $subj['national_avg'];
                                            $schoolScore = $kpis['avg_tka_school'] > 0 ? (float) $kpis['avg_tka_school'] : null;
                                            $diff = !is_null($schoolScore) ? round($schoolScore - $natScore, 2) : null;
                                        @endphp
                                        <tr>
                                            <td>{{ $rowNum }}</td>
                                            <td><strong class="text-dark">{{ $subj['label'] }}</strong></td>
                                            <td class="text-center font-monospace">{{ number_format($natScore, 2) }}</td>
                                            <td class="text-center font-monospace">
                                                @if (!is_null($schoolScore))
                                                    <strong class="text-dark">{{ number_format($schoolScore, 2) }}</strong>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (!is_null($diff))
                                                    <span class="badge {{ $diff >= 0 ? 'badge-gap-positive' : 'badge-gap-negative' }}">
                                                        {{ $diff >= 0 ? '+' : '' }}{{ number_format($diff, 2) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </x-dashboard.data-table>
                        </div>
                    </div>

                    {{-- TAB 4: DIREKTORI PENGAJUAN SEKOLAH --}}
                    <div class="tab-pane fade" id="tab-sekolah" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Daftar Pengajuan Sekolah untuk Kategori Ini</h5>
                                <small class="text-muted">Rincian capaian per sekolah & pengajuan instrumen</small>
                            </div>
                        </div>

                        @if ($schoolList->isEmpty())
                            <x-dashboard.empty-state message="Tidak ada data pengajuan sekolah yang sesuai dengan filter." />
                        @else
                            <x-dashboard.data-table>
                                <x-slot:thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Sekolah & NPSN</th>
                                        <th>Wilayah</th>
                                        <th>Konsentrasi Keahlian</th>
                                        <th class="text-center">UKK (%)</th>
                                        <th class="text-center">Tracer (%)</th>
                                        <th class="text-center">Putus Sekolah (%)</th>
                                        <th class="text-center">Skor TKA</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </x-slot:thead>

                                @foreach ($schoolList as $idx => $row)
                                    <tr>
                                        <td>{{ $schoolList->firstItem() + $idx }}</td>
                                        <td>
                                            <strong class="text-dark d-block">{{ $row->school_name }}</strong>
                                            <small class="text-muted">NPSN: {{ $row->npsn ?: '-' }} &bull;
                                                <span class="badge bg-light text-dark border">{{ $row->school_status ?: 'Negeri' }}</span>
                                            </small>
                                        </td>
                                        <td>
                                            <span class="small text-muted">
                                                {{ $row->regency->name ?? '-' }}, {{ $row->province->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-dark d-block small">{{ $row->expertise_concentration ?: $row->expertise }}</strong>
                                            <small class="text-muted">{{ $row->expertise }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 fw-bold">
                                                {{ number_format((float) $row->ukk_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 fw-bold">
                                                {{ number_format((float) $row->tracer_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ (float) $row->dropout_rate > 3 ? 'bg-danger text-white' : 'bg-light text-dark border' }}">
                                                {{ number_format((float) $row->dropout_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php $tkaDiff = (float) $row->tka_score; @endphp
                                            <span class="badge {{ $tkaDiff >= 0 ? 'badge-gap-positive' : 'badge-gap-negative' }}">
                                                {{ $tkaDiff >= 0 ? '+' : '' }}{{ number_format($tkaDiff, 2) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            @if ($row->school_id)
                                                <a href="{{ route('admin.dashboard.kelembagaan.show', $row->school_id) }}"
                                                    class="btn btn-sm btn-outline-secondary" title="Buka Detail Sekolah">
                                                    <i class="bi bi-building"></i>
                                                </a>
                                            @endif
                                            @if ($row->submission_id)
                                                <a href="{{ route('admin.submissions-v2.show', $row->submission_id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Buka Form Instrumen">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </x-dashboard.data-table>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    Menampilkan {{ $schoolList->firstItem() }} - {{ $schoolList->lastItem() }} dari {{ $schoolList->total() }} data
                                </small>
                                <div>
                                    {{ $schoolList->links() }}
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
