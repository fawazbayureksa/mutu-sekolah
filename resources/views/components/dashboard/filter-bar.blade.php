@props([
    'action',
    'provinces' => [],
    'regencies' => [],
    'expertises' => [],
    'statuses' => [],
    'filters' => [],
    'showSearch' => false,
    'searchPlaceholder' => 'Cari nama sekolah atau NPSN...',
    'years' => [],
])

<div class="card shadow-sm border-0 mb-4 bg-white rounded-4">
    <div class="card-body p-3">
        <form action="{{ $action }}" method="GET" id="globalFilterForm">
            <div class="row g-2 align-items-center">
                {{-- Tahun Ajaran --}}
                {{-- <div class="col-12 col-sm-6 col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                class="bi bi-calendar-event"></i></span>
                        <select name="year" class="form-select form-select-sm border-start-0 ps-1"
                            onchange="this.form.submit()">
                            <option value="">Tahun Ajaran</option>
                            @foreach ($years as $yr)
                                <option value="{{ $yr }}"
                                    {{ ($filters['year'] ?? request('year')) == $yr ? 'selected' : '' }}>
                                    {{ $yr }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                {{-- Provinsi --}}
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                class="bi bi-geo-alt"></i></span>
                        <select name="province_code" id="filter_province_code"
                            class="form-select form-select-sm border-start-0 ps-1"
                            onchange="loadRegencies(this.value); this.form.submit();">
                            <option value="">Semua Provinsi</option>
                            @foreach ($provinces as $prov)
                                <option value="{{ $prov->code }}"
                                    {{ ($filters['province_code'] ?? request('province_code')) == $prov->code ? 'selected' : '' }}>
                                    {{ $prov->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Kab/Kota --}}
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                class="bi bi-building"></i></span>
                        <select name="regency_code" id="filter_regency_code"
                            class="form-select form-select-sm border-start-0 ps-1" onchange="this.form.submit()">
                            <option value="">Semua Kab/Kota</option>
                            @foreach ($regencies as $reg)
                                <option value="{{ $reg->code }}"
                                    {{ ($filters['regency_code'] ?? request('regency_code')) == $reg->code ? 'selected' : '' }}>
                                    {{ $reg->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Bidang Keahlian --}}
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                class="bi bi-pencil-square"></i></span>
                        <select name="expertise" class="form-select form-select-sm border-start-0 ps-1"
                            onchange="this.form.submit()">
                            <option value="">Semua Bidang</option>
                            @foreach ($expertises as $exp)
                                <option value="{{ $exp }}"
                                    {{ ($filters['expertise'] ?? request('expertise')) == $exp ? 'selected' : '' }}>
                                    {{ $exp }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Status Sekolah --}}
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                class="bi bi-card-checklist"></i></span>
                        <select name="school_status" class="form-select form-select-sm border-start-0 ps-1"
                            onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="Negeri"
                                {{ ($filters['school_status'] ?? request('school_status')) === 'Negeri' ? 'selected' : '' }}>
                                Negeri</option>
                            <option value="Swasta"
                                {{ ($filters['school_status'] ?? request('school_status')) === 'Swasta' ? 'selected' : '' }}>
                                Swasta</option>
                        </select>
                    </div>
                </div>

                {{-- Tombol Reset --}}
                <div class="col-12 col-sm-6 col-md-2 d-flex justify-content-end">
                    <a href="{{ $action }}"
                        class="btn btn-outline-secondary btn-sm w-100 d-flex align-items-center justify-content-center gap-1">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        <span>Reset Filter</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function loadRegencies(provinceCode) {
        const regencySelect = document.getElementById('filter_regency_code');
        if (!regencySelect) return;

        regencySelect.innerHTML = '<option value="">Memuat...</option>';

        if (!provinceCode) {
            regencySelect.innerHTML = '<option value="">Semua Kab/Kota</option>';
            return;
        }

        fetch(`{{ url('/api/regencies') }}/${provinceCode}`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Semua Kab/Kota</option>';
                data.forEach(reg => {
                    options += `<option value="${reg.code}">${reg.name}</option>`;
                });
                regencySelect.innerHTML = options;
            })
            .catch(err => {
                console.error('Error loading regencies:', err);
                regencySelect.innerHTML = '<option value="">Semua Kab/Kota</option>';
            });
    }
</script>
