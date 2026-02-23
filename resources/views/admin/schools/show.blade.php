@extends('layouts.admin')

@section('title', 'Detail Sekolah - Panel Admin')

@section('content')
    <div class="container-fluid">
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Detail Sekolah</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.schools.index') }}">Data Sekolah</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.schools.edit', $school) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
                <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            {{-- Left Sidebar --}}
            <div class="col-lg-4 mb-4">

                {{-- School Info Card --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-building me-2"></i>Informasi Sekolah
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td class="fw-semibold text-muted" style="width:40%">Nama Sekolah</td>
                                <td class="fw-semibold">{{ $school->school_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">NPSN</td>
                                <td>{{ $school->npsn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Alamat</td>
                                <td>{{ $school->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Provinsi</td>
                                <td>{{ $school->province?->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Kabupaten/Kota</td>
                                <td>{{ $school->regency?->name ?? '-' }}</td>
                            </tr>
                            @if ($school->school_status)
                                <tr>
                                    <td class="fw-semibold text-muted">Status</td>
                                    <td>{{ $school->school_status }}</td>
                                </tr>
                            @endif
                            @if ($school->school_category)
                                <tr>
                                    <td class="fw-semibold text-muted">Kategori</td>
                                    <td>{{ $school->school_category }}</td>
                                </tr>
                            @endif
                            @if ($school->program_duration)
                                <tr>
                                    <td class="fw-semibold text-muted">Durasi Program</td>
                                    <td>{{ $school->program_duration }}</td>
                                </tr>
                            @endif
                            @if ($school->school_accreditation)
                                <tr>
                                    <td class="fw-semibold text-muted">Akreditasi</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $school->school_accreditation }}</span>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- Expertise Card --}}
                @if ($school->expertise || $school->expertise_program || $school->expertise_concentration)
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="bi bi-mortarboard me-2"></i>Bidang Keahlian
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm mb-0">
                                @if ($school->expertise)
                                    <tr>
                                        <td class="fw-semibold text-muted" style="width:40%">Bidang</td>
                                        <td>{{ $school->expertise }}</td>
                                    </tr>
                                @endif
                                @if ($school->expertise_program)
                                    <tr>
                                        <td class="fw-semibold text-muted">Program</td>
                                        <td>{{ $school->expertise_program }}</td>
                                    </tr>
                                @endif
                                @if ($school->expertise_concentration)
                                    <tr>
                                        <td class="fw-semibold text-muted">Konsentrasi</td>
                                        <td>{{ $school->expertise_concentration }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                @endif

                {{-- Stats Card --}}
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-bar-chart me-2"></i>Statistik
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 text-center">
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div class="h4 mb-1 text-info fw-bold">{{ $school->submissions()->count() }}</div>
                                    <small class="text-muted">Pengajuan</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div class="h4 mb-1 text-success fw-bold">
                                        {{ $school->submissions()->where('status', 'validated')->count() }}</div>
                                    <small class="text-muted">Divalidasi</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div class="h4 mb-1 text-warning fw-bold">
                                        {{ $school->submissions()->where('status', 'submitted')->count() }}</div>
                                    <small class="text-muted">Menunggu</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div class="h4 mb-1 text-danger fw-bold">
                                        {{ $school->submissions()->where('status', 'rejected')->count() }}</div>
                                    <small class="text-muted">Ditolak</small>
                                </div>
                            </div>
                        </div>
                        <hr class="my-3">
                        <small class="text-muted d-block">
                            <i class="bi bi-clock me-1"></i>
                            Terdaftar sejak {{ $school->created_at->format('d M Y') }}
                        </small>
                    </div>
                </div>
            </div>

            {{-- Main Content: Recent Submissions --}}
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-file-text me-2"></i>Riwayat Pengajuan
                        </h6>
                        <a href="{{ route('admin.submissions-v2.index', ['school' => $school->id]) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-list me-1"></i> Lihat Semua
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @php
                            $recentSubmissions = $school->submissions()->latest('filled_at')->take(10)->get();
                        @endphp

                        @if ($recentSubmissions->isEmpty())
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #dee2e6;"></i>
                                <p class="mt-3 mb-0">Belum ada pengajuan dari sekolah ini.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Responden</th>
                                            <th>Jabatan</th>
                                            <th>Tanggal</th>
                                            <th>Kelengkapan</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentSubmissions as $sub)
                                            <tr>
                                                <td class="ps-3 fw-semibold">{{ $sub->respondent_name }}</td>
                                                <td class="text-muted small">{{ $sub->respondent_position }}</td>
                                                <td class="text-muted small">
                                                    {{ $sub->filled_at ? $sub->filled_at->format('d M Y') : '-' }}
                                                </td>
                                                <td style="min-width: 100px">
                                                    @if ($sub->completion_percentage)
                                                        @php
                                                            $pct = $sub->completion_percentage;
                                                            $col =
                                                                $pct >= 80
                                                                    ? 'success'
                                                                    : ($pct >= 50
                                                                        ? 'warning'
                                                                        : 'danger');
                                                        @endphp
                                                        <div class="progress" style="height:6px;">
                                                            <div class="progress-bar bg-{{ $col }}"
                                                                style="width:{{ $pct }}%"></div>
                                                        </div>
                                                        <small class="text-muted">{{ number_format($pct, 0) }}%</small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $badgeMap = [
                                                            'submitted' => 'primary',
                                                            'verified' => 'info',
                                                            'validated' => 'success',
                                                            'rejected' => 'danger',
                                                        ];
                                                        $labelMap = [
                                                            'submitted' => 'Dikirim',
                                                            'verified' => 'Diverifikasi',
                                                            'validated' => 'Divalidasi',
                                                            'rejected' => 'Ditolak',
                                                        ];
                                                    @endphp
                                                    <span class="badge bg-{{ $badgeMap[$sub->status] ?? 'secondary' }}">
                                                        {{ $labelMap[$sub->status] ?? ucfirst($sub->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.submissions-v2.show', $sub) }}"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
