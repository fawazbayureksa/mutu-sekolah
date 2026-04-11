@extends('school.layouts.school')

@section('title', 'Pengajuan Saya - Portal Sekolah')

@push('styles')
    <style>
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .status-dot.submitted {
            background: #0d6efd;
        }

        .status-dot.verified {
            background: #0dcaf0;
        }

        .status-dot.validated {
            background: #198754;
        }

        .status-dot.rejected {
            background: #dc3545;
        }

        .status-dot.draft {
            background: #6c757d;
        }

        .meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .72rem;
            color: #6c757d;
            background: #f4f5f7;
            border-radius: 20px;
            padding: 2px 9px;
            white-space: nowrap;
        }

        .progress-thin {
            height: 4px;
            border-radius: 4px;
            background: #e9ecef;
            overflow: hidden;
            width: 80px;
        }

        .progress-thin .bar {
            height: 100%;
            border-radius: 4px;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3.5rem 1rem;
            gap: .75rem;
        }

        .empty-state-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: #f4f5f7;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table>tbody>tr:last-child>td {
            border-bottom: 0;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="mb-4">
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div class="d-flex align-items-center gap-3 flex-grow-1 min-w-0">
                    <div class="rounded-3 flex-shrink-0 d-flex align-items-center justify-content-center border bg-body-secondary"
                        style="width:52px;height:52px;">
                        <i class="bi bi-journal-check text-secondary" style="font-size:1.25rem;"></i>
                    </div>
                    <div class="min-w-0">
                        <h1 class="h4 fw-bold mb-1 lh-base">Pengajuan Saya</h1>
                        <div class="d-flex align-items-center flex-wrap text-muted small" style="gap:.25rem .75rem;">
                            <span class="d-flex align-items-center gap-1">
                                <i class="bi bi-building"></i>{{ $school->school_name }}
                            </span>
                            @if ($school->npsn)
                                <span class="vr opacity-25 d-none d-sm-block"></span>
                                <span class="d-none d-sm-flex align-items-center gap-1">
                                    <i class="bi bi-upc"></i>{{ $school->npsn }}
                                </span>
                            @endif
                            @if ($school->regency)
                                <span class="vr opacity-25 d-none d-md-block"></span>
                                <span class="d-none d-md-flex align-items-center gap-1">
                                    <i class="bi bi-geo-alt"></i>{{ $school->regency->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('instrument.v2.form') }}"
                    class="btn btn-dark d-inline-flex align-items-center gap-2 flex-shrink-0">
                    <i class="bi bi-plus-lg"></i>
                    <span>Buat Pengajuan Baru</span>
                </a>
            </div>
            <div class="mt-3 border-bottom"></div>
        </div>

        {{-- Summary strip --}}
        @php
            $submitted = $submissions->getCollection()->where('status', 'submitted')->count();
            $validated = $submissions
                ->getCollection()
                ->whereIn('status', ['verified', 'validated'])
                ->count();
            $rejected = $submissions->getCollection()->where('status', 'rejected')->count();
        @endphp
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-3">
                        <div class="small text-muted mb-1">Total Pengajuan</div>
                        <div class="h4 fw-bold mb-0">{{ $submissions->total() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-3">
                        <div class="small text-muted mb-1">Menunggu Review</div>
                        <div class="h4 fw-bold mb-0 text-primary">{{ $submitted }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-3">
                        <div class="small text-muted mb-1">Diterima</div>
                        <div class="h4 fw-bold mb-0 text-success">{{ $validated }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-3">
                        <div class="small text-muted mb-1">Ditolak</div>
                        <div class="h4 fw-bold mb-0 text-danger">{{ $rejected }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submissions Table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width:40px;">#</th>
                                <th>Konsentrasi Keahlian</th>
                                <th class="d-none d-md-table-cell">Kurikulum</th>
                                <th class="d-none d-lg-table-cell">Responden</th>
                                <th class="d-none d-md-table-cell">Tanggal</th>
                                <th class="d-none d-lg-table-cell">Kelengkapan</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($submissions as $submission)
                                @php
                                    $statusDot = match ($submission->status) {
                                        'submitted' => 'submitted',
                                        'verified' => 'verified',
                                        'validated' => 'validated',
                                        'rejected' => 'rejected',
                                        default => 'draft',
                                    };
                                    $pct = $submission->completion_percentage;
                                @endphp
                                <tr>
                                    <td class="ps-4 text-muted small">
                                        {{ $submissions->firstItem() + $loop->index }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="status-dot {{ $statusDot }}"></span>
                                            <div>
                                                <div class="fw-semibold small">
                                                    {{ $submission->expertise_concentration ?? '—' }}
                                                </div>
                                                @if ($submission->expertise)
                                                    <div class="text-muted" style="font-size:.72rem;">
                                                        {{ $submission->expertise }}</div>
                                                @endif
                                                @if ($submission->status === 'rejected' && $submission->verification_notes)
                                                    <div class="text-danger d-flex align-items-start gap-1 mt-1"
                                                        style="font-size:.72rem;">
                                                        <i class="bi bi-exclamation-circle-fill flex-shrink-0 mt-1"></i>
                                                        <span>{{ Str::limit($submission->verification_notes, 80) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        @if ($submission->curriculum)
                                            <span class="meta-chip">{{ $submission->curriculum }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-lg-table-cell small text-muted">
                                        {{ $submission->respondent_name ?? '—' }}
                                    </td>
                                    <td class="d-none d-md-table-cell small text-muted">
                                        {{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '—' }}
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        @if ($pct)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress-thin">
                                                    <div class="bar"
                                                        style="width:{{ $pct }}%;background:{{ $pct >= 80 ? '#198754' : ($pct >= 50 ? '#fd7e14' : '#dc3545') }};">
                                                    </div>
                                                </div>
                                                <span class="text-muted"
                                                    style="font-size:.72rem;">{{ number_format($pct, 0) }}%</span>
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $submission->getStatusBadgeClass() }}"
                                            style="font-size:.72rem;">
                                            {{ $submission->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('school.submissions.show', $submission) }}"
                                                class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1"
                                                title="Lihat detail">
                                                <i class="bi bi-eye"></i>
                                                <span class="d-none d-lg-inline">Lihat</span>
                                            </a>
                                            {{-- @if ($submission->isEditable()) --}}
                                            <a href="{{ route('school.submissions.edit-full', $submission) }}"
                                                class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1"
                                                title="Edit pengajuan">
                                                <i class="bi bi-pencil"></i>
                                                <span class="d-none d-lg-inline">Edit</span>
                                            </a>
                                            {{-- @endif --}}
                                            <a href="{{ route('school.submissions.export-single', $submission) }}"
                                                class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1"
                                                title="Download XLSX">
                                                <i class="bi bi-file-earmark-spreadsheet"></i>
                                                <span class="d-none d-lg-inline">XLSX</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="bi bi-file-earmark-text"
                                                    style="font-size:1.75rem;color:#adb5bd;"></i>
                                            </div>
                                            <div class="text-center">
                                                <div class="fw-semibold mb-1">Belum ada pengajuan</div>
                                                <div class="text-muted small mb-3">Mulai isi instrumen penjaminan mutu
                                                    untuk
                                                    sekolah Anda.</div>
                                                <a href="{{ route('instrument.v2.form') }}"
                                                    class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2">
                                                    <i class="bi bi-plus-lg"></i> Buat Pengajuan Pertama
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($submissions->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
