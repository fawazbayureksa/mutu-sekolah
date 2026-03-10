@extends('layouts.admin')

@section('title', 'Dashboard - Penjaminan Mutu SMK KPTK')

@section('content')
    <!-- Welcome Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div>
                <h2 class="fw-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-muted mb-0">
                    <i class="bi bi-calendar-check me-2"></i>
                    {{ now()->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-building text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Total Sekolah</p>
                            <h3 class="mb-0 fw-bold">{{ \App\Models\School::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-clipboard-check text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Penilaian Selesai</p>
                            <h3 class="mb-0 fw-bold">
                                {{ \App\Models\Assessment::where('status', 'submitted')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-hourglass-split text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Draft</p>
                            <h3 class="mb-0 fw-bold">
                                {{ \App\Models\Assessment::where('status', 'draft')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-file-earmark-text text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Total Instrumen</p>
                            <h3 class="mb-0 fw-bold">{{ \App\Models\Instrument::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Quick Actions -->
    {{-- <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Menu Utama</h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="{{ route('admin.assessments.index') }}" class="text-decoration-none">
                        <div class="card border-0 bg-primary bg-opacity-10 h-100 hover-shadow">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-clipboard-data text-primary fs-1 mb-3"></i>
                                <h6 class="fw-bold text-dark">Kelola Penilaian</h6>
                                <p class="text-muted small mb-0">Lihat dan kelola semua penilaian</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('admin.questions.index') }}" class="text-decoration-none">
                        <div class="card border-0 bg-success bg-opacity-10 h-100 hover-shadow">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-question-circle text-success fs-1 mb-3"></i>
                                <h6 class="fw-bold text-dark">Question Library</h6>
                                <p class="text-muted small mb-0">Kelola bank soal penilaian</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('admin.instruments.index') }}" class="text-decoration-none">
                        <div class="card border-0 bg-info bg-opacity-10 h-100 hover-shadow">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-file-earmark-text text-info fs-1 mb-3"></i>
                                <h6 class="fw-bold text-dark">Instrumen</h6>
                                <p class="text-muted small mb-0">Kelola instrumen penilaian</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Recent Submissions -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Penilaian Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3">Sekolah</th>
                            <th class="border-0 px-4 py-3">Responden</th>
                            <th class="border-0 px-4 py-3">Tanggal</th>
                            <th class="border-0 px-4 py-3">Status</th>
                            <th class="border-0 px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Assessment::with('school')->latest()->take(5)->get() as $assessment)
                            <tr>
                                <td class="px-4 py-3">
                                    <strong>{{ $assessment->school->school_name ?? 'N/A' }}</strong>
                                </td>
                                <td class="px-4 py-3">{{ $assessment->respondent_name }}</td>
                                <td class="px-4 py-3">{{ $assessment->filled_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    @if ($assessment->status === 'submitted')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Belum ada penilaian
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

@push('styles')
    <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endpush
