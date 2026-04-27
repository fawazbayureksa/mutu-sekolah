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
                {{-- <a href="{{ route('admin.schools.edit', $school) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a> --}}
                <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        {{-- School Identity Hero Card --}}
        <div class="card shadow mb-4 border-0" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
            <div class="card-body py-4 px-4">
                <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width:64px;height:64px;background:rgba(255,255,255,0.15);">
                            <i class="bi bi-building text-white" style="font-size:1.75rem;"></i>
                        </div>
                        <div>
                            <h4 class="text-white fw-bold mb-1">{{ $school->school_name }}</h4>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                @if ($school->npsn)
                                    <span class="badge" style="background:rgba(255,255,255,0.2);color:#fff;">
                                        <i class="bi bi-hash me-1"></i>NPSN {{ $school->npsn }}
                                    </span>
                                @endif
                                @if ($school->school_accreditation)
                                    @php
                                        $accColors = ['A' => '#ffc107', 'B' => '#17a2b8', 'C' => '#6c757d'];
                                        $accColor = $accColors[$school->school_accreditation] ?? '#adb5bd';
                                    @endphp
                                    <span class="badge fw-bold" style="background:{{ $accColor }};color:#fff;">
                                        Akreditasi {{ $school->school_accreditation }}
                                    </span>
                                @endif
                                @if ($school->approval_status)
                                    @php
                                        $apvBg = match ($school->approval_status) {
                                            'approved' => '#28a745',
                                            'pending' => '#ffc107',
                                            'rejected' => '#dc3545',
                                            default => '#6c757d',
                                        };
                                        $apvLabel = match ($school->approval_status) {
                                            'approved' => 'Disetujui',
                                            'pending' => 'Menunggu',
                                            'rejected' => 'Ditolak',
                                            default => ucfirst($school->approval_status),
                                        };
                                    @endphp
                                    <span class="badge" style="background:{{ $apvBg }};color:#fff;">
                                        {{ $apvLabel }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-white-50 text-end small">
                        <i class="bi bi-clock me-1"></i>
                        Terdaftar {{ $school->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">

            {{-- Submission Stats Row --}}
            @php
                $totalSub = $school->instrumentSubmissionsV2()->count();
                $validatedSub = $school->instrumentSubmissionsV2()->where('status', 'validated')->count();
                $submittedSub = $school->instrumentSubmissionsV2()->where('status', 'submitted')->count();
                $rejectedSub = $school->instrumentSubmissionsV2()->where('status', 'rejected')->count();
            @endphp
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-3">
                        <div class="h3 fw-bold text-info mb-0">{{ $totalSub }}</div>
                        <div class="small text-muted mt-1">Total Pengajuan</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-3">
                        <div class="h3 fw-bold text-success mb-0">{{ $validatedSub }}</div>
                        <div class="small text-muted mt-1">Divalidasi</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-3">
                        <div class="h3 fw-bold text-warning mb-0">{{ $submittedSub }}</div>
                        <div class="small text-muted mt-1">Menunggu Review</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-3">
                        <div class="h3 fw-bold text-danger mb-0">{{ $rejectedSub }}</div>
                        <div class="small text-muted mt-1">Ditolak</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">

            {{-- School Identity Details --}}
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-2">
                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width:32px;height:32px;background:#e8ecff;">
                            <i class="bi bi-info-circle text-primary" style="font-size:.9rem;"></i>
                        </span>
                        <span class="fw-semibold">Identitas Sekolah</span>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0" style="row-gap:.75rem;">
                            <dt class="col-5 text-muted fw-normal small">Nama Sekolah</dt>
                            <dd class="col-7 mb-0 fw-semibold">{{ $school->school_name }}</dd>

                            <dt class="col-5 text-muted fw-normal small">NPSN</dt>
                            <dd class="col-7 mb-0">{{ $school->npsn ?? '-' }}</dd>

                            <dt class="col-5 text-muted fw-normal small">Status Sekolah</dt>
                            <dd class="col-7 mb-0">
                                @if ($school->school_status)
                                    <span
                                        class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle">
                                        {{ $school->school_status }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </dd>

                            <dt class="col-5 text-muted fw-normal small">Kategori</dt>
                            <dd class="col-7 mb-0">{{ $school->school_category ?? '-' }}</dd>

                            <dt class="col-5 text-muted fw-normal small">Durasi Program</dt>
                            <dd class="col-7 mb-0">
                                @if ($school->program_duration)
                                    {{ $school->program_duration }} tahun
                                @else
                                    -
                                @endif
                            </dd>

                            <dt class="col-5 text-muted fw-normal small">Akreditasi</dt>
                            <dd class="col-7 mb-0">
                                @if ($school->school_accreditation)
                                    @php
                                        $aColors = ['A' => 'warning', 'B' => 'info', 'C' => 'secondary'];
                                        $aColor = $aColors[$school->school_accreditation] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $aColor }}">{{ $school->school_accreditation }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </dd>

                            <dt class="col-5 text-muted fw-normal small">Status Persetujuan</dt>
                            <dd class="col-7 mb-0">
                                @if ($school->approval_status)
                                    @php
                                        $apvMap = [
                                            'approved' => ['success', 'Disetujui'],
                                            'pending' => ['warning', 'Menunggu'],
                                            'rejected' => ['danger', 'Ditolak'],
                                        ];
                                        [$apvCls, $apvTxt] = $apvMap[$school->approval_status] ?? [
                                            'secondary',
                                            ucfirst($school->approval_status),
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $apvCls }}">{{ $apvTxt }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </dd>

                            @if ($school->curriculum)
                                <dt class="col-5 text-muted fw-normal small">Kurikulum</dt>
                                <dd class="col-7 mb-0">{{ $school->curriculum }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Location Details --}}
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-2">
                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width:32px;height:32px;background:#e6f4ea;">
                            <i class="bi bi-geo-alt text-success" style="font-size:.9rem;"></i>
                        </span>
                        <span class="fw-semibold">Lokasi</span>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0" style="row-gap:.75rem;">
                            <dt class="col-5 text-muted fw-normal small">Alamat</dt>
                            <dd class="col-7 mb-0">{{ $school->address ?? '-' }}</dd>

                            <dt class="col-5 text-muted fw-normal small">Kabupaten/Kota</dt>
                            <dd class="col-7 mb-0">{{ $school->regency?->name ?? '-' }}</dd>

                            <dt class="col-5 text-muted fw-normal small">Provinsi</dt>
                            <dd class="col-7 mb-0">{{ $school->province?->name ?? '-' }}</dd>
                        </dl>
                    </div>
                </div>


            </div>
        </div>

        {{-- Recent Submissions --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-circle d-inline-flex align-items-center justify-content-center"
                        style="width:32px;height:32px;background:#f0e6ff;">
                        <i class="bi bi-file-text text-purple" style="font-size:.9rem;color:#6f42c1;"></i>
                    </span>
                    <span class="fw-semibold">Riwayat Pengajuan Terbaru</span>
                </div>
                <a href="{{ route('admin.submissions-v2.index', ['school' => $school->id]) }}"
                    class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-list me-1"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                @php
                    $recentSubmissions = $school->instrumentSubmissionsV2()->latest('filled_at')->take(10)->get();
                @endphp

                @if ($recentSubmissions->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #dee2e6;"></i>
                        <p class="mt-3 mb-0">Belum ada pengajuan dari sekolah ini.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Responden</th>
                                    <th>Konsentrasi Keahlian</th>
                                    <th>Tanggal</th>
                                    <th>Kelengkapan</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentSubmissions as $sub)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-semibold">{{ $sub->respondent_name }}</div>
                                            <div class="text-muted small">{{ $sub->respondent_position }}</div>
                                        </td>
                                        <td>
                                            @if ($sub->expertise_concentration)
                                                <div class="fw-semibold small">{{ $sub->expertise_concentration }}</div>
                                            @endif
                                            @if ($sub->expertise_program)
                                                <div class="text-muted small">{{ $sub->expertise_program }}</div>
                                            @endif
                                            @if ($sub->expertise)
                                                <div class="text-muted small">{{ $sub->expertise }}</div>
                                            @endif
                                            @if (!$sub->expertise && !$sub->expertise_program && !$sub->expertise_concentration)
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-muted small">
                                            {{ $sub->filled_at ? $sub->filled_at->format('d M Y') : '-' }}
                                        </td>
                                        <td style="min-width: 110px">
                                            @if ($sub->completion_percentage)
                                                @php
                                                    $pct = $sub->completion_percentage;
                                                    $col = $pct >= 80 ? 'success' : ($pct >= 50 ? 'warning' : 'danger');
                                                @endphp
                                                <div class="progress mb-1" style="height:6px;">
                                                    <div class="progress-bar bg-{{ $col }}"
                                                        style="width:{{ $pct }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ number_format($pct, 0) }}%</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $sub->getStatusBadgeClass() }}">
                                                {{ $sub->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.submissions-v2.show', $sub) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.submissions-v2.export-single', $sub) }}"
                                                class="btn btn-sm btn-outline-success ms-1">
                                                <i class="bi bi-file-earmark-spreadsheet"></i>
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
@endsection
