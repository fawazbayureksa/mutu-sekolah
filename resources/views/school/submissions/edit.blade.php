@extends('school.layouts.school')

@section('title', 'Edit Pengajuan - Portal Sekolah')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Edit Pengajuan</h1>
                    <p class="text-muted small mb-0">{{ $school->school_name }}</p>
                </div>
                <a href="{{ route('school.submissions.show', $submission) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>

        @if ($submission->status === 'rejected' && $submission->verification_notes)
            <div class="alert alert-warning d-flex align-items-start mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2 mt-1 flex-shrink-0"></i>
                <div>
                    <strong>Alasan penolakan:</strong> {{ $submission->verification_notes }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('school.submissions.update', $submission) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Responden</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Responden <span class="text-danger">*</span></label>
                            <input type="text" name="respondent_name"
                                class="form-control @error('respondent_name') is-invalid @enderror"
                                value="{{ old('respondent_name', $submission->respondent_name) }}" required maxlength="255">
                            @error('respondent_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="respondent_position"
                                class="form-control @error('respondent_position') is-invalid @enderror"
                                value="{{ old('respondent_position', $submission->respondent_position) }}" required
                                maxlength="255">
                            @error('respondent_position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Read-only summary -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Identitas Sekolah (tidak dapat diubah)</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-sm-3 text-muted">Nama Sekolah</dt>
                        <dd class="col-sm-9">{{ $submission->school_name }}</dd>

                        <dt class="col-sm-3 text-muted">NPSN</dt>
                        <dd class="col-sm-9">{{ $submission->npsn }}</dd>

                        <dt class="col-sm-3 text-muted">Konsentrasi Keahlian</dt>
                        <dd class="col-sm-9">{{ $submission->expertise_concentration ?? '-' }}</dd>

                        <dt class="col-sm-3 text-muted">Tanggal Isi</dt>
                        <dd class="col-sm-9">{{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Simpan & Ajukan Ulang
                </button>
                <a href="{{ route('school.submissions.show', $submission) }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
