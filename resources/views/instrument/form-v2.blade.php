@extends('layouts.app')

@section('title', 'Isi Instrumen - Penjaminan Mutu SMK Bidang KPTK')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/instrument-form-v2.css') }}">
@endpush

@section('content')
    <div class="container-fluid py-5" style="max-width: 1400px;">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-2 text-primary">Instrumen Penjaminan Mutu</h2>
                    <p class="text-secondary small">Lengkapi data sekolah dan penilaian di bawah ini dengan seksama</p>
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

                <form action="{{ route('instrument.v2.submit') }}" method="POST" id="instrumentForm">
                    @csrf

                    {{-- Section 1: Identitas Sekolah --}}
                    <div class="form-card mt-3">
                        <div class="section-title">
                            <i class="bi bi-building"></i>
                            <strong>
                                Identitas Sekolah
                            </strong>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="school_name"
                                    class="form-control @error('school_name') is-invalid @enderror" required
                                    value="{{ old('school_name', $schoolDefaults->school_name ?? '') }}"
                                    placeholder="Nama sekolah">
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NPSN <span class="text-danger">*</span></label>
                                <input type="text" name="npsn" class="form-control @error('npsn') is-invalid @enderror" required
                                    value="{{ old('npsn', $schoolDefaults->npsn ?? '') }}" placeholder="NPSN">
                                @error('npsn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <select name="province_code" id="provinceSelect"
                                    class="form-select @error('province_code') is-invalid @enderror" required
                                    onchange="loadRegencies(this.value)">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->code }}"
                                            {{ old('province_code', $schoolDefaults->province_code ?? '') == $province->code ? 'selected' : '' }}>
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
                                    class="form-select @error('regency_code') is-invalid @enderror" required disabled>
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                </select>
                                @error('regency_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required
                                    placeholder="Masukkan alamat lengkap sekolah">{{ old('address', $schoolDefaults->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Sekolah <span class="text-danger">*</span></label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="school_status"
                                            id="statusNegeri" value="Negeri" required
                                            {{ old('school_status', $schoolDefaults->school_status ?? '') == 'Negeri' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusNegeri">Negeri</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="school_status"
                                            id="statusSwasta" value="Swasta" required
                                            {{ old('school_status', $schoolDefaults->school_status ?? '') == 'Swasta' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusSwasta">Swasta</label>
                                    </div>
                                </div>
                                @error('school_status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Durasi Program <span class="text-danger">*</span></label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="program_duration"
                                            id="duration3" value="3 Tahun" required
                                            {{ old('program_duration', $schoolDefaults->program_duration ?? '') == '3 Tahun' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="duration3">3 Tahun</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="program_duration"
                                            id="duration4" value="4 Tahun" required
                                            {{ old('program_duration', $schoolDefaults->program_duration ?? '') == '4 Tahun' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="duration4">4 Tahun</label>
                                    </div>
                                </div>
                                @error('program_duration')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Kategori Sekolah <span class="text-danger">*</span></label>
                                <div class="mt-2">
                                    @foreach (config('constant.school_category') as $value => $label)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="school_category"
                                                id="cat{{ Str::slug($value) }}" value="{{ $value }}" required
                                                {{ old('school_category', $schoolDefaults->school_category ?? '') == $value ? 'checked' : '' }}>
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
                                <label class="form-label">Kurikulum <span class="text-danger">*</span></label>
                                <div class="mt-2">
                                    @foreach (config('constant.curriculum') as $cur)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="curriculum"
                                                id="cur{{ Str::slug($cur) }}" value="{{ $cur }}" required
                                                {{ old('curriculum', $schoolDefaults->curriculum ?? '') == $cur ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="cur{{ Str::slug($cur) }}">{{ $cur }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('curriculum')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12" id="approval-status-wrapper" style="display:none;">
                                <label class="form-label">Status Approval <span class="text-danger">*</span></label>
                                <div class="mt-2">
                                    @foreach (config('constant.approval_status') as $status)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="approval_status"
                                                id="appr{{ Str::slug($status) }}" value="{{ $status }}"
                                                {{ old('approval_status', '') == $status ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="appr{{ Str::slug($status) }}">{{ $status }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('approval_status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Akreditasi Sekolah <span class="text-danger">*</span></label>
                                <div class="mt-2">
                                    @foreach (config('constant.school_accreditation') as $acc)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="school_accreditation"
                                                id="acc{{ Str::slug($acc) }}" value="{{ $acc }}" required
                                                {{ old('school_accreditation', $schoolDefaults->school_accreditation ?? '') == $acc ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="acc{{ Str::slug($acc) }}">{{ $acc }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('school_accreditation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                @include('instrument.partials.v2.consentration')
                            </div>
                        </div>
                    </div>

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
                                    value="{{ old('respondent_name') }}" placeholder="Masukkan nama responden">
                                @error('respondent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan Responden <span class="text-danger">*</span></label>
                                <select name="respondent_position"
                                    class="form-select @error('respondent_position') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jabatan Responden --</option>
                                    @foreach ($respondentPositions as $position)
                                        <option value="{{ $position }}"
                                            {{ old('respondent_position') == $position ? 'selected' : '' }}>
                                            {{ $position }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('respondent_position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kontak Responden <span class="text-danger">*</span></label>
                                <input type="text" name="respondent_contact"
                                    class="form-control @error('respondent_contact') is-invalid @enderror" required
                                    value="{{ old('respondent_contact') }}" placeholder="Masukkan kontak responden">
                                @error('respondent_contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

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
                                    <small class="text-muted d-block mb-3">Rekapitulasi UKK dan Sertifikasi per
                                        Tahun</small>
                                    @include('instrument.partials.v2.table-a11')
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
                                        <i class="bi bi-info-circle me-1"></i>Isi data skema sertifikasi dan kesesuaian
                                        dengan
                                        KKNI
                                    </small>

                                    @include('instrument.partials.v2.table-a12')
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
                                        <i class="bi bi-info-circle me-1"></i>Isikan berdasarkan Program/Konsentrasi
                                        Keahlian
                                        di Dapodik/Penelusuran Lulusan
                                    </small>

                                    @include('instrument.partials.v2.table-a21')
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
                                        <i class="bi bi-info-circle me-1"></i>Isi Data Putus Sekolah dan Ketidaknaikan
                                        Kelas
                                    </small>

                                    @include('instrument.partials.v2.table-a3')
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
                                        <i class="bi bi-info-circle me-1"></i>Isikan nilai rata-rata mata pelajaran yang
                                        diujikan di sekolah dan sesuai dengan program/konsentrasi keahlian Murid (Kelautan,
                                        Perikanan, TIK).
                                    </small>
                                    @include('instrument.partials.v2.table-a4')
                                </div>
                            </div>
                        </div>

                        {{-- ASPECT B: Data wPrasarana --}}
                        <div class="form-card mt-3">
                            <div class="section-title">
                                <i class="bi bi-journal-text"></i>
                                <strong>B - Data Sarana Prasarana (Sapras)</strong>
                            </div>

                            {{-- Hidden input to store all sapras data --}}
                            <input type="hidden" name="answers[B.sapras]" id="sapras-data-input" value="{}">

                            {{-- Placeholder when no concentration is selected --}}
                            <div id="sapras-placeholder" class="text-center py-5">
                                <i class="bi bi-building-gear" style="font-size: 3rem; color: #dee2e6;"></i>
                                <p class="text-muted mt-3 mb-0">Pilih <strong>Konsentrasi Keahlian</strong> pada bagian
                                    Data
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

                                    @include('instrument.partials.v2.table-c11')
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

                                    @include('instrument.partials.v2.table-c21')
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
                                    <p class="indicator-text mb-2">Data Pelatihan dan Sertifikasi Guru yang Telah Diikuti
                                    </p>
                                    <small class="text-muted d-block mb-3">
                                        <i class="bi bi-info-circle me-1"></i>Isi data pelatihan dan sertifikasi yang telah
                                        diikuti oleh guru
                                    </small>

                                    @include('instrument.partials.v2.table-c31')
                                </div>

                                <div class="indicator-item">
                                    <div class="mb-2">
                                        <span class="indicator-code">C.3.2</span>
                                    </div>
                                    <p class="indicator-text mb-2">Analisis Kebutuhan Pelatihan Guru ke Depan</p>
                                    <small class="text-muted d-block mb-3">
                                        <i class="bi bi-info-circle me-1"></i>(Diisi oleh Guru/Wakasek Kurikulum/Kepsek)
                                    </small>

                                    @include('instrument.partials.v2.form-c32')
                                </div>

                                <div class="indicator-item">
                                    <div class="mb-2">
                                        <span class="indicator-code">C.3.3</span>
                                    </div>
                                    <p class="indicator-text mb-2">Data Ketenagaan dan Beban Mengajar (Rasio Guru-Murid)
                                    </p>
                                    <small class="text-muted d-block mb-3">
                                        <i class="bi bi-info-circle me-1"></i>Isikan untuk setiap Kompetensi Keahlian
                                        (Konsentrasi) yang aktif
                                    </small>

                                    @include('instrument.partials.v2.table-c33')
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid gap-3 col-lg-6 mx-auto mt-5 mb-5">
                            <button type="submit" class="btn btn-primary btn-lg shadow rounded-pill py-3 fw-bold"
                                style="font-size: 1rem;">
                                <i class="bi bi-send-fill me-2"></i> Kirim Data Instrumen
                            </button>
                            <a href="{{ route('landing') }}" class="btn btn-outline-secondary rounded-pill border-0">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Halaman Utama
                            </a>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeDynamicTables();

            // Restore approval_status visibility on page load (e.g. after validation failure)
            const initialExpertise = document.getElementById('expertiseSelect')?.value;
            const approvalWrapper = document.getElementById('approval-status-wrapper');
            if (approvalWrapper) {
                const isKemaritiman = initialExpertise === 'Kemaritiman';
                approvalWrapper.style.display = isKemaritiman ? '' : 'none';
                approvalWrapper.querySelectorAll('input[name="approval_status"]').forEach(function(radio) {
                    radio.required = isKemaritiman;
                });
            }

            // Toggle "Standar Minimal SMK PK" column on school_category change
            toggleSmkPkColumn();
            document.querySelectorAll('input[name="school_category"]').forEach(function(radio) {
                radio.addEventListener('change', toggleSmkPkColumn);
            });

            document.getElementById('instrumentForm').addEventListener('submit', function(e) {
                collectAllTableData();

                if (!confirm('Apakah Anda yakin data yang diisi sudah benar?')) {
                    e.preventDefault();
                }
            });
        });

        function toggleSmkPkColumn() {
            const selected = document.querySelector('input[name="school_category"]:checked');
            const isSmkPk = selected && selected.value === 'SMK PK';
            document.querySelectorAll('.col-smk-pk-std').forEach(function(el) {
                el.style.display = isSmkPk ? '' : 'none';
            });
        }

        function initializeDynamicTables() {
            document.querySelectorAll('.btn-add-row').forEach(btn => {
                btn.addEventListener('click', function() {
                    addTableRow(this.dataset.tableId);
                });
            });

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

        function addTableRow(tableId) {
            const table = document.getElementById(tableId);
            const tbody = table.querySelector('tbody');
            const templateRow = tbody.querySelector('tr:last-child');
            const newRow = templateRow.cloneNode(true);
            const rowIndex = tbody.querySelectorAll('tr').length;
            const oldIndex = rowIndex - 1;

            newRow.querySelectorAll('input, select, textarea').forEach(input => {
                if (input.type === 'radio' || input.type === 'checkbox') {
                    input.checked = false;
                } else {
                    input.value = '';
                }

                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name',
                        name.replace(/\[\d+\]/, `[${rowIndex}]`)
                        .replace(new RegExp(`_${oldIndex}$`), `_${rowIndex}`)
                    );
                }

                const id = input.getAttribute('id');
                if (id) {
                    input.setAttribute('id', id.replace(new RegExp(`_${oldIndex}$`), `_${rowIndex}`));
                }

                input.dataset.row = rowIndex;
            });

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

        function collectAllTableData() {
            const tables = ['table-a11', 'table-a12', 'table-a21', 'table-a3', 'table-a4', 'table-c11', 'table-c21',
                'table-c31', 'table-c32', 'table-c33'
            ];

            tables.forEach(tableId => {
                const table = document.getElementById(tableId);
                if (table) {
                    const hiddenInput = document.getElementById(tableId + '-input');
                    if (hiddenInput) {
                        const data = collectTableData(table);
                        hiddenInput.value = JSON.stringify(data);
                    }
                }
            });

            // Collect dynamic sapras data
            collectSaprasData();

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

        function loadRegencies(provinceCode) {
            const regencySelect = document.getElementById('regencySelect');

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
                    regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                    data.forEach(regency => {
                        const option = document.createElement('option');
                        option.value = regency.code;
                        option.textContent = regency.name;
                        regencySelect.appendChild(option);
                    });
                    regencySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error loading regencies:', error);
                    regencySelect.innerHTML = '<option value="">-- Terjadi kesalahan --</option>';
                    regencySelect.disabled = true;
                });
        }

        // Expertise cascading dropdowns - loaded from config
        const expertiseData = @json($expertiseData);

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
                const isKemaritiman = expertise === 'Kemaritiman';
                approvalWrapper.style.display = isKemaritiman ? '' : 'none';
                approvalWrapper.querySelectorAll('input[name="approval_status"]').forEach(function(radio) {
                    radio.required = isKemaritiman;
                    if (!isKemaritiman) radio.checked = false;
                });
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

        // Page load - restore old values
        document.addEventListener('DOMContentLoaded', function() {
            // Attach curriculum radio change listener — swap expertise tree
            document.querySelectorAll('input[name="curriculum"]').forEach(function(radio) {
                radio.addEventListener('change', repopulateExpertiseSelect);
            });

            // Restore province and regency if old values exist (fall back to school profile defaults)
            const oldProvinceCode = "{{ old('province_code', $schoolDefaults->province_code ?? '') }}";
            const oldRegencyCode = "{{ old('regency_code', $schoolDefaults->regency_code ?? '') }}";

            if (oldProvinceCode) {
                // Load regencies for the old province
                loadRegencies(oldProvinceCode);

                // After regencies are loaded, select the old regency
                if (oldRegencyCode) {
                    setTimeout(() => {
                        const regencySelect = document.getElementById('regencySelect');
                        regencySelect.value = oldRegencyCode;
                    }, 500); // Wait for API call to complete
                }
            }

            // Restore expertise fields if old values exist
            const expertiseSelect = document.getElementById('expertiseSelect');
            const programSelect = document.getElementById('expertiseProgramSelect');

            if (expertiseSelect.value) {
                loadExpertisePrograms(expertiseSelect.value);

                // If there's an old program value, restore it
                const oldProgram = "{{ old('expertise_program') }}";
                if (oldProgram) {
                    setTimeout(() => {
                        programSelect.value = oldProgram;
                        loadExpertiseConcentrations(oldProgram);

                        // If there's an old concentration value, restore it
                        const oldConcentration = "{{ old('expertise_concentration') }}";
                        if (oldConcentration) {
                            setTimeout(() => {
                                document.getElementById('expertiseConcentrationSelect')
                                    .value =
                                    oldConcentration;
                            }, 100);
                        }
                    }, 100);
                }
            }
        });

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
                        <td>
                            <input type="text" class="form-control form-control-sm table-input sapras-input" data-key="document" placeholder="File Link url">
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm table-input sapras-input" data-key="remarks" placeholder="Keterangan">
                        </td>
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
                                <th style="width:12%">Kesesuaian Standar Industri</th>
                                <th style="width:12%">Dokumen Pendukung</th>
                                <th style="width:18%">Keterangan</th>
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

        function renderEquipmentGimTable(section, sectionNum) {
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
                                <option value="Trial">Trial</option>
                                <option value="License">License</option>
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

        function collectSaprasData() {
            const container = document.getElementById('sapras-container');
            const hiddenInput = document.getElementById('sapras-data-input');

            if (!container || container.style.display === 'none') {
                hiddenInput.value = '{}';
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
    </script>
@endpush
