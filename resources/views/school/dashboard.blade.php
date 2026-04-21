@extends('school.layouts.school')

@section('title', 'Dashboard - Portal Sekolah')

@push('styles')
    <style>
        .stat-card {
            border: 0;
            border-radius: .75rem;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

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

        .table>tbody>tr:last-child>td {
            border-bottom: 0;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
            gap: .75rem;
        }

        .empty-state-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #f4f5f7;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <h1 class="h4 fw-bold mb-0">Dashboard</h1>
                <p class="text-muted small mb-0 mt-1">
                    <i class="bi bi-building me-1"></i>{{ $school->school_name ?? auth()->user()->npsn }}
                </p>
            </div>
            <a href="{{ route('instrument.v2.form') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                <span>Buat Pengajuan Baru</span>
            </a>
        </div>

        {{-- Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-folder2-open"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Total Pengajuan</div>
                            <div class="h4 fw-bold mb-0">{{ $stats['total'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Menunggu Review</div>
                            <div class="h4 fw-bold mb-0 text-warning">{{ $stats['submitted'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Diterima</div>
                            <div class="h4 fw-bold mb-0 text-success">{{ $stats['verified'] + $stats['validated'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Ditolak</div>
                            <div class="h4 fw-bold mb-0 text-danger">{{ $stats['rejected'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Submissions --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <span class="fw-semibold">Pengajuan Terbaru</span>
                <a href="{{ route('school.submissions.index') }}"
                    class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
                    <i class="bi bi-list-ul"></i>
                    <span>Lihat Semua</span>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Konsentrasi Keahlian</th>
                                <th class="d-none d-md-table-cell">Kurikulum</th>
                                <th class="d-none d-md-table-cell">Tanggal</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentSubmissions as $submission)
                                @php
                                    $statusDot = match ($submission->status) {
                                        'submitted' => 'submitted',
                                        'verified' => 'verified',
                                        'validated' => 'validated',
                                        'rejected' => 'rejected',
                                        default => 'draft',
                                    };
                                @endphp
                                <tr>
                                    <td class="ps-4">
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
                                                        <span>{{ Str::limit($submission->verification_notes, 70) }}</span>
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
                                    <td class="d-none d-md-table-cell small text-muted">
                                        {{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '—' }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $submission->getStatusBadgeClass() }}"
                                            style="font-size:.72rem;">
                                            {{ $submission->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('school.submissions.show', $submission) }}"
                                            class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1"
                                            title="Lihat detail">
                                            <i class="bi bi-eye"></i>
                                            <span class="d-none d-lg-inline">Lihat</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="bi bi-file-earmark-text"
                                                    style="font-size:1.5rem;color:#adb5bd;"></i>
                                            </div>
                                            <div class="text-center">
                                                <div class="fw-semibold mb-1">Belum ada pengajuan</div>
                                                <div class="text-muted small mb-3">Mulai isi instrumen penjaminan mutu untuk
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
        </div>

    </div>
@endsection
