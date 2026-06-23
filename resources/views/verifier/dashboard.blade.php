@extends('verifier.layouts.verifier')

@section('title', 'Dashboard Verifikasi')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0 text-gray-800">Dashboard Verifikasi</h1>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Menunggu Verifikasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_verification'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-clock-history fa-2x text-gray-300 fs-2 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah
                                    Diverifikasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['verified'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-check-circle fa-2x text-gray-300 fs-2 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-x-circle fa-2x text-gray-300 fs-2 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Submission Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sekolah</th>
                                <th>Instrumen</th>
                                <th>Tanggal Isi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSubmissions as $submission)
                                <tr>
                                    <td>{{ $submission->school->school_name ?? '-' }}</td>
                                    <td>{{ $submission->expertise_concentration ?? '-' }}</td>
                                    <td>{{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('verifier.submissions.show', $submission) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada submission</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
