@extends('layouts.admin')

@section('title', 'Laporan - Panel Admin')

@push('styles')
    <style>
        /* ── Stat Cards ── */
        .stat-card {
            border-left: 4px solid;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .1);
        }

        .stat-card.primary {
            border-color: #4e73df;
        }

        .stat-card.success {
            border-color: #1cc88a;
        }

        .stat-card.info {
            border-color: #36b9cc;
        }

        .stat-card.warning {
            border-color: #f6c23e;
        }

        .stat-card .icon {
            font-size: 2rem;
            opacity: .25;
        }

        .stat-card .label {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .stat-card .value {
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* ── Hierarchical Table ── */
        .laporan-table thead th {
            background: #f8f9fc;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            vertical-align: middle;
        }

        .laporan-table td {
            vertical-align: middle;
        }

        .cell-bidang {
            font-weight: 700;
            background: #eef2ff;
            color: #364fc7;
            border-left: 4px solid #4e73df;
        }

        .cell-program {
            font-weight: 600;
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #1cc88a;
            padding-left: 1.25rem;
        }

        .cell-konsentrasi {
            padding-left: 1.75rem;
            color: #495057;
        }

        .badge-total {
            font-size: .85rem;
            font-weight: 600;
            min-width: 2.5rem;
        }

        /* ── Filter card ── */
        .filter-card {
            border-top: 3px solid #4e73df;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        {{-- ── Header ── --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">
                    <i class="bi bi-bar-chart-line me-2 text-primary"></i>Laporan
                </h1>
                <p class="text-muted mb-0">
                    Rekapitulasi sekolah berdasarkan Bidang, Program, dan Konsentrasi Keahlian
                </p>
            </div>
        </div>

        {{-- ── Summary stat cards ── --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card primary shadow-sm h-100 py-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="label text-primary">Total Sekolah</div>
                            <div class="value text-gray-800">{{ number_format($stats['total_sekolah']) }}</div>
                        </div>
                        <i class="bi bi-building icon text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card success shadow-sm h-100 py-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="label text-success">Bidang Keahlian</div>
                            <div class="value text-gray-800">{{ number_format($stats['total_bidang']) }}</div>
                        </div>
                        <i class="bi bi-diagram-3 icon text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card info shadow-sm h-100 py-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="label text-info">Program Keahlian</div>
                            <div class="value text-gray-800">{{ number_format($stats['total_program']) }}</div>
                        </div>
                        <i class="bi bi-collection icon text-info"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card warning shadow-sm h-100 py-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="label text-warning">Konsentrasi Keahlian</div>
                            <div class="value text-gray-800">{{ number_format($stats['total_konsentrasi']) }}</div>
                        </div>
                        <i class="bi bi-list-nested icon text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Filter card ── --}}
        <div class="card filter-card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.laporan.index') }}" method="GET" id="filter-form"
                    class="row g-2 align-items-end">

                    {{-- Province --}}
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold mb-1">Provinsi</label>
                        <select name="province_code" id="province-select" class="form-select form-select-sm">
                            <option value="">Semua Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->code }}"
                                    {{ $provinceCode === $province->code ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Regency --}}
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold mb-1">Kabupaten / Kota</label>
                        <select name="regency_code" id="regency-select" class="form-select form-select-sm">
                            <option value="">Semua Kab/Kota</option>
                            @foreach ($regencies as $regency)
                                <option value="{{ $regency->code }}"
                                    {{ $regencyCode === $regency->code ? 'selected' : '' }}>
                                    {{ $regency->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold mb-1">Status Pengajuan</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="submitted" {{ $status === 'submitted' ? 'selected' : '' }}>Diajukan</option>
                            <option value="verified" {{ $status === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="validated" {{ $status === 'validated' ? 'selected' : '' }}>Tervalidasi</option>
                            <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-fill">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </a>
                    </div>

                </form>
            </div>
        </div>

        {{-- ── Report table ── --}}
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h6 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-table me-1"></i>
                    Rekapitulasi per Keahlian
                </h6>
                @if ($provinceCode || $regencyCode || $status)
                    <span class="badge bg-primary bg-opacity-10 text-primary">Filter aktif</span>
                @endif
            </div>
            <div class="card-body p-0">
                @if ($grouped->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                        <p class="mb-0">Belum ada data untuk ditampilkan.</p>
                        @if ($provinceCode || $regencyCode || $status)
                            <small>Coba ubah atau reset filter di atas.</small>
                        @endif
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover laporan-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th style="width:22%">Bidang Keahlian</th>
                                    <th style="width:27%">Program Keahlian</th>
                                    <th style="width:27%">Konsentrasi Keahlian</th>
                                    <th style="width:9%" class="text-center">Total Sekolah</th>
                                    <th style="width:10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp

                                @foreach ($grouped as $bidang => $programs)
                                    @php
                                        $bidangRowspan = $programs->sum(fn($p) => $p->count());
                                        $bidangFirst = true;
                                    @endphp

                                    @foreach ($programs as $program => $concentrations)
                                        @php
                                            $programRowspan = $concentrations->count();
                                            $programFirst = true;
                                        @endphp

                                        @foreach ($concentrations as $row)
                                            <tr>
                                                {{-- No column (only on first row of each bidang) --}}
                                                @if ($bidangFirst && $programFirst)
                                                    <td rowspan="{{ $bidangRowspan }}" class="text-center fw-bold">
                                                        {{ $no++ }}
                                                    </td>
                                                @endif

                                                {{-- Bidang Keahlian (rowspan entire bidang block) --}}
                                                @if ($bidangFirst && $programFirst)
                                                    <td rowspan="{{ $bidangRowspan }}" class="cell-bidang">
                                                        {{ $bidang ?: '-' }}
                                                    </td>
                                                @endif

                                                {{-- Program Keahlian (rowspan all concentrations in program) --}}
                                                @if ($programFirst)
                                                    <td rowspan="{{ $programRowspan }}" class="cell-program">
                                                        {{ $program ?: '-' }}
                                                    </td>
                                                @endif

                                                {{-- Konsentrasi Keahlian --}}
                                                <td class="cell-konsentrasi">
                                                    {{ $row->expertise_concentration ?: '-' }}
                                                </td>

                                                {{-- Total Sekolah --}}
                                                <td class="text-center text-bold">
                                                    {{ number_format($row->total_sekolah) }}
                                                </td>

                                                {{-- Detail button --}}
                                                <td class="text-center">
                                                    <a href="{{ route('admin.laporan.detail', array_filter([
                                                        'expertise'               => $row->expertise,
                                                        'expertise_program'       => $row->expertise_program,
                                                        'expertise_concentration' => $row->expertise_concentration,
                                                        'province_code'           => $provinceCode,
                                                        'regency_code'            => $regencyCode,
                                                        'status'                  => $status,
                                                    ])) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Lihat daftar sekolah">
                                                        <i class="bi bi-eye me-1"></i>Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $bidangFirst = false;
                                                $programFirst = false;
                                            @endphp
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            @unless ($grouped->isEmpty())
                <div class="card-footer text-muted small py-2 px-3">
                    {{ $grouped->sum(fn($p) => $p->sum(fn($c) => $c->count())) }} baris ditampilkan &mdash;
                    {{ $grouped->count() }} bidang keahlian
                </div>
            @endunless
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // No auto-submit — form is submitted only when the user clicks the Filter button.
        });
    </script>
@endpush
