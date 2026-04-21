@extends('verifier.layouts.verifier')

@section('title', 'Data Pengajuan')

@section('content')
    <div class="container-fluid">
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Data Pengajuan</h1>
                <p class="text-muted mb-0">Verifikasi data pengajuan instrumen versi 2</p>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengajuan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-file-earmark-text fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Verifikasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['submitted'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-hourglass-split fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Terverifikasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['verified'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-check-circle fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ $status === 'all' ? 'active' : '' }}"
                            href="{{ route('verifier.submissions-v2.index', ['status' => 'all']) }}">
                            Semua
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status === 'submitted' ? 'active' : '' }}"
                            href="{{ route('verifier.submissions-v2.index', ['status' => 'submitted']) }}">
                            <i class="bi bi-hourglass-split me-1"></i> Menunggu
                            @if ($stats['submitted'] > 0)
                                <span class="badge bg-warning text-dark">{{ $stats['submitted'] }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status === 'verified' ? 'active' : '' }}"
                            href="{{ route('verifier.submissions-v2.index', ['status' => 'verified']) }}">
                            <i class="bi bi-check-circle me-1"></i> Terverifikasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status === 'rejected' ? 'active' : '' }}"
                            href="{{ route('verifier.submissions-v2.index', ['status' => 'rejected']) }}">
                            <i class="bi bi-x-circle me-1"></i> Ditolak
                            @if ($stats['rejected'] > 0)
                                <span class="badge bg-danger">{{ $stats['rejected'] }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 20%">Sekolah</th>
                                <th style="width: 10%">NPSN</th>
                                <th style="width: 18%">Responden</th>
                                <th style="width: 12%">Tanggal Isi</th>
                                <th style="width: 10%">Kelengkapan</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $index => $submission)
                                <tr>
                                    <td class="text-center">{{ $submissions->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $submission->school_name }}</div>
                                        <small class="text-muted text-truncate d-block"
                                            style="max-width: 200px;">{{ Str::limit($submission->address, 50) }}</small>
                                    </td>
                                    <td>{{ $submission->npsn ?? '-' }}</td>
                                    <td>
                                        <div>{{ $submission->respondent_name }}</div>
                                        <small class="text-muted">{{ $submission->respondent_position }}</small>
                                    </td>
                                    <td>{{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}</td>
                                    <td class="text-center">
                                        @php
                                            $pct = $submission->completion_percentage ?? 0;
                                            $colorClass = $pct >= 80 ? 'success' : ($pct >= 50 ? 'warning' : 'danger');
                                        @endphp
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-{{ $colorClass }}" role="progressbar"
                                                style="width: {{ $pct }}%" aria-valuenow="{{ $pct }}"
                                                aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ number_format($pct, 0) }}%</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $submission->getStatusBadgeClass() }}">
                                            {{ $submission->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('verifier.submissions-v2.show', $submission) }}"
                                                class="btn btn-primary btn-sm" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('verifier.submissions-v2.export-single', $submission) }}"
                                                class="btn btn-outline-success btn-sm" title="Unduh Hasil">
                                                <i class="bi bi-file-earmark-spreadsheet"></i>
                                            </a>
                                            @if ($submission->status === 'submitted')
                                                <button type="button" class="btn btn-success btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#verifyModal{{ $submission->id }}"
                                                    title="Verifikasi">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $submission->id }}" title="Tolak">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- Verify Modal --}}
                                @if ($submission->status === 'submitted')
                                    <div class="modal fade" id="verifyModal{{ $submission->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('verifier.submissions-v2.verify', $submission) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Verifikasi Pengajuan</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Anda akan memverifikasi pengajuan dari:</p>
                                                        <div class="bg-light p-3 rounded mb-3">
                                                            <strong>{{ $submission->school_name }}</strong><br>
                                                            <small class="text-muted">{{ $submission->respondent_name }} -
                                                                {{ $submission->respondent_position }}</small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Catatan (Opsional)</label>
                                                            <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan verifikasi..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="bi bi-check-lg me-1"></i> Verifikasi
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Reject Modal --}}
                                    <div class="modal fade" id="rejectModal{{ $submission->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('verifier.submissions-v2.reject', $submission) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Tolak Pengajuan</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Anda akan menolak pengajuan dari:</p>
                                                        <div class="bg-light p-3 rounded mb-3">
                                                            <strong>{{ $submission->school_name }}</strong><br>
                                                            <small class="text-muted">{{ $submission->respondent_name }} -
                                                                {{ $submission->respondent_position }}</small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Alasan Penolakan <span
                                                                    class="text-danger">*</span></label>
                                                            <textarea name="notes" class="form-control" rows="3" required placeholder="Jelaskan alasan penolakan..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-x-lg me-1"></i> Tolak
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            Belum ada data pengajuan
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $submissions->firstItem() ?? 0 }} - {{ $submissions->lastItem() ?? 0 }} dari
                        {{ $submissions->total() }} data
                    </div>
                    {{ $submissions->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .border-left-primary {
            border-left: 4px solid #4e73df !important;
        }

        .border-left-success {
            border-left: 4px solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 4px solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 4px solid #f6c23e !important;
        }

        .card-header-tabs {
            margin-bottom: -1rem;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
        }

        .nav-tabs .nav-link.active {
            font-weight: 600;
        }
    </style>
@endpush
