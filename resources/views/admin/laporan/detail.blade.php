@extends('layouts.admin')

@section('title', 'Detail Laporan - Panel Admin')

@push('styles')
    <style>
        /* ── Breadcrumb bar ── */
        .breadcrumb-bar {
            background: #f8f9fc;
            border-left: 4px solid #4e73df;
            border-radius: 0 .375rem .375rem 0;
            padding: .75rem 1rem;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-bar .breadcrumb {
            margin-bottom: 0;
            font-size: .875rem;
        }

        /* ── Context badge group ── */
        .context-badges .badge {
            font-size: .82rem;
            font-weight: 500;
            letter-spacing: .02em;
        }

        /* ── Table ── */
        .detail-table thead th {
            background: #f8f9fc;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            vertical-align: middle;
        }

        .detail-table td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        {{-- ── Breadcrumb ── --}}
        <div class="breadcrumb-bar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route(
                                'admin.laporan.index',
                                array_filter([
                                    'province_code' => $provinceCode,
                                    'regency_code' => $regencyCode,
                                    'status' => $status,
                                ]),
                            ) }}">
                            <i class="bi bi-bar-chart-line me-1"></i>Laporan
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Sekolah</li>
                </ol>
            </nav>
        </div>

        {{-- ── Header ── --}}
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div>
                <h1 class="h3 mb-1 text-gray-800">
                    <i class="bi bi-building me-2 text-primary"></i>Detail Sekolah
                </h1>
                <p class="text-muted mb-0">Daftar sekolah berdasarkan keahlian yang dipilih</p>
            </div>
            <a href="{{ route(
                'admin.laporan.index',
                array_filter([
                    'province_code' => $provinceCode,
                    'regency_code' => $regencyCode,
                    'status' => $status,
                ]),
            ) }}"
                class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Laporan
            </a>
        </div>

        {{-- ── Context info ── --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="row g-3 context-badges">
                    <div class="col-md-4">
                        <div class="small text-muted fw-semibold mb-1">
                            <i class="bi bi-diagram-3 me-1 text-primary"></i>Bidang Keahlian
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary">
                            {{ $expertise ?: '-' }}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <div class="small text-muted fw-semibold mb-1">
                            <i class="bi bi-collection me-1 text-success"></i>Program Keahlian
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success">
                            {{ $expertiseProgram ?: '-' }}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <div class="small text-muted fw-semibold mb-1">
                            <i class="bi bi-list-nested me-1 text-warning"></i>Konsentrasi Keahlian
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning">
                            {{ $expertiseConcentration ?: '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── School List Table ── --}}
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h6 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-table me-1"></i>Daftar Sekolah
                </h6>
                <span class="badge bg-primary">
                    {{ $submissions->total() }} sekolah ditemukan
                </span>
            </div>
            <div class="card-body p-0">
                @if ($submissions->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                        <p class="mb-0">Tidak ada data sekolah untuk keahlian ini.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover detail-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th style="width:25%">Nama Sekolah</th>
                                    <th style="width:12%">NPSN</th>
                                    <th style="width:20%">Alamat</th>
                                    <th style="width:15%">Provinsi</th>
                                    <th style="width:13%">Kab / Kota</th>
                                    <th style="width:10%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submissions as $index => $submission)
                                    <tr>
                                        <td class="text-center">
                                            {{ $submissions->firstItem() + $index }}
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $submission->school_name }}</div>
                                            @if ($submission->respondent_name)
                                                <small class="text-muted">
                                                    {{ $submission->respondent_name }}
                                                    @if ($submission->respondent_position)
                                                        &mdash; {{ $submission->respondent_position }}
                                                    @endif
                                                </small>
                                            @endif
                                        </td>
                                        <td class="text-muted">{{ $submission->npsn ?: '-' }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ Str::limit($submission->address, 60) ?: '-' }}
                                            </small>
                                        </td>
                                        <td>{{ $submission->province?->name ?? ($submission->province_code ?? '-') }}</td>
                                        <td>{{ $submission->regency?->name ?? ($submission->regency_code ?? '-') }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $submission->getStatusBadgeClass() }}">
                                                {{ $submission->getStatusLabel() }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            @unless ($submissions->isEmpty())
                <div class="card-footer d-flex align-items-center justify-content-between py-2 px-3">
                    <div class="text-muted small">
                        Menampilkan {{ $submissions->firstItem() }}–{{ $submissions->lastItem() }}
                        dari {{ $submissions->total() }} data
                    </div>
                    {{ $submissions->links() }}
                </div>
            @endunless
        </div>

    </div>
@endsection
