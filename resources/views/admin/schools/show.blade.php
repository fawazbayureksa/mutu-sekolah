@extends('layouts.admin')

@section('title', 'Detail Sekolah - Panel Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Detail Sekolah</h2>
            <p class="text-muted mb-0">Informasi lengkap mengenai sekolah</p>
        </div>
        <div>
            <a href="{{ route('admin.schools.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
            <a href="{{ route('admin.schools.edit', $school) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Sekolah</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase mb-1">Nama Sekolah</label>
                        <h5 class="mb-0">{{ $school->school_name }}</h5>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase mb-1">NPSN</label>
                        <p class="mb-0">{{ $school->npsn }}</p>
                    </div>
                    <div>
                        <label class="text-muted small text-uppercase mb-1">Alamat</label>
                        <p class="mb-0">{{ $school->address }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Jumlah Penilaian</span>
                        <span class="badge bg-primary fs-6">{{ $school->assessments()->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Jumlah Pengajuan</span>
                        <span class="badge bg-info fs-6">{{ $school->submissions()->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Jumlah Respons</span>
                        <span class="badge bg-success fs-6">{{ $school->responses()->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Penilaian</h5>
                    <a href="{{ route('admin.schools.assessments', $school) }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @forelse($school->assessments()->latest()->take(5)->get() as $assessment)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <h6 class="mb-1">{{ $assessment->instrument->name ?? 'Instrumen Tidak Ditemukan' }}</h6>
                                <small class="text-muted">{{ $assessment->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="text-end">
                                @if ($assessment->status === 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($assessment->status === 'in_progress')
                                    <span class="badge bg-warning">Sedang Berjalan</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-clipboard-check fs-1 d-block mb-3"></i>
                            <p class="mb-0">Belum ada penilaian</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="card">
                {{-- <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Pengajuan</h5>
                    <a href="{{ route('admin.schools.submissions', $school) }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div> --}}
                <div class="card-body">
                    @forelse($school->submissions()->latest()->take(5)->get() as $submission)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <h6 class="mb-1">{{ $submission->instrument->name ?? 'Instrumen Tidak Ditemukan' }}</h6>
                                <small class="text-muted">{{ $submission->filled_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="text-end">
                                @if ($submission->status === 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($submission->status === 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($submission->status === 'verified')
                                    <span class="badge bg-info">Terverifikasi</span>
                                @elseif($submission->status === 'submitted')
                                    <span class="badge bg-primary">Terkirim</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-file-earmark-text fs-1 d-block mb-3"></i>
                            <p class="mb-0">Belum ada pengajuan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
