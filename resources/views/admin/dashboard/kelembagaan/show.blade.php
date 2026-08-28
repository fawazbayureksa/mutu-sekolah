@extends('layouts.admin')

@section('title', $school->school_name . ' - Detail Kelembagaan')

@push('styles')
    <style>
        .tree-branch {
            position: relative;
            padding-left: 20px;
            border-left: 2px solid #dee2e6;
            margin-left: 10px;
        }

        .tree-branch::before {
            content: '';
            position: absolute;
            top: 14px;
            left: 0;
            width: 14px;
            height: 2px;
            background-color: #dee2e6;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-0">
        {{-- Breadcrumb & Back button --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.overview') }}">Dashboard Mutu</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.kelembagaan.index') }}">Kelembagaan</a>
                    </li>
                    <li class="breadcrumb-item active text-truncate" style="max-width: 250px;">{{ $school->school_name }}</li>
                </ol>
            </nav>
            <a href="{{ route('admin.dashboard.kelembagaan.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Direktori
            </a>
        </div>

        {{-- School Identity Card --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <h3 class="fw-bold mb-1">{{ $school->school_name }}</h3>
                            <div class="d-flex flex-wrap gap-2 align-items-center mt-2">
                                <span class="badge bg-secondary bg-opacity-90">
                                    <i class="bi bi-hash me-1"></i>NPSN: {{ $school->npsn ?: '-' }}
                                </span>
                                @if ($school->school_status)
                                    <span class="badge bg-secondary">
                                        Status: {{ ucfirst($school->school_status) }}
                                    </span>
                                @endif
                                @if ($school->school_accreditation)
                                    <span class="badge bg-secondary fw-bold">
                                        Akreditasi {{ $school->school_accreditation }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-white border-opacity-25 my-3">

                <div class="row g-3 small">
                    <div class="col-12 col-md-4">
                        <span class="opacity-75 d-block">Alamat:</span>
                        <strong>{{ $school->address ?: '-' }}</strong>
                    </div>
                    <div class="col-6 col-md-3">
                        <span class="opacity-75 d-block">Wilayah:</span>
                        <strong>{{ $school->regency->name ?? '-' }}, {{ $school->province->name ?? '-' }}</strong>
                    </div>
                    <div class="col-6 col-md-3">
                        <span class="opacity-75 d-block">Kurikulum:</span>
                        <strong>{{ $school->curriculum ?: 'Kurikulum Merdeka' }}</strong>
                    </div>
                    <div class="col-6 col-md-2">
                        <span class="opacity-75 d-block">Durasi Program:</span>
                        <strong>{{ $school->program_duration ?: '3 Tahun' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Struktur Keahlian --}}
            <div class="col-12 col-lg-12">
                <x-dashboard.section-card title="Struktur Bidang & Konsentrasi Keahlian"
                    subtitle="Struktur program yang terdaftar pada pengajuan asesmen sekolah ini">
                    @if (empty($structure))
                        <x-dashboard.empty-state message="Belum ada struktur keahlian terdata."
                            hint="Struktur keahlian akan otomatis diekstrak saat ada pengajuan instrumen." />
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach ($structure as $bidang => $programs)
                                <div class="p-3 bg-light rounded-3 border">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="bi bi-diagram-3-fill text-primary"></i>
                                        <strong class="text-dark">{{ $bidang }}</strong>
                                    </div>

                                    @foreach ($programs as $program => $concentrations)
                                        <div class="tree-branch mb-2">
                                            <div class="small fw-semibold text-secondary mb-1">
                                                <i class="bi bi-folder2-open me-1"></i>{{ $program }}
                                            </div>
                                            <div class="ps-3 d-flex flex-column gap-1">
                                                @foreach ($concentrations as $conc)
                                                    <div class="small text-dark d-flex align-items-center gap-1">
                                                        <i class="bi bi-check2 text-success"></i>
                                                        <span>{{ $conc }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-dashboard.section-card>
            </div>

            {{-- Submission / Assessment List --}}
            <div class="col-12 col-lg-12">
                <x-dashboard.section-card title="Daftar Pengajuan Instrumen Asesmen"
                    subtitle="Riwayat pengisian dan status verifikasi instrumen mutu">
                    @if ($school->instrumentSubmissionsV2->isEmpty())
                        <x-dashboard.empty-state message="Belum ada pengajuan instrumen."
                            hint="Sekolah ini belum mengisi instrumen asesmen versi 2." />
                    @else
                        <x-dashboard.data-table>
                            <x-slot:thead>
                                <tr>
                                    <th>Bidang / Konsentrasi</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </x-slot:thead>

                            @foreach ($school->instrumentSubmissionsV2 as $sub)
                                <tr>
                                    <td>
                                        <strong
                                            class="text-dark d-block">{{ $sub->expertise_concentration ?: $sub->expertise }}</strong>
                                        <small class="text-muted">{{ $sub->expertise_program }} &bull;
                                            {{ $sub->expertise }}</small>
                                    </td>
                                    <td>
                                        <span
                                            class="small">{{ $sub->filled_at ? $sub->filled_at->format('d/m/Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        <x-dashboard.status-badge :status="$sub->status" />
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            {{-- Link ke submission view detail yang sudah ada --}}
                                            <a href="{{ route('admin.submissions-v2.show', $sub) }}"
                                                class="btn btn-sm btn-outline-secondary" title="Buka Detail Form Pengajuan">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </a>

                                            {{-- Select context for deep-dive assessment analytics --}}
                                            <form action="{{ route('admin.dashboard.kelembagaan.select-context', $school) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="submission_id" value="{{ $sub->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    title="Buka Analisis Mutu Peserta Didik">
                                                    <i class="bi bi-mortarboard me-1"></i> Analisis Mutu
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-dashboard.data-table>
                    @endif
                </x-dashboard.section-card>
            </div>
        </div>
    </div>
@endsection
