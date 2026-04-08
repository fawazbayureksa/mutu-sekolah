@extends('school.layouts.school')

@section('title', 'Dashboard - Portal Sekolah')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <p class="text-muted small mb-0">{{ $school->school_name ?? auth()->user()->npsn }}</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengajuan</div>
                                <div class="h4 mb-0 font-weight-bold">{{ $stats['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-folder2-open fs-2 text-primary opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Verifikasi
                                </div>
                                <div class="h4 mb-0 font-weight-bold">{{ $stats['submitted'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-clock-history fs-2 text-warning opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Terverifikasi</div>
                                <div class="h4 mb-0 font-weight-bold">{{ $stats['verified'] + $stats['validated'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-check-circle fs-2 text-success opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                                <div class="h4 mb-0 font-weight-bold">{{ $stats['rejected'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-x-circle fs-2 text-danger opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Pengajuan Terbaru</h6>
                <a href="{{ route('school.submissions.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Konsentrasi Keahlian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentSubmissions as $submission)
                                <tr>
                                    <td>{{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}</td>
                                    <td>{{ $submission->expertise_concentration ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $submission->getStatusBadgeClass() }}">
                                            {{ $submission->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('school.submissions.show', $submission) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Belum ada pengajuan.<br>
                                        <a href="{{ route('instrument.v2.form') }}" class="btn btn-primary btn-sm mt-2">
                                            <i class="bi bi-plus-circle me-1"></i>Isi Instrumen Sekarang
                                        </a>
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
