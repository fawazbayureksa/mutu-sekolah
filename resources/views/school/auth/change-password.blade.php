@extends('school.layouts.school')

@section('title', 'Buat Password - Portal Sekolah')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <div class="text-center mb-4">
                    <i class="bi bi-shield-lock fs-1 text-primary"></i>
                    <h4 class="mt-2 mb-1">Buat Password & Lengkapi Data Sekolah</h4>
                    <p class="text-muted small mb-0">
                        Buat password dan lengkapi data sekolah Anda. Data ini akan menjadi nilai default saat mengisi
                        instrumen.
                    </p>
                </div>

                @if (session('info'))
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        {{ session('info') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('school.password.update') }}" id="changePasswordForm">
                    @csrf

                    {{-- Password Section --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-2">
                            <i class="bi bi-key-fill me-2"></i><strong>Keamanan Akun</strong>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small">NPSN</label>
                                    <input type="text" class="form-control bg-light" value="{{ Auth::user()->npsn }}"
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small">
                                        Password Baru <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="cp-password" name="password" required minlength="8"
                                            placeholder="Minimal 8 karakter">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('cp-password','eye-cp')" tabindex="-1">
                                            <i class="bi bi-eye" id="eye-cp"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex gap-1 mt-2">
                                        <div id="cp-seg1" style="height:4px;flex:1;background:#dee2e6;border-radius:2px;">
                                        </div>
                                        <div id="cp-seg2" style="height:4px;flex:1;background:#dee2e6;border-radius:2px;">
                                        </div>
                                        <div id="cp-seg3" style="height:4px;flex:1;background:#dee2e6;border-radius:2px;">
                                        </div>
                                        <div id="cp-seg4" style="height:4px;flex:1;background:#dee2e6;border-radius:2px;">
                                        </div>
                                    </div>
                                    <small id="cp-str-label" class="text-muted"></small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small">
                                        Konfirmasi Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            id="cp-confirm" name="password_confirmation" required minlength="8"
                                            placeholder="Ulangi password baru">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('cp-confirm','eye-cp-confirm')" tabindex="-1">
                                            <i class="bi bi-eye" id="eye-cp-confirm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- School Data Section --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-2">
                            <i class="bi bi-building me-2"></i><strong>Identitas Sekolah</strong>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">

                                <div class="col-md-8">
                                    <label class="form-label fw-semibold small">
                                        Nama Sekolah <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('school_name') is-invalid @enderror"
                                        name="school_name" required
                                        value="{{ old('school_name', $school->school_name ?? '') }}"
                                        placeholder="Nama lengkap sekolah">
                                    @error('school_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small">NPSN</label>
                                    <input type="text" class="form-control bg-light" value="{{ Auth::user()->npsn }}"
                                        readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">
                                        Provinsi <span class="text-danger">*</span>
                                    </label>
                                    <select name="province_code" id="provinceSelect"
                                        class="form-select @error('province_code') is-invalid @enderror" required
                                        onchange="loadRegencies(this.value)">
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->code }}"
                                                {{ old('province_code', $school->province_code ?? '') == $province->code ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('province_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">
                                        Kabupaten/Kota <span class="text-danger">*</span>
                                    </label>
                                    <select name="regency_code" id="regencySelect"
                                        class="form-select @error('regency_code') is-invalid @enderror" required disabled>
                                        <option value="">-- Pilih Kabupaten/Kota --</option>
                                    </select>
                                    @error('regency_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small">
                                        Alamat <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required
                                        placeholder="Alamat lengkap sekolah">{{ old('address', $school->address ?? '') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Status Sekolah</label>
                                    <div class="mt-2">
                                        @foreach (['Negeri', 'Swasta'] as $status)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="school_status"
                                                    id="status{{ $status }}" value="{{ $status }}"
                                                    {{ old('school_status', $school->school_status ?? '') == $status ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="status{{ $status }}">{{ $status }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('school_status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Durasi Program</label>
                                    <div class="mt-2">
                                        @foreach (['3 Tahun', '4 Tahun'] as $dur)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="program_duration"
                                                    id="dur{{ Str::slug($dur) }}" value="{{ $dur }}"
                                                    {{ old('program_duration', $school->program_duration ?? '') == $dur ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="dur{{ Str::slug($dur) }}">{{ $dur }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('program_duration')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small">Kategori Sekolah</label>
                                    <div class="mt-2">
                                        @foreach (config('constant.school_category') as $value => $label)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="school_category"
                                                    id="cat{{ Str::slug($value) }}" value="{{ $value }}"
                                                    {{ old('school_category', $school->school_category ?? '') == $value ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="cat{{ Str::slug($value) }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('school_category')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Akreditasi Sekolah</label>
                                    <div class="mt-2">
                                        @foreach (config('constant.school_accreditation') as $acc)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="school_accreditation" id="acc{{ Str::slug($acc) }}"
                                                    value="{{ $acc }}"
                                                    {{ old('school_accreditation', $school->school_accreditation ?? '') == $acc ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="acc{{ Str::slug($acc) }}">{{ $acc }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('school_accreditation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Kurikulum</label>
                                    <div class="mt-2">
                                        @foreach (config('constant.curriculum') as $cur)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="curriculum"
                                                    id="cur{{ Str::slug($cur) }}" value="{{ $cur }}"
                                                    {{ old('curriculum', $school->curriculum ?? '') == $cur ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="cur{{ Str::slug($cur) }}">{{ $cur }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('curriculum')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
                        <span id="btnText">Simpan & Lanjutkan ke Dashboard</span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Password show/hide toggle
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Password strength meter
        document.getElementById('cp-password').addEventListener('input', function() {
            const val = this.value;
            const segs = [
                document.getElementById('cp-seg1'),
                document.getElementById('cp-seg2'),
                document.getElementById('cp-seg3'),
                document.getElementById('cp-seg4'),
            ];
            const label = document.getElementById('cp-str-label');
            segs.forEach(s => s.style.background = '#dee2e6');
            if (!val) {
                label.textContent = '';
                label.className = 'text-muted';
                return;
            }
            if (val.length < 8) {
                segs[0].style.background = '#dc3545';
                label.textContent = 'Terlalu pendek';
                label.className = 'small text-danger';
                return;
            }
            let score = 1;
            if (val.length >= 12) score++;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
            if (/[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val)) score++;
            const cfg = [{
                    color: '#dc3545',
                    cls: 'text-danger',
                    text: 'Lemah'
                },
                {
                    color: '#fd7e14',
                    cls: 'text-warning',
                    text: 'Cukup'
                },
                {
                    color: '#ffc107',
                    cls: 'text-warning',
                    text: 'Baik'
                },
                {
                    color: '#198754',
                    cls: 'text-success',
                    text: 'Kuat'
                },
            ];
            const level = cfg[score - 1];
            for (let i = 0; i < score; i++) segs[i].style.background = level.color;
            label.textContent = level.text;
            label.className = 'small ' + level.cls;
        });

        const savedRegencyCode = "{{ old('regency_code', $school->regency_code ?? '') }}";

        function loadRegencies(provinceCode, selectValue) {
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
                    const val = selectValue || savedRegencyCode;
                    regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                    data.forEach(regency => {
                        const opt = document.createElement('option');
                        opt.value = regency.code;
                        opt.textContent = regency.name;
                        if (regency.code === val) opt.selected = true;
                        regencySelect.appendChild(opt);
                    });
                    regencySelect.disabled = false;
                })
                .catch(() => {
                    regencySelect.innerHTML = '<option value="">-- Gagal memuat data --</option>';
                    regencySelect.disabled = true;
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('provinceSelect');
            if (provinceSelect.value) {
                loadRegencies(provinceSelect.value);
            }
        });

        document.getElementById('changePasswordForm').addEventListener('submit', function() {
            document.getElementById('btnSpinner').classList.remove('d-none');
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
@endpush
