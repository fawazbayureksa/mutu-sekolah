@extends('school.layouts.school')

@section('title', 'Detail Pengajuan - Portal Sekolah')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Detail Pengajuan</h1>
                    <p class="text-muted small mb-0">{{ $school->school_name }}</p>
                </div>
                <div class="d-flex gap-2">
                    @if ($submission->isEditable())
                        <a href="{{ route('school.submissions.edit', $submission) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-1"></i>Edit Pengajuan
                        </a>
                    @endif
                    <a href="{{ route('school.submissions.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Banner -->
        @if ($submission->status === 'rejected')
            <div class="alert alert-danger d-flex align-items-start">
                <i class="bi bi-x-circle-fill me-2 mt-1 flex-shrink-0 fs-5"></i>
                <div>
                    <strong>Pengajuan Ditolak</strong><br>
                    @if ($submission->verification_notes)
                        Catatan: {{ $submission->verification_notes }}
                    @endif
                    <div class="mt-2">
                        <a href="{{ route('school.submissions.edit', $submission) }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-pencil me-1"></i>Perbaiki & Ajukan Ulang
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <!-- Identitas Sekolah -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Identitas Sekolah</h6>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4 text-muted small">Nama Sekolah</dt>
                            <dd class="col-sm-8">{{ $submission->school_name ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">NPSN</dt>
                            <dd class="col-sm-8">{{ $submission->npsn ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Alamat</dt>
                            <dd class="col-sm-8">{{ $submission->address ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Provinsi</dt>
                            <dd class="col-sm-8">{{ $submission->province->name ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Kabupaten/Kota</dt>
                            <dd class="col-sm-8">{{ $submission->regency->name ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Konsentrasi Keahlian</dt>
                            <dd class="col-sm-8">{{ $submission->expertise_concentration ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Program Keahlian</dt>
                            <dd class="col-sm-8">{{ $submission->expertise_program ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Bidang Keahlian</dt>
                            <dd class="col-sm-8">{{ $submission->expertise ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Kurikulum</dt>
                            <dd class="col-sm-8">{{ $submission->curriculum ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Status Sekolah</dt>
                            <dd class="col-sm-8">{{ $submission->school_status ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Kategori Sekolah</dt>
                            <dd class="col-sm-8">{{ $submission->school_category ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Akreditasi</dt>
                            <dd class="col-sm-8">{{ $submission->school_accreditation ?? '-' }}</dd>
                        </dl>
                    </div>
                </div>

                <!-- Data Responden -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Responden</h6>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4 text-muted small">Nama Responden</dt>
                            <dd class="col-sm-8">{{ $submission->respondent_name ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted small">Jabatan</dt>
                            <dd class="col-sm-8">{{ $submission->respondent_position ?? '-' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Status Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status Pengajuan</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <span class="badge {{ $submission->getStatusBadgeClass() }} fs-6 px-3 py-2">
                                {{ $submission->getStatusLabel() }}
                            </span>
                        </div>
                        <dl class="row mb-0 small">
                            <dt class="col-6 text-muted">Tanggal Isi</dt>
                            <dd class="col-6">{{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}
                            </dd>

                            @if ($submission->verified_at)
                                <dt class="col-6 text-muted">Diverifikasi</dt>
                                <dd class="col-6">{{ $submission->verified_at->format('d M Y') }}</dd>
                            @endif

                            @if ($submission->validated_at)
                                <dt class="col-6 text-muted">Divalidasi</dt>
                                <dd class="col-6">{{ $submission->validated_at->format('d M Y') }}</dd>
                            @endif

                            @if ($submission->verification_notes)
                                <dt class="col-12 text-muted mt-2">Catatan</dt>
                                <dd class="col-12 text-danger">{{ $submission->verification_notes }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Score Card (if available) -->
                @if ($submission->total_score)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Skor Pengajuan</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="h2 text-primary mb-0">{{ number_format($submission->total_score, 1) }}</div>
                            <small class="text-muted">dari {{ $submission->max_possible_score }}</small>
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar bg-primary"
                                    style="width: {{ $submission->completion_percentage }}%"></div>
                            </div>
                            <small class="text-muted">{{ $submission->completion_percentage }}% selesai</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
