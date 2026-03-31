@extends('layouts.app')

@section('title', 'Update Data Submission - Penjaminan Mutu SMK Bidang KPTK')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/instrument-form-v2.css') }}">
@endpush

@section('content')
    @php
        $answers = $submission->answers ?? [];
    @endphp
    <div class="container-fluid py-5" style="max-width: 1400px;">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-2 text-primary">Update Data Submission</h2>
                    <p class="text-secondary small">Silakan perbarui data sekolah dan penilaian sesuai catatan verifikasi</p>
                </div>

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

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-exclamation-triangle me-2"></i>Terdapat kesalahan pada form:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ $updateUrl }}" method="POST" id="instrumentForm">
                    @csrf

                    {{-- Wizard Stepper --}}
                    <div class="wizard-stepper mb-4">
                        <div class="wizard-step active" data-step="1">
                            <div class="wizard-step-circle">
                                <span class="wizard-step-number">1</span>
                                <i class="bi bi-check-lg wizard-step-check"></i>
                            </div>
                            <div class="wizard-step-label">Identitas Sekolah</div>
                        </div>
                        <div class="wizard-step-connector"></div>
                        <div class="wizard-step" data-step="2">
                            <div class="wizard-step-circle">
                                <span class="wizard-step-number">2</span>
                                <i class="bi bi-check-lg wizard-step-check"></i>
                            </div>
                            <div class="wizard-step-label">Data Responden</div>
                        </div>
                        <div class="wizard-step-connector"></div>
                        <div class="wizard-step" data-step="3">
                            <div class="wizard-step-circle">
                                <span class="wizard-step-number">3</span>
                                <i class="bi bi-check-lg wizard-step-check"></i>
                            </div>
                            <div class="wizard-step-label">Peserta Didik</div>
                        </div>
                        <div class="wizard-step-connector"></div>
                        <div class="wizard-step" data-step="4">
                            <div class="wizard-step-circle">
                                <span class="wizard-step-number">4</span>
                                <i class="bi bi-check-lg wizard-step-check"></i>
                            </div>
                            <div class="wizard-step-label">Sarana Prasarana</div>
                        </div>
                        <div class="wizard-step-connector"></div>
                        <div class="wizard-step" data-step="5">
                            <div class="wizard-step-circle">
                                <span class="wizard-step-number">5</span>
                                <i class="bi bi-check-lg wizard-step-check"></i>
                            </div>
                            <div class="wizard-step-label">Tata Kelola</div>
                        </div>
                    </div>

                    <div class="form-step" data-step="1">
                    {{-- Section 1: Identitas Sekolah --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-building"></i>
                            <strong>Identitas Sekolah</strong>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="school_name"
                                    class="form-control @error('school_name') is-invalid @enderror" required
                                    value="{{ old('school_name', $submission->school_name) }}" placeholder="Nama sekolah">
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NPSN</label>
                                <input type="text" name="npsn" class="form-control"
                                    value="{{ old('npsn', $submission->npsn) }}" placeholder="NPSN">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <select name="province_code" id="provinceSelect"
                                    class="form-select @error('province_code') is-invalid @enderror" required
                                    onchange="loadRegencies(this.value)">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->code }}"
                                            {{ old('province_code', $submission->province_code) == $province->code ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <select name="regency_code" id="regencySelect"
                                    class="form-select @error('regency_code') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                    @if ($regencies)
                                        @foreach ($regencies as $regency)
                                            <option value="{{ $regency->code }}"
                                                {{ old('regency_code', $submission->regency_code) == $regency->code ? 'selected' : '' }}>
                                                {{ $regency->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('regency_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required
                                    placeholder="Masukkan alamat lengkap sekolah">{{ old('address', $submission->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Sekolah</label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="school_status"
                                            id="statusNegeri" value="Negeri"
                                            {{ old('school_status', $submission->school->school_status) == 'Negeri' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusNegeri">Negeri</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="school_status"
                                            id="statusSwasta" value="Swasta"
                                            {{ old('school_status', $submission->school->school_status) == 'Swasta' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusSwasta">Swasta</label>
                                    </div>
                                </div>
                                @error('school_status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Durasi Program</label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="program_duration"
                                            id="duration3" value="3 Tahun"
                                            {{ old('program_duration', $submission->school->program_duration) == '3 Tahun' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="duration3">3 Tahun</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="program_duration"
                                            id="duration4" value="4 Tahun"
                                            {{ old('program_duration', $submission->school->program_duration) == '4 Tahun' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="duration4">4 Tahun</label>
                                    </div>
                                </div>
                                @error('program_duration')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Kategori Sekolah</label>
                                <div class="mt-2">
                                    @foreach (config('constant.school_category') as $value => $label)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="school_category"
                                                id="cat{{ Str::slug($value) }}" value="{{ $value }}"
                                                {{ old('school_category', $submission->school->school_category) == $value ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="cat{{ Str::slug($value) }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('school_category')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Kurikulum</label>
                                <div class="mt-2">
                                    @foreach (config('constant.curriculum') as $cur)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="curriculum"
                                                id="cur{{ Str::slug($cur) }}" value="{{ $cur }}"
                                                {{ old('curriculum', $submission->school->curriculum) == $cur ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="cur{{ Str::slug($cur) }}">{{ $cur }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('curriculum')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Akreditasi Sekolah</label>
                                <div class="mt-2">
                                    @foreach (config('constant.school_accreditation') as $acc)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="school_accreditation"
                                                id="acc{{ Str::slug($acc) }}" value="{{ $acc }}"
                                                {{ old('school_accreditation', $submission->school->school_accreditation) == $acc ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="acc{{ Str::slug($acc) }}">{{ $acc }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('school_accreditation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12" id="approval-status-wrapper" style="display:none;">
                                <label class="form-label">Status Approval</label>
                                <div class="mt-2">
                                    @foreach (config('constant.approval_status') as $status)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="approval_status"
                                                id="appr{{ Str::slug($status) }}" value="{{ $status }}"
                                                {{ old('approval_status', $submission->school->approval_status ?? '') == $status ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="appr{{ Str::slug($status) }}">{{ $status }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('approval_status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bidang Keahlian</label>
                                <select name="expertise" id="expertiseSelect"
                                    class="form-select @error('expertise') is-invalid @enderror"
                                    onchange="loadExpertisePrograms(this.value)">
                                    <option value="">-- Pilih Bidang Keahlian --</option>
                                    @foreach (array_keys($expertiseData ?? []) as $expertise)
                                        <option value="{{ $expertise }}"
                                            {{ old('expertise', $submission->school->expertise ?: $submission->expertise) == $expertise ? 'selected' : '' }}>
                                            {{ $expertise == 'TIK' ? 'TIK (Teknologi Informasi dan Komunikasi)' : $expertise }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('expertise')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Program Keahlian</label>
                                <select name="expertise_program" id="expertiseProgramSelect"
                                    class="form-select @error('expertise_program') is-invalid @enderror"
                                    onchange="loadExpertiseConcentrations(this.value)">
                                    <option value="">-- Pilih Program Keahlian --</option>
                                </select>
                                @error('expertise_program')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Konsentrasi Keahlian</label>
                                <select name="expertise_concentration" id="expertiseConcentrationSelect"
                                    class="form-select @error('expertise_concentration') is-invalid @enderror"
                                    onchange="loadSaprasData(this.value)">
                                    <option value="">-- Pilih Konsentrasi Keahlian --</option>
                                </select>
                                @error('expertise_concentration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    </div>{{-- end form-step 1 --}}

                    <div class="form-step" data-step="2" style="display:none">
                    {{-- Section 2: Data Responden --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-person-badge"></i>
                            <strong>Data Responden</strong>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Responden <span class="text-danger">*</span></label>
                                <input type="text" name="respondent_name"
                                    class="form-control @error('respondent_name') is-invalid @enderror" required
                                    value="{{ old('respondent_name', $submission->respondent_name) }}"
                                    placeholder="Masukkan nama responden">
                                @error('respondent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan Responden <span class="text-danger">*</span></label>
                                <select name="respondent_position"
                                    class="form-select @error('respondent_position') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jabatan Responden --</option>
                                    @foreach ($respondentPositions ?? [] as $position)
                                        <option value="{{ $position }}"
                                            {{ old('respondent_position', $submission->respondent_position) == $position ? 'selected' : '' }}>
                                            {{ $position }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('respondent_position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    </div>{{-- end form-step 2 --}}

                    <div class="form-step" data-step="3" style="display:none">
                    {{-- ASPECT A: Standar Peserta Didik --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-journal-text"></i>
                            <strong>A - Peserta Didik (Kompetensi & Kesiapan Kerja)</strong>
                        </div>

                        {{-- A.1: Data Kompetensi (UKK & Sertifikasi) --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">A.1</span>
                                Data Kompetensi (UKK & Sertifikasi)
                            </h5>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">A.1.1</span>
                                </div>
                                <p class="indicator-text mb-2">Data Kelulusan Uji Kompetensi dan Sertifikasi</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data kelulusan UKK dan sertifikasi profesi
                                    untuk tahun terakhir
                                </small>

                                @include('instrument.partials.v2.table-a11', [
                                    'existingData' => $answers['A.1.1'] ?? [],
                                ])
                            </div>
                        </div>

                        {{-- A.1.2: Analisis Skema Sertifikasi dan Kesesuaian KKNI --}}
                        <div class="indicator-group mb-4">
                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">A.1.2</span>
                                </div>
                                <p class="indicator-text mb-2">Analisis Skema Sertifikasi dan Kesesuaian KKNI</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data skema sertifikasi dan kesesuaian dengan
                                    KKNI
                                </small>

                                @include('instrument.partials.v2.table-a12', [
                                    'existingData' => $answers['A.1.2'] ?? [],
                                ])
                            </div>
                        </div>

                        {{-- A.2: Penelusuran Alumni (Tracer Study) --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">A.2</span>
                                Penelusuran Alumni (Tracer Study)
                            </h5>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">A.2.1</span>
                                </div>
                                <p class="indicator-text mb-2">Penelusuran Alumni (Tracer Study)</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data penelusuran alumni berdasarkan tracer
                                    study untuk kelas lulusan tertentu
                                </small>

                                @include('instrument.partials.v2.table-a21', [
                                    'existingData' => $answers['A.2.1'] ?? [],
                                ])
                            </div>
                        </div>

                        {{-- A.3: Data Putus Sekolah dan Ketidaknaikan Kelas --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">A.3</span>
                                Data Putus Sekolah dan Ketidaknaikan Kelas
                            </h5>

                            <div class="indicator-item">
                                <p class="indicator-text mb-2">Data Putus Sekolah dan Ketidaknaikan Kelas</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi Data Putus Sekolah dan Ketidaknaikan Kelas
                                </small>

                                @include('instrument.partials.v2.table-a3', [
                                    'existingData' => $answers['A.3'] ?? [],
                                ])
                            </div>
                        </div>

                        {{-- A.4: Data Skor Rata-rata TKA Tahun 2025 --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">A.4</span>
                                Data Skor Rata-rata TKA Tahun 2025
                            </h5>

                            <div class="indicator-item">
                                <p class="indicator-text mb-2">Data Skor Rata-rata TKA Tahun 2025</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data skor rata-rata TKA untuk mata pelajaran
                                    wajib dan pilihan
                                </small>

                                @include('instrument.partials.v2.table-a4', [
                                    'existingData' => $answers['A.4'] ?? [],
                                ])
                            </div>
                        </div>
                    </div>
                    </div>{{-- end form-step 3 --}}

                    <div class="form-step" data-step="4" style="display:none">
                    {{-- ASPECT B: Data Sarana Prasarana --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-journal-text"></i>
                            <strong>B - Data Sarana Prasarana (Sapras)</strong>
                        </div>

                        {{-- Hidden input to store all sapras data --}}
                        <input type="hidden" name="answers[B.sapras]" id="sapras-data-input"
                            value="{{ old('answers.B.sapras', isset($answers['B.sapras']) ? json_encode($answers['B.sapras']) : '{}') }}">

                        {{-- Placeholder when no concentration is selected --}}
                        <div id="sapras-placeholder" class="text-center py-5">
                            <i class="bi bi-building-gear" style="font-size: 3rem; color: #dee2e6;"></i>
                            <p class="text-muted mt-3 mb-0">Pilih <strong>Konsentrasi Keahlian</strong> pada bagian Data
                                Sekolah di atas untuk menampilkan tabel Sarana Prasarana.</p>
                        </div>

                        {{-- Loading indicator --}}
                        <div id="sapras-loading" class="text-center py-5" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="text-muted mt-3 mb-0">Memuat data sarana prasarana...</p>
                        </div>

                        {{-- Dynamic sapras container --}}
                        <div id="sapras-container" style="display: none;"></div>
                    </div>
                    </div>{{-- end form-step 4 --}}

                    <div class="form-step" data-step="5" style="display:none">
                    {{-- ASPECT C: Data Tata Kelola --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-journal-text"></i>
                            <strong>C - Data Tata Kelola</strong>
                        </div>

                        {{-- C.1: Kerjasama Industri --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">C.1</span>
                                Kerjasama Industri
                            </h5>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">C.1.1</span>
                                    <span class="badge bg-info ms-2">Dynamic Rows</span>
                                </div>
                                <p class="indicator-text mb-2">Kerjasama Industri</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data kerjasama dengan industri mitra
                                </small>

                                @include('instrument.partials.v2.table-c11', [
                                    'existingData' => $answers['C.1.1'] ?? [],
                                ])
                            </div>
                        </div>

                        {{-- C.2: Teaching Factory (TEFA) --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">C.2</span>
                                Teaching Factory (TEFA) / Unit Produksi Sekolah
                            </h5>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">C.2.1</span>
                                    <span class="badge bg-info ms-2">Dynamic Rows</span>
                                </div>
                                <p class="indicator-text mb-2">Teaching Factory (TEFA) / Unit Produksi Sekolah</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data program Teaching Factory atau Unit
                                    Produksi Sekolah
                                </small>

                                @include('instrument.partials.v2.table-c21', [
                                    'existingData' => $answers['C.2.1'] ?? [],
                                ])
                            </div>
                        </div>

                        {{-- C.3: Data Pelatihan dan Sertifikasi Guru --}}
                        <div class="indicator-group mb-4">
                            <h5 class="indicator-header mb-3">
                                <span class="badge bg-secondary me-2">C.3</span>
                                Data Pelatihan dan Sertifikasi Guru/Guru Produktif
                            </h5>

                            <div class="indicator-item mb-3">
                                <div class="mb-2">
                                    <span class="indicator-code">C.3.1</span>
                                    <span class="badge bg-info ms-2">Dynamic Rows</span>
                                </div>
                                <p class="indicator-text mb-2">Data Pelatihan dan Sertifikasi Guru yang Telah Diikuti</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isi data pelatihan dan sertifikasi yang telah
                                    diikuti oleh guru
                                </small>

                                @include('instrument.partials.v2.table-c31', [
                                    'existingData' => $answers['C.3.1'] ?? [],
                                ])
                            </div>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">C.3.2</span>
                                </div>
                                <p class="indicator-text mb-2">Analisis Kebutuhan Pelatihan Guru ke Depan</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>(Diisi oleh Guru/Wakasek Kurikulum/Kepsek)
                                </small>

                                @include('instrument.partials.v2.form-c32', [
                                    'existingData' => $answers['C.3.2'] ?? [],
                                ])
                            </div>

                            <div class="indicator-item">
                                <div class="mb-2">
                                    <span class="indicator-code">C.3.3</span>
                                </div>
                                <p class="indicator-text mb-2">Data Ketenagaan dan Beban Mengajar (Rasio Guru-Murid)</p>
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>Isikan untuk setiap Kompetensi Keahlian
                                    (Konsentrasi) yang aktif
                                </small>

                                @include('instrument.partials.v2.table-c33', [
                                    'existingData' => $answers['C.3.3'] ?? [],
                                ])
                            </div>
                        </div>
                    </div>
                    </div>{{-- end form-step 5 --}}

                    {{-- Wizard Navigation --}}
                    <div class="wizard-nav d-flex justify-content-between align-items-center mt-4 mb-5">
                        <div>
                            <button type="button" id="prevBtn" class="btn btn-outline-secondary rounded-pill px-4 py-2" style="display:none" onclick="goPrev()">
                                <i class="bi bi-arrow-left me-2"></i>Sebelumnya
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('landing') }}" class="btn btn-link text-secondary me-2">
                                <i class="bi bi-x me-1"></i>Batal
                            </a>
                            <button type="button" id="nextBtn" class="btn btn-primary rounded-pill px-4 py-2" onclick="goNext()">
                                Selanjutnya<i class="bi bi-arrow-right ms-2"></i>
                            </button>
                            <button type="submit" id="submitBtn" class="btn btn-success rounded-pill px-4 py-2 fw-bold" style="display:none">
                                <i class="bi bi-send-fill me-2"></i>Perbarui Data Sekolah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Define all functions first (to avoid hoisting issues)
        function initializeDynamicTables() {
            console.log('initializeDynamicTables() called');
            try {
                var addButtons = document.querySelectorAll('.btn-add-row');
                console.log('Found add buttons:', addButtons.length);
                addButtons.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        addTableRow(btn.dataset.tableId);
                    });
                });
            } catch (e) {
                console.error('Error in initializeDynamicTables:', e);
            }
        }

        function initializeTableEventListeners() {
            console.log('initializeTableEventListeners() called');
            document.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove-row')) {
                    const btn = e.target.closest('.btn-remove-row');
                    const row = btn.closest('tr');
                    const tbody = row.closest('tbody');

                    if (tbody.querySelectorAll('tr').length > 1) {
                        row.remove();
                        renumberRows(tbody);
                    } else {
                        alert('Minimal harus ada 1 baris data');
                    }
                }
            });

            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('table-input')) {
                    const row = e.target.closest('tr');
                    if (row) {
                        calculateRowFields(row);
                    }
                }
            });
        }

        function restoreExistingData() {
            // Restore form C.3.2 data if it exists in old() input
            const formC32Input = document.getElementById('form-c32-input');
            if (formC32Input && formC32Input.value) {
                try {
                    const data = JSON.parse(formC32Input.value);
                    if (data) {
                        // Restore competency_gap fields
                        if (data.competency_gap) {
                            const answerField = document.querySelector(
                                '[data-section="competency_gap"][data-field="answer"]');
                            const reasonField = document.querySelector(
                                '[data-section="competency_gap"][data-field="reason"]');
                            if (answerField && data.competency_gap.answer) answerField.value = data.competency_gap.answer;
                            if (reasonField && data.competency_gap.reason) reasonField.value = data.competency_gap.reason;
                        }
                        // Restore industry_alignment fields
                        if (data.industry_alignment) {
                            const answerField = document.querySelector(
                                '[data-section="industry_alignment"][data-field="answer"]');
                            const sourceField = document.querySelector(
                                '[data-section="industry_alignment"][data-field="source"]');
                            if (answerField && data.industry_alignment.answer) answerField.value = data.industry_alignment
                                .answer;
                            if (sourceField && data.industry_alignment.source) sourceField.value = data.industry_alignment
                                .source;
                        }
                        // Restore training_priority fields
                        if (data.training_priority) {
                            const answerField = document.querySelector(
                                '[data-section="training_priority"][data-field="answer"]');
                            if (answerField && data.training_priority.answer) answerField.value = data.training_priority
                                .answer;
                        }
                    }
                } catch (e) {
                    console.log('No existing data to restore for form-c32');
                }
            }
        }

        function addTableRow(tableId) {
            const table = document.getElementById(tableId);
            const tbody = table.querySelector('tbody');
            const templateRow = tbody.querySelector('tr:last-child');
            const newRow = templateRow.cloneNode(true);
            const rowIndex = tbody.querySelectorAll('tr').length; // new row's index
            const oldIndex = rowIndex - 1; // cloned row's index

            newRow.querySelectorAll('input, select, textarea').forEach(input => {
                if (input.type === 'radio' || input.type === 'checkbox') {
                    input.checked = false;
                } else {
                    input.value = '';
                }

                // Update bracket-style names like answers[C.1.1][1]
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name',
                        name.replace(/\[\d+\]/, `[${rowIndex}]`)
                        .replace(new RegExp(`_${oldIndex}$`), `_${rowIndex}`)
                    );
                }

                // Update id suffixes like mou_aktif_1 → mou_aktif_2
                const id = input.getAttribute('id');
                if (id) {
                    input.setAttribute('id', id.replace(new RegExp(`_${oldIndex}$`), `_${rowIndex}`));
                }

                input.dataset.row = rowIndex;
            });

            // Update label for= attributes so they point to the new input ids
            newRow.querySelectorAll('label[for]').forEach(label => {
                const forAttr = label.getAttribute('for');
                if (forAttr) {
                    label.setAttribute('for', forAttr.replace(new RegExp(`_${oldIndex}$`), `_${rowIndex}`));
                }
            });

            const rowNumCell = newRow.querySelector('.row-number');
            if (rowNumCell) {
                rowNumCell.textContent = rowIndex + 1;
            }

            tbody.appendChild(newRow);
        }

        function renumberRows(tbody) {
            tbody.querySelectorAll('tr').forEach((row, index) => {
                const oldIndex = parseInt(row.dataset.row ?? index);

                const rowNumCell = row.querySelector('.row-number');
                if (rowNumCell) {
                    rowNumCell.textContent = index + 1;
                }

                row.querySelectorAll('input, select, textarea').forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name',
                            name.replace(/\[\d+\]/, `[${index}]`)
                            .replace(new RegExp(`_${oldIndex}$`), `_${index}`)
                        );
                    }

                    const id = input.getAttribute('id');
                    if (id) {
                        input.setAttribute('id', id.replace(new RegExp(`_${oldIndex}$`), `_${index}`));
                    }

                    input.dataset.row = index;
                });

                row.querySelectorAll('label[for]').forEach(label => {
                    const forAttr = label.getAttribute('for');
                    if (forAttr) {
                        label.setAttribute('for', forAttr.replace(new RegExp(`_${oldIndex}$`),
                        `_${index}`));
                    }
                });

                row.dataset.row = index;
            });
        }

        function calculateRowFields(row) {
            // Calculate pass rate for table-a11
            const totalParticipants = row.querySelector('[data-key="total_participants"]');
            const totalPassed = row.querySelector('[data-key="total_passed"]');
            const passRate = row.querySelector('[data-key="pass_rate"]');

            if (totalParticipants && totalPassed && passRate) {
                const participants = parseFloat(totalParticipants.value) || 0;
                const passed = parseFloat(totalPassed.value) || 0;

                if (participants > 0) {
                    passRate.value = ((passed / participants) * 100).toFixed(2);
                } else {
                    passRate.value = '0.00';
                }
            }

            // Calculate dropout percentage for table-a3
            const initialStudents = row.querySelector('[data-key="initial_students"]');
            const dropouts = row.querySelector('[data-key="dropouts"]');
            const dropoutPercentage = row.querySelector('[data-key="dropout_percentage"]');

            if (initialStudents && dropouts && dropoutPercentage) {
                const initial = parseFloat(initialStudents.value) || 0;
                const dropped = parseFloat(dropouts.value) || 0;

                if (initial > 0) {
                    dropoutPercentage.value = ((dropped / initial) * 100).toFixed(2);
                } else {
                    dropoutPercentage.value = '0.00';
                }
            }

            // Calculate TKA score difference for table-a4
            const inputs = row.querySelectorAll('.table-input');
            let schoolAvg = null;
            let nationalAvg = null;
            let differenceField = null;

            inputs.forEach(input => {
                const key = input.dataset.key;
                if (key && key.endsWith('_school_avg')) {
                    schoolAvg = input;
                } else if (key && key.endsWith('_national_avg')) {
                    nationalAvg = input;
                } else if (key && key.endsWith('_difference')) {
                    differenceField = input;
                }
            });

            if (schoolAvg && nationalAvg && differenceField) {
                const school = parseFloat(schoolAvg.value) || 0;
                const national = parseFloat(nationalAvg.value) || 0;
                const diff = school - national;
                differenceField.value = diff.toFixed(2);
            }

            // Calculate teacher:student ratio for table-c33
            const teacherCount = row.querySelector('[data-key="teacher_count"]');
            const studentCount = row.querySelector('[data-key="student_count"]');
            const ratioField = row.querySelector('[data-key="ratio"]');

            if (teacherCount && studentCount && ratioField) {
                const teachers = parseFloat(teacherCount.value) || 0;
                const students = parseFloat(studentCount.value) || 0;

                if (teachers > 0 && students > 0) {
                    const ratio = Math.round(students / teachers);
                    ratioField.value = '1:' + ratio;
                } else {
                    ratioField.value = '';
                }
            }
        }

        function collectTableData(table) {
            const data = {
                header: {},
                rows: []
            };

            const headerInputs = table.closest('.table-card, .card')?.querySelectorAll('.header-input');
            if (headerInputs) {
                headerInputs.forEach(input => {
                    const key = input.dataset.key;
                    if (key) {
                        data.header[key] = input.value;
                    }
                });
            }

            table.querySelectorAll('tbody tr').forEach(row => {
                const rowData = {};

                row.querySelectorAll('input, select, textarea').forEach(input => {
                    const key = input.dataset.key;
                    if (key) {
                        if (input.type === 'radio') {
                            if (input.checked) {
                                rowData[key] = input.value;
                            }
                        } else if (input.type === 'checkbox') {
                            rowData[key] = input.checked;
                        } else {
                            rowData[key] = input.value;
                        }
                    }
                });

                if (Object.keys(rowData).length > 0) {
                    data.rows.push(rowData);
                }
            });

            return data;
        }

        function collectFormData(formId) {
            const form = document.getElementById(formId);
            const data = {};

            if (form) {
                form.querySelectorAll('input, select, textarea').forEach(input => {
                    const section = input.dataset.section;
                    const field = input.dataset.field;

                    if (section && field) {
                        if (!data[section]) {
                            data[section] = {};
                        }
                        data[section][field] = input.value;
                    }
                });
            }

            return data;
        }

        function collectAllTableData() {
            console.log('collectAllTableData() called');
            const tables = ['table-a11', 'table-a12', 'table-a21', 'table-a3', 'table-a4',
                'table-c11',
                'table-c21',
                'table-c31', 'table-c32', 'table-c33'
            ];

            tables.forEach(tableId => {
                const table = document.getElementById(tableId);
                if (table) {
                    const hiddenInput = document.getElementById(tableId + '-input');
                    if (hiddenInput) {
                        const data = collectTableData(table);
                        console.log(`Table ${tableId} data:`, data);
                        // Only update if there's data in the table
                        if (data.rows.length > 0 || Object.keys(data.header).length > 0) {
                            hiddenInput.value = JSON.stringify(data);
                        }
                    }
                } else {
                    console.warn(`Table ${tableId} not found`);
                }
            });

            // Collect dynamic sapras data
            collectSaprasData();

        }

        function loadRegencies(provinceCode) {
            const regencySelect = document.getElementById('regencySelect');

            console.log('loadRegencies called with provinceCode:', provinceCode);

            if (!provinceCode) {
                regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                regencySelect.disabled = true;
                return;
            }

            regencySelect.disabled = true;
            regencySelect.innerHTML = '<option value="">-- Memuat data --</option>';

            fetch(`/api/regencies/${provinceCode}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Regencies loaded:', data);
                    regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                    data.forEach(regency => {
                        const option = document.createElement('option');
                        option.value = regency.code;
                        option.textContent = regency.name;
                        console.log('Adding regency option:', regency.code, regency.name);
                        regencySelect.appendChild(option);
                    });
                    regencySelect.disabled = false;

                    // Restore selected regency
                    @if ($submission->regency_code)
                        const savedRegencyCode = '{{ $submission->regency_code }}';
                        if (savedRegencyCode) {
                            regencySelect.value = savedRegencyCode;
                        }
                    @endif
                })
                .catch(error => {
                    console.error('Error loading regencies:', error);
                    regencySelect.innerHTML = '<option value="">-- Terjadi kesalahan --</option>';
                    regencySelect.disabled = true;
                });
        }

        // Expertise cascading dropdowns - loaded from config
        const expertiseData = @json($expertiseData ?? []);
        window.expertiseByCurriculum = @json($expertiseByCurriculum ?? []);

        function getActiveExpertiseTree() {
            const checked = document.querySelector('input[name="curriculum"]:checked');
            if (checked && window.expertiseByCurriculum && window.expertiseByCurriculum[checked.value]) {
                return window.expertiseByCurriculum[checked.value];
            }
            return expertiseData;
        }

        function repopulateExpertiseSelect() {
            const tree = getActiveExpertiseTree();
            const expertiseSelect = document.getElementById('expertiseSelect');
            const programSelect = document.getElementById('expertiseProgramSelect');
            const concentrationSelect = document.getElementById('expertiseConcentrationSelect');

            expertiseSelect.innerHTML = '<option value="">-- Pilih Bidang Keahlian --</option>';
            programSelect.innerHTML = '<option value="">-- Pilih Program Keahlian --</option>';
            programSelect.disabled = true;
            concentrationSelect.innerHTML = '<option value="">-- Pilih Konsentrasi Keahlian --</option>';
            concentrationSelect.disabled = true;

            Object.keys(tree).forEach(function(name) {
                const opt = document.createElement('option');
                opt.value = name;
                opt.textContent = name;
                expertiseSelect.appendChild(opt);
            });

            resetSaprasContainer();
        }

        function loadExpertisePrograms(expertise) {
            const tree = getActiveExpertiseTree();
            const programSelect = document.getElementById('expertiseProgramSelect');
            const concentrationSelect = document.getElementById('expertiseConcentrationSelect');
            const approvalWrapper = document.getElementById('approval-status-wrapper');

            // Reset program dropdown
            programSelect.innerHTML = '<option value="">-- Pilih Program Keahlian --</option>';
            programSelect.disabled = true;

            // Reset concentration dropdown
            concentrationSelect.innerHTML = '<option value="">-- Pilih Konsentrasi Keahlian --</option>';
            concentrationSelect.disabled = true;

            // Show approval_status only for Kemaritiman
            if (approvalWrapper) {
                approvalWrapper.style.display = expertise === 'Kemaritiman' ? '' : 'none';
            }

            if (!expertise || !tree[expertise]) {
                return;
            }

            // Populate program dropdown
            const programs = tree[expertise].programs;
            programs.forEach(program => {
                const option = document.createElement('option');
                option.value = program;
                option.textContent = program;
                programSelect.appendChild(option);
            });

            programSelect.disabled = false;
        }

        function loadExpertiseConcentrations(program) {
            const tree = getActiveExpertiseTree();
            const concentrationSelect = document.getElementById('expertiseConcentrationSelect');
            const expertiseSelect = document.getElementById('expertiseSelect');
            const expertise = expertiseSelect.value;

            // Reset concentration dropdown
            concentrationSelect.innerHTML = '<option value="">-- Pilih Konsentrasi Keahlian --</option>';
            concentrationSelect.disabled = true;

            if (!expertise || !program || !tree[expertise]) {
                return;
            }

            // Populate concentration dropdown
            const concentrations = tree[expertise].concentrations[program];
            if (concentrations) {
                concentrations.forEach(concentration => {
                    const option = document.createElement('option');
                    option.value = concentration;
                    option.textContent = concentration;
                    concentrationSelect.appendChild(option);
                });
                concentrationSelect.disabled = false;

                // Reset sapras when program changes
                resetSaprasContainer();
            }
        }

        // ===== SAPRAS DYNAMIC TABLES =====

        function loadSaprasData(concentration) {
            const placeholder = document.getElementById('sapras-placeholder');
            const loading = document.getElementById('sapras-loading');
            const container = document.getElementById('sapras-container');

            if (!concentration) {
                resetSaprasContainer();
                return;
            }

            // Show loading, hide others
            placeholder.style.display = 'none';
            container.style.display = 'none';
            loading.style.display = 'block';

            fetch(`/api/sapras-data/${encodeURIComponent(concentration)}`)
                .then(response => response.json())
                .then(data => {
                    loading.style.display = 'none';
                    if (data.sections && data.sections.length > 0) {
                        renderSaprasSections(data.sections, container);
                        container.style.display = 'block';
                        // Restore previously saved sapras values
                        const saprasHiddenInput = document.getElementById('sapras-data-input');
                        try {
                            const existing = JSON.parse(saprasHiddenInput.value || '{}');
                            if (existing && existing.sections && existing.sections.length > 0) {
                                restoreSaprasValues(existing);
                            }
                        } catch (e) {
                            console.log('No existing sapras data to restore.');
                        }
                    } else {
                        placeholder.innerHTML = `
                            <i class="bi bi-exclamation-circle" style="font-size: 3rem; color: #ffc107;"></i>
                            <p class="text-muted mt-3 mb-0">Data sarana prasarana untuk <strong>${concentration}</strong> belum tersedia.</p>
                        `;
                        placeholder.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error loading sapras data:', error);
                    loading.style.display = 'none';
                    placeholder.innerHTML = `
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem; color: #dc3545;"></i>
                        <p class="text-muted mt-3 mb-0">Terjadi kesalahan saat memuat data. Silakan coba lagi.</p>
                    `;
                    placeholder.style.display = 'block';
                });
        }

        function resetSaprasContainer() {
            const placeholder = document.getElementById('sapras-placeholder');
            const loading = document.getElementById('sapras-loading');
            const container = document.getElementById('sapras-container');

            placeholder.innerHTML = `
                <i class="bi bi-building-gear" style="font-size: 3rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3 mb-0">Pilih <strong>Konsentrasi Keahlian</strong> pada bagian Data Sekolah di atas untuk menampilkan tabel Sarana Prasarana.</p>
            `;
            placeholder.style.display = 'block';
            loading.style.display = 'none';
            container.style.display = 'none';
            container.innerHTML = '';
        }

        function renderSaprasSections(sections, container) {
            container.innerHTML = '';

            sections.forEach((section, sIdx) => {
                const sectionNum = sIdx + 1;
                const sectionDiv = document.createElement('div');
                sectionDiv.className = 'indicator-group mb-4';
                sectionDiv.dataset.sectionIndex = sIdx;

                let tableHtml = '';

                switch (section.type) {
                    case 'room':
                        tableHtml = renderRoomTable(section, sectionNum);
                        break;
                    case 'equipment':
                        tableHtml = renderEquipmentTable(section, sectionNum);
                        break;
                    case 'equipment_no_spec':
                        tableHtml = renderEquipmentNoSpecTable(section, sectionNum);
                        break;
                    case 'equipment_gim':
                        tableHtml = renderEquipmentGimTable(section, sectionNum);
                        break;
                    case 'k3':
                        tableHtml = renderK3Table(section, sectionNum);
                        break;
                    case 'utility':
                        tableHtml = renderUtilityTable(section, sectionNum);
                        break;
                    case 'culture':
                        tableHtml = renderCultureTable(section, sectionNum);
                        break;
                    default:
                        tableHtml = renderEquipmentTable(section, sectionNum);
                }

                sectionDiv.innerHTML = `
                    <h5 class="indicator-header mb-3">
                        <span class="badge bg-secondary me-2">B.${sectionNum}</span>
                        ${section.title}
                    </h5>
                    <div class="indicator-item">
                        ${tableHtml}
                    </div>
                `;

                container.appendChild(sectionDiv);
            });
        }

        function renderEquipmentTable(section, sectionNum) {
            let rows = '';
            section.items.forEach((item, i) => {
                rows += `
                    <tr data-section="${sectionNum}" data-row="${i}">
                        <td class="text-center">${i + 1}</td>
                        <td><strong>${item.name}</strong></td>
                        <td><small class="text-muted">${item.spec || '-'}</small></td>
                        <td class="text-center"><span class="badge bg-light text-dark">${item.standard_qty}</span></td>
                        <td><input type="number" class="form-control form-control-sm table-input sapras-input" data-key="qty_available" placeholder="0" min="0"></td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="condition">
                                <option value="">Pilih</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="industry_standard">
                                <option value="">Pilih</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                                <option value="Sebagian">Sebagian</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control form-control-sm table-input sapras-input" data-key="remarks" placeholder="Keterangan"></td>
                    </tr>`;
            });

            return `
                <div class="table-responsive">
                    <table class="table instrument-table mb-0" id="sapras-table-${sectionNum}">
                        <thead>
                            <tr>
                                <th style="width:4%">No</th>
                                <th style="width:18%">Nama Peralatan</th>
                                <th style="width:18%">Spesifikasi Minimal</th>
                                <th style="width:10%">Jumlah Standar</th>
                                <th style="width:10%">Jumlah Tersedia</th>
                                <th style="width:10%">Kondisi</th>
                                <th style="width:14%">Kesesuaian Standar Industri</th>
                                <th style="width:16%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>`;
        }

        function renderRoomTable(section, sectionNum) {
            let rows = '';
            section.items.forEach((item, i) => {
                rows += `
                    <tr data-section="${sectionNum}" data-row="${i}">
                        <td class="text-center">${i + 1}</td>
                        <td><strong>${item.name}</strong></td>
                        <td class="text-center"><span class="badge bg-light text-dark">${item.standard_area}</span></td>
                        <td class="text-center">${item.capacity}</td>
                        <td><input type="text" class="form-control form-control-sm table-input sapras-input" data-key="actual_area" placeholder="m²"></td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="available">
                                <option value="">Pilih</option>
                                <option value="Ada">Ada</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="industry_standard">
                                <option value="">Pilih</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                                <option value="Sebagian">Sebagian</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control form-control-sm table-input sapras-input" data-key="remarks" placeholder="Keterangan"></td>
                    </tr>`;
            });

            return `
                <div class="table-responsive">
                    <table class="table instrument-table mb-0" id="sapras-table-${sectionNum}">
                        <thead>
                            <tr>
                                <th style="width:4%">No</th>
                                <th style="width:22%">Jenis Ruang</th>
                                <th style="width:12%">Standar Luas Minimal</th>
                                <th style="width:10%">Kapasitas</th>
                                <th style="width:12%">Luas Tersedia (m²)</th>
                                <th style="width:10%">Ada/Tidak</th>
                                <th style="width:12%">Kesesuaian Standar Industri</th>
                                <th style="width:18%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>`;
        }

        function renderEquipmentNoSpecTable(section, sectionNum) {
            let rows = '';
            section.items.forEach((item, i) => {
                rows += `
                    <tr data-section="${sectionNum}" data-row="${i}">
                        <td class="text-center">${i + 1}</td>
                        <td><strong>${item.name}</strong></td>
                        <td class="text-center"><span class="badge bg-light text-dark">${item.standard_qty}</span></td>
                        <td><input type="number" class="form-control form-control-sm table-input sapras-input" data-key="qty_available" placeholder="0" min="0"></td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="condition">
                                <option value="">Pilih</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="industry_standard">
                                <option value="">Pilih</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                                <option value="Sebagian">Sebagian</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control form-control-sm table-input sapras-input" data-key="remarks" placeholder="Keterangan"></td>
                    </tr>`;
            });

            return `
                <div class="table-responsive">
                    <table class="table instrument-table mb-0" id="sapras-table-${sectionNum}">
                        <thead>
                            <tr>
                                <th style="width:4%">No</th>
                                <th style="width:26%">Nama Peralatan</th>
                                <th style="width:12%">Jumlah Standar</th>
                                <th style="width:12%">Jumlah Tersedia</th>
                                <th style="width:12%">Kondisi</th>
                                <th style="width:14%">Kesesuaian Standar Industri</th>
                                <th style="width:20%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>`;
        }

        function renderK3Table(section, sectionNum) {
            let rows = '';
            section.items.forEach((item, i) => {
                rows += `
                    <tr data-section="${sectionNum}" data-row="${i}">
                        <td class="text-center">${i + 1}</td>
                        <td><strong>${item.name}</strong></td>
                        <td><small class="text-muted">${item.spec || '-'}</small></td>
                        <td class="text-center"><span class="badge bg-light text-dark">${item.standard_qty}</span></td>
                        <td><input type="number" class="form-control form-control-sm table-input sapras-input" data-key="qty_available" placeholder="0" min="0"></td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="condition">
                                <option value="">Pilih</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="industry_standard">
                                <option value="">Pilih</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                                <option value="Sebagian">Sebagian</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control form-control-sm table-input sapras-input" data-key="remarks" placeholder="Keterangan"></td>
                    </tr>`;
            });

            return `
                <div class="table-responsive">
                    <table class="table instrument-table mb-0" id="sapras-table-${sectionNum}">
                        <thead>
                            <tr>
                                <th style="width:4%">No</th>
                                <th style="width:16%">Komponen</th>
                                <th style="width:16%">Standar Minimal</th>
                                <th style="width:10%">Jumlah Standar</th>
                                <th style="width:10%">Jumlah Tersedia</th>
                                <th style="width:10%">Kondisi</th>
                                <th style="width:14%">Kesesuaian Standar Industri</th>
                                <th style="width:20%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>`;
        }

        function renderUtilityTable(section, sectionNum) {
            let rows = '';
            section.items.forEach((item, i) => {
                rows += `
                    <tr data-section="${sectionNum}" data-row="${i}">
                        <td class="text-center">${i + 1}</td>
                        <td><strong>${item.name}</strong></td>
                        <td><small class="text-muted">${item.spec || '-'}</small></td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="compliance">
                                <option value="">Pilih</option>
                                <option value="Sesuai Standar Minimal">Sesuai Standar Minimal</option>
                                <option value="Tidak Sesuai Standar Minimal">Tidak Sesuai</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="industry_standard">
                                <option value="">Pilih</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                                <option value="Sebagian">Sebagian</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control form-control-sm table-input sapras-input" data-key="remarks" placeholder="Keterangan"></td>
                    </tr>`;
            });

            return `
                <div class="table-responsive">
                    <table class="table instrument-table mb-0" id="sapras-table-${sectionNum}">
                        <thead>
                            <tr>
                                <th style="width:4%">No</th>
                                <th style="width:22%">Komponen</th>
                                <th style="width:22%">Standar Minimal</th>
                                <th style="width:18%">Kesesuaian</th>
                                <th style="width:14%">Kesesuaian Standar Industri</th>
                                <th style="width:20%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>`;
        }

        function renderCultureTable(section, sectionNum) {
            let rows = '';
            section.items.forEach((item, i) => {
                rows += `
                    <tr data-section="${sectionNum}" data-row="${i}">
                        <td class="text-center">${i + 1}</td>
                        <td><strong>${item.name}</strong></td>
                        <td>
                            <select class="form-select form-select-sm table-input sapras-input" data-key="status">
                                <option value="">Pilih</option>
                                <option value="Ada, Efektif">Ada, Efektif</option>
                                <option value="Ada, Tidak Efektif">Ada, Tidak Efektif</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control form-control-sm table-input sapras-input" data-key="remarks" placeholder="Keterangan"></td>
                    </tr>`;
            });

            return `
                <div class="table-responsive">
                    <table class="table instrument-table mb-0" id="sapras-table-${sectionNum}">
                        <thead>
                            <tr>
                                <th style="width:4%">No</th>
                                <th style="width:40%">Komponen</th>
                                <th style="width:26%">Status</th>
                                <th style="width:30%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>`;
        }

        function restoreSaprasValues(existingData) {
            if (!existingData || !existingData.sections) return;
            const container = document.getElementById('sapras-container');
            if (!container) return;
            const sectionDivs = container.querySelectorAll('.indicator-group');

            existingData.sections.forEach((savedSection, sIdx) => {
                if (!sectionDivs[sIdx]) return;
                const rows = sectionDivs[sIdx].querySelectorAll('tbody tr');
                (savedSection.rows || []).forEach((rowData, rIdx) => {
                    if (!rows[rIdx]) return;
                    rows[rIdx].querySelectorAll('.sapras-input').forEach(input => {
                        const key = input.dataset.key;
                        if (key && rowData[key] !== undefined && rowData[key] !== null) {
                            input.value = rowData[key];
                        }
                    });
                });
            });
        }

        function collectSaprasData() {
            const container = document.getElementById('sapras-container');
            const hiddenInput = document.getElementById('sapras-data-input');

            if (!container || container.style.display === 'none') {
                // Don't clobber existing saved data if container is just not yet rendered
                try {
                    const existing = JSON.parse(hiddenInput.value || '{}');
                    if (!existing || !existing.sections || existing.sections.length === 0) {
                        hiddenInput.value = '{}';
                    }
                } catch (e) {
                    hiddenInput.value = '{}';
                }
                return;
            }

            const saprasData = {
                sections: []
            };

            container.querySelectorAll('.indicator-group').forEach(sectionDiv => {
                const sectionIndex = parseInt(sectionDiv.dataset.sectionIndex);
                const title = sectionDiv.querySelector('.indicator-header')?.textContent?.trim() || '';

                const sectionData = {
                    title: title,
                    rows: []
                };

                sectionDiv.querySelectorAll('tbody tr').forEach(row => {
                    const rowData = {};

                    // Get the predefined text from td cells (name, spec, etc.)
                    const tds = row.querySelectorAll('td');
                    if (tds.length > 1) {
                        const nameEl = tds[1].querySelector('strong');
                        if (nameEl) rowData.name = nameEl.textContent.trim();
                    }

                    // Get user-filled inputs
                    row.querySelectorAll('.sapras-input').forEach(input => {
                        const key = input.dataset.key;
                        if (key) {
                            rowData[key] = input.value;
                        }
                    });

                    if (Object.keys(rowData).length > 0) {
                        sectionData.rows.push(rowData);
                    }
                });

                saprasData.sections.push(sectionData);
            });

            hiddenInput.value = JSON.stringify(saprasData);
        }

        function toggleSmkPkColumn() {
            const selected = document.querySelector('input[name="school_category"]:checked');
            const isSmkPk = selected && selected.value === 'SMK PK';
            document.querySelectorAll('.col-smk-pk-std').forEach(function(el) {
                el.style.display = isSmkPk ? '' : 'none';
            });
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOMContentLoaded - Initializing...');
            initializeDynamicTables();
            initializeTableEventListeners();
            restoreExistingData();
            collectAllTableData();

            // Restore approval_status visibility
            const initialExpertise = document.getElementById('expertiseSelect')?.value;
            const approvalWrapper = document.getElementById('approval-status-wrapper');
            if (approvalWrapper && initialExpertise === 'Kemaritiman') {
                approvalWrapper.style.display = '';
            }

            // Toggle SMK PK column on school_category change
            toggleSmkPkColumn();
            document.querySelectorAll('input[name="school_category"]').forEach(function(radio) {
                radio.addEventListener('change', toggleSmkPkColumn);
            });

            // Attach curriculum radio change listener — swap expertise tree
            document.querySelectorAll('input[name="curriculum"]').forEach(function(radio) {
                radio.addEventListener('change', repopulateExpertiseSelect);
            });

            const form = document.getElementById('instrumentForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submit - collecting table data...');
                    collectAllTableData();
                    collectSaprasData(); // Collect Sapras data before submission

                    if (!confirm('Apakah Anda yakin data yang diisi sudah benar?')) {
                        e.preventDefault();
                    }
                });
            } else {
                console.error('Form element not found!');
            }
            // Restore expertise fields if submission has data
            @php
                $schoolExpertise = $submission->school->expertise ?: $submission->expertise ?? null;
                $schoolExpertiseProgram = $submission->school->expertise_program ?: $submission->expertise_program ?? null;
                $schoolExpertiseConcentration = $submission->school->expertise_concentration ?: $submission->expertise_concentration ?? null;
            @endphp
            @if ($schoolExpertise)
                // Rebuild expertise dropdown options based on the selected curriculum
                // (the static HTML only contains the default tree; curriculum-specific values like
                // 'Agribisnis dan Agriteknologi' only appear after repopulateExpertiseSelect runs)
                repopulateExpertiseSelect();

                const expertiseSelect = document.getElementById('expertiseSelect');
                const savedExpertise = '{{ $schoolExpertise }}';
                expertiseSelect.value = savedExpertise;
                loadExpertisePrograms(savedExpertise);

                @if ($schoolExpertiseProgram)
                    setTimeout(() => {
                        const programSelect = document.getElementById('expertiseProgramSelect');
                        const savedProgram = '{{ $schoolExpertiseProgram }}';
                        programSelect.value = savedProgram;
                        // Trigger change event to ensure proper state
                        loadExpertiseConcentrations(savedProgram);

                        @if ($schoolExpertiseConcentration)
                            setTimeout(() => {
                                const concentrationSelect = document.getElementById(
                                    'expertiseConcentrationSelect');
                                const savedConcentration = '{{ $schoolExpertiseConcentration }}';
                                concentrationSelect.value = savedConcentration;

                                // Verify the value was set
                                if (concentrationSelect.value === savedConcentration) {
                                    console.log('Concentration selected:', savedConcentration);
                                    // Auto-load Sapras data for existing concentration
                                    loadSaprasData(savedConcentration);
                                } else {
                                    console.warn('Failed to select concentration:',
                                        savedConcentration);
                                    console.warn('Available options:', Array.from(
                                        concentrationSelect.options).map(o => o.value));
                                }
                            }, 200);
                        @endif
                    }, 200);
                @endif
            @endif
        });

        // ===== WIZARD STEP NAVIGATION =====
        var currentStep = 1;
        var totalSteps = 5;

        function showStep(step) {
            document.querySelectorAll('.form-step').forEach(function(el) {
                el.style.display = 'none';
            });
            var stepEl = document.querySelector('.form-step[data-step="' + step + '"]');
            if (stepEl) stepEl.style.display = 'block';

            document.querySelectorAll('.wizard-stepper .wizard-step').forEach(function(el) {
                var stepNum = parseInt(el.dataset.step);
                el.classList.remove('active', 'completed');
                if (stepNum === step) el.classList.add('active');
                else if (stepNum < step) el.classList.add('completed');
            });

            document.querySelectorAll('.wizard-step-connector').forEach(function(el, idx) {
                if (idx < step - 1) el.classList.add('completed');
                else el.classList.remove('completed');
            });

            var prevBtn = document.getElementById('prevBtn');
            var nextBtn = document.getElementById('nextBtn');
            var submitBtn = document.getElementById('submitBtn');
            if (prevBtn) prevBtn.style.display = step > 1 ? 'inline-block' : 'none';
            if (nextBtn) nextBtn.style.display = step < totalSteps ? 'inline-block' : 'none';
            if (submitBtn) submitBtn.style.display = step === totalSteps ? 'inline-block' : 'none';

            currentStep = step;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function goNext() {
            if (validateCurrentStep()) {
                showStep(currentStep + 1);
            }
        }

        function goPrev() {
            showStep(currentStep - 1);
        }

        function validateCurrentStep() {
            var stepEl = document.querySelector('.form-step[data-step="' + currentStep + '"]');
            if (!stepEl) return true;
            var requiredFields = stepEl.querySelectorAll('[required]');
            var valid = true;
            requiredFields.forEach(function(field) {
                var isEmpty = false;
                if (field.type === 'checkbox' || field.type === 'radio') {
                    var name = field.name;
                    var checked = stepEl.querySelector('[name="' + name + '"]:checked');
                    isEmpty = !checked;
                } else {
                    isEmpty = !field.value || !field.value.trim();
                }
                if (isEmpty) {
                    field.classList.add('is-invalid');
                    if (valid) field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    valid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            return valid;
        }

        function goToFirstErrorStep() {
            for (var s = 1; s <= totalSteps; s++) {
                var stepEl = document.querySelector('.form-step[data-step="' + s + '"]');
                if (stepEl && stepEl.querySelector('.is-invalid')) {
                    showStep(s);
                    return;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            showStep(1);
            goToFirstErrorStep();
        });
    </script>
@endpush
