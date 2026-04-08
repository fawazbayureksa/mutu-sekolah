@extends('verifier.layouts.verifier')

@section('title', 'Detail Pengajuan')

@section('content')
    <div class="container-fluid">
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Detail Pengajuan</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('verifier.submissions-v2.index') }}">Pengajuan</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                @if ($submission->status === 'submitted')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal">
                        <i class="bi bi-check-lg me-1"></i> Verifikasi
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-lg me-1"></i> Tolak
                    </button>
                @endif
                {{-- <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#tokenModal">
                    <i class="bi bi-link-45deg me-1"></i> Generate Link Update
                </button> --}}
                <a href="{{ route('verifier.submissions-v2.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                @if (session('update_url'))
                    <hr>
                    <p class="mb-1"><strong>Link Update:</strong></p>
                    <code class="d-block p-2 bg-light rounded">{{ session('update_url') }}</code>
                    <button type="button" class="btn btn-sm btn-outline-success mt-2"
                        onclick="copyToClipboard('{{ session('update_url') }}')">
                        <i class="bi bi-clipboard me-1"></i> Salin Link
                    </button>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ① Summary Sweep Card --}}
        @php
            $pct = $submission->completion_percentage ?? 0;
            $pctColor = $pct >= 80 ? 'success' : ($pct >= 50 ? 'warning' : 'danger');
            $concentrations = $submission->school?->expertise_concentration ?? [];
        @endphp
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body py-4 px-4">
                <div class="row g-3 align-items-center">
                    {{-- School identity --}}
                    <div class="col-lg-5">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width:56px;height:56px;background:rgba(255,255,255,0.15);">
                                <i class="bi bi-building" style="font-size:1.5rem;"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">{{ $submission->school_name }}</h5>
                                <div class="small mt-1">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $submission->address ?? '-' }}
                                </div>
                                @if (!empty($concentrations))
                                    <div class="mt-2 d-flex flex-wrap gap-1">
                                        @foreach ((array) $concentrations as $c)
                                            <span class="badge"
                                                style="background:rgba(255,255,255,0.2);color:#030303;font-size:.7rem;">{{ $c }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Respondent --}}
                    <div class="col-lg-3">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-person-badge" style="font-size:1.5rem;"></i>
                            <div>
                                <div class="fw-bold">{{ $submission->respondent_name }}</div>
                                <div class="small">{{ $submission->respondent_position }}</div>
                                <div class="small">
                                    {{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="col-lg-4 text-lg-end">
                        <span class="badge {{ $submission->getStatusBadgeClass() }} fs-6 px-3 py-2 mb-2 d-inline-block">
                            {{ $submission->getStatusLabel() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ② Review Jawaban --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-2">
                <span class="rounded-circle d-inline-flex align-items-center justify-content-center"
                    style="width:32px;height:32px;background:#e8ecff;">
                    <i class="bi bi-file-text text-primary" style="font-size:.9rem;"></i>
                </span>
                <span class="fw-semibold">Review Jawaban</span>
            </div>
            <div class="card-body">
                @php
                    $answers = $submission->answers ?? [];
                @endphp

                {{-- ASPECT A --}}
                <div class="mb-5">
                    <h5 class="text-primary border-bottom pb-2 mb-3">
                        <i class="bi bi-journal-text me-2"></i>A - Peserta Didik
                    </h5>
                    @include('admin.submissions-v2.partials.section-table', [
                        'code' => 'A.1.1',
                        'title' => 'Data Kelulusan Uji Kompetensi dan Sertifikasi',
                        'data' => $answers['A.1.1'] ?? null,
                        'columns' => [
                            ['key' => 'year', 'label' => 'Tahun Ajaran'],
                            ['key' => 'label', 'label' => 'Jenis Ujian/Sertifikasi'],
                            ['key' => 'total_participants', 'label' => 'Jumlah Peserta'],
                            ['key' => 'total_passed', 'label' => 'Jumlah Lulus'],
                            ['key' => 'pass_rate', 'label' => 'Tingkat Kelulusan (%)'],
                            ['key' => 'organizer', 'label' => 'Lembaga Penyelenggara'],
                            ['key' => 'description', 'label' => 'Keterangan'],
                        ],
                        'dynamicRows' => true,
                    ])
                    @include('admin.submissions-v2.partials.section-table', [
                        'code' => 'A.1.2',
                        'title' => 'Analisis Skema Sertifikasi dan Kesesuaian KKNI',
                        'data' => $answers['A.1.2'] ?? null,
                        'columns' => [
                            ['key' => 'label', 'label' => 'Skema Sertifikasi'],
                            ['key' => 'scheme_type', 'label' => 'Jenis Kemasan'],
                            ['key' => 'kkni_level', 'label' => 'Jenjang KKNI'],
                            ['key' => 'competency_units', 'label' => 'Jumlah Unit Kompetensi'],
                            ['key' => 'compliance', 'label' => 'Kesesuaian'],
                            ['key' => 'remarks', 'label' => 'Keterangan'],
                        ],
                        'dynamicRows' => true,
                    ])
                    @include('admin.submissions-v2.partials.section-tracer', [
                        'code' => 'A.2.1',
                        'title' => 'Penelusuran Alumni (Tracer Study)',
                        'data' => $answers['A.2.1'] ?? null,
                    ])
                    @include('admin.submissions-v2.partials.section-table', [
                        'code' => 'A.3',
                        'title' => 'Data Putus Sekolah dan Ketidaknaikan Kelas',
                        'data' => $answers['A.3'] ?? null,
                        'columns' => [
                            ['key' => 'year', 'label' => 'Tahun Ajaran'],
                            ['key' => 'initial_students', 'label' => 'Jumlah Murid Awal'],
                            ['key' => 'final_students', 'label' => 'Jumlah Murid Akhir'],
                            ['key' => 'dropouts', 'label' => 'Jumlah Putus Sekolah'],
                            ['key' => 'failed_students', 'label' => 'Jumlah Tidak Naik Kelas'],
                            ['key' => 'dropout_percentage', 'label' => '% Putus Sekolah'],
                            ['key' => 'main_factor', 'label' => 'Faktor Utama Penyebab'],
                            ['key' => 'main_factor_other', 'label' => 'Faktor Lainnya (Keterangan)'],
                        ],
                        'dynamicRows' => true,
                    ])
                    @include('admin.submissions-v2.partials.section-a4', [
                        'data' => $answers['A.4'] ?? null,
                    ])
                </div>

                {{-- ASPECT B --}}
                <div class="mb-5">
                    <h5 class="text-primary border-bottom pb-2 mb-3">
                        <i class="bi bi-journal-text me-2"></i>B - Data Sarana Prasarana
                    </h5>
                    @include('admin.submissions-v2.partials.section-sapras', [
                        'code' => 'B.sapras',
                        'title' => 'Inventarisasi Sarana Prasarana per Konsentrasi Keahlian',
                        'data' => $answers['B.sapras'] ?? null,
                    ])
                </div>

                {{-- ASPECT C --}}
                <div class="mb-5">
                    <h5 class="text-primary border-bottom pb-2 mb-3">
                        <i class="bi bi-journal-text me-2"></i>C - Data Tata Kelola
                    </h5>
                    @include('admin.submissions-v2.partials.section-table', [
                        'code' => 'C.1.1',
                        'title' => 'Kerjasama Industri',
                        'data' => $answers['C.1.1'] ?? null,
                        'columns' => [
                            ['key' => 'partner_name', 'label' => 'Nama Industri Mitra'],
                            ['key' => 'mou_status', 'label' => 'Status MoU/MoA'],
                            ['key' => 'duration', 'label' => 'Durasi (Tahun)'],
                            [
                                'key' => 'program_kurikulum',
                                'label' => '1. Penyelarasan Kurikulum',
                                'type' => 'boolean',
                            ],
                            ['key' => 'program_guru', 'label' => '2. Guru Tamu', 'type' => 'boolean'],
                            ['key' => 'program_magang', 'label' => '3. Magang/PKL Siswa', 'type' => 'boolean'],
                            [
                                'key' => 'program_sertifikasi',
                                'label' => '4. Sertifikasi (BNSP/LSP)',
                                'type' => 'boolean',
                            ],
                            ['key' => 'program_pelatihan', 'label' => '5. Pelatihan Guru', 'type' => 'boolean'],
                            [
                                'key' => 'program_rekrutmen',
                                'label' => '6. Penyerapan Lulusan',
                                'type' => 'boolean',
                            ],
                            ['key' => 'program_tefa', 'label' => '7. Teaching Factory', 'type' => 'boolean'],
                            ['key' => 'program_kelas', 'label' => '8. Kelas Industri', 'type' => 'boolean'],
                            ['key' => 'program_csr', 'label' => '9. CSR/Alat/Bahan/Beasiswa', 'type' => 'boolean'],
                            ['key' => 'program_lainnya_text', 'label' => '10. Lainnya'],
                            ['key' => 'contribution_quantitative', 'label' => 'Kontribusi Kuantitatif'],
                            ['key' => 'contribution_qualitative', 'label' => 'Kontribusi Kualitatif'],
                        ],
                        'dynamicRows' => true,
                    ])
                    @include('admin.submissions-v2.partials.section-table', [
                        'code' => 'C.2.1',
                        'title' => 'Teaching Factory (TEFA) / Unit Produksi Sekolah',
                        'data' => $answers['C.2.1'] ?? null,
                        'columns' => [
                            ['key' => 'kategori_tefa', 'label' => 'Kategori TEFA'],
                            ['key' => 'product_name', 'label' => 'Nama Produk (Barang/Jasa)'],
                            ['key' => 'product_description', 'label' => 'Deskripsi Produk'],
                            ['key' => 'industry_partner', 'label' => 'Mitra Industri'],
                            [
                                'key' => 'tefa_identifikasi',
                                'label' => '1. Identifikasi Produk',
                                'type' => 'boolean',
                            ],
                            [
                                'key' => 'tefa_analisis_komp',
                                'label' => '2. Analisis Kompetensi',
                                'type' => 'boolean',
                            ],
                            [
                                'key' => 'tefa_perencanaan',
                                'label' => '3. Perencanaan Produksi',
                                'type' => 'boolean',
                            ],
                            [
                                'key' => 'tefa_analisis_sda',
                                'label' => '4. Analisis Sumber Daya',
                                'type' => 'boolean',
                            ],
                            ['key' => 'tefa_pengerjaan', 'label' => '5. Pengerjaan Produk', 'type' => 'boolean'],
                            ['key' => 'tefa_penyerahan', 'label' => '6. Penyerahan Produk', 'type' => 'boolean'],
                            ['key' => 'tefa_purna_jual', 'label' => '7. Layanan Purna Jual', 'type' => 'boolean'],
                            ['key' => 'certification', 'label' => 'Sertifikasi Kompetensi'],
                            ['key' => 'curriculum_sync', 'label' => 'Sinkronisasi Kurikulum'],
                            ['key' => 'branding_haki', 'label' => 'Branding/HAKI'],
                            ['key' => 'quality_evaluation', 'label' => 'Evaluasi Mutu Produk'],
                            ['key' => 'revenue_activity', 'label' => 'Omzet (Rp/Bulan/Tahun)'],
                            ['key' => 'industry_contribution', 'label' => 'Keterlibatan Alumni/Industri'],
                            ['key' => 'constraints', 'label' => 'Kendala'],
                        ],
                        'dynamicRows' => true,
                    ])
                    @include('admin.submissions-v2.partials.section-table', [
                        'code' => 'C.3.1',
                        'title' => 'Data Pelatihan dan Sertifikasi Guru',
                        'data' => $answers['C.3.1'] ?? null,
                        'columns' => [
                            ['key' => 'teacher_name', 'label' => 'Nama Guru'],
                            ['key' => 'subject', 'label' => 'Mata Pelajaran'],
                            ['key' => 'competency_type', 'label' => 'Jenis Pelatihan/Sertifikasi'],
                            ['key' => 'training_title', 'label' => 'Judul Pelatihan'],
                            ['key' => 'year', 'label' => 'Tahun'],
                            ['key' => 'provider', 'label' => 'Penyedia'],
                            ['key' => 'duration', 'label' => 'Durasi'],
                            ['key' => 'evidence', 'label' => 'Bukti'],
                            ['key' => 'remarks', 'label' => 'Keterangan'],
                        ],
                        'dynamicRows' => true,
                    ])
                    @include('admin.submissions-v2.partials.section-table', [
                        'code' => 'C.3.2',
                        'title' => 'Analisis Kebutuhan Pelatihan Guru ke Depan',
                        'data' => $answers['C.3.2'] ?? null,
                        'columns' => [
                            ['key' => 'current_condition', 'label' => 'Kondisi Saat Ini'],
                            ['key' => 'gap', 'label' => 'Kesenjangan'],
                        ],
                        'staticRows' => [
                            'Persentase guru produktif bersertifikat kompetensi (BNSP/Industri)',
                            'Rata-rata jam pelatihan per guru per tahun',
                            'Keterlibatan dalam magang industri',
                            'Frekuensi update teknologi/kompetensi',
                            'Ketersediaan guru dengan sertifikat asesor BNSP',
                        ],
                    ])
                    @include('admin.submissions-v2.partials.section-table', [
                        'code' => 'C.3.3',
                        'title' => 'Data Ketenagaan dan Beban Mengajar (Rasio Guru-Murid)',
                        'data' => $answers['C.3.3'] ?? null,
                        'columns' => [
                            ['key' => 'concentration', 'label' => 'Konsentrasi Keahlian'],
                            ['key' => 'total_teacher_count', 'label' => 'Jumlah Guru (PNA)'],
                            ['key' => 'student_count', 'label' => 'Jumlah Total Murid'],
                            ['key' => 'ideal_ratio', 'label' => 'Rasio Ideal (Guru PNA : Murid)'],
                            ['key' => 'ratio_gm', 'label' => 'Rasio Guru:Murid (G:M)'],
                            ['key' => 'concentration_count', 'label' => 'Jml Konsentrasi per Bidang'],
                            ['key' => 'productive_teacher_count', 'label' => 'Jml Guru Produktif'],
                            [
                                'key' => 'ideal_productive_ratio',
                                'label' => 'Rasio Ideal (Guru Produktif : Konsentrasi)',
                            ],
                            [
                                'key' => 'ratio_productive_concentration',
                                'label' => 'Rasio Guru Produktif : Konsentrasi',
                            ],
                            ['key' => 'remarks', 'label' => 'Keterangan'],
                        ],
                        'dynamicRows' => true,
                    ])
                </div>
            </div>
        </div>

        {{-- ③ Detail accordion --}}
        <div class="accordion accordion-flush shadow-sm border-0 rounded mb-4" id="detailAccordion">

            {{-- School Info --}}
            <div class="accordion-item border-0 mb-2 rounded shadow-sm overflow-hidden">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-semibold bg-white" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSchool">
                        <i class="bi bi-building me-2 text-primary"></i>Informasi Sekolah
                    </button>
                </h2>
                <div id="collapseSchool" class="accordion-collapse collapse" data-bs-parent="#detailAccordion">
                    <div class="accordion-body pt-0">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <dl class="row mb-0" style="row-gap:.5rem;">
                                    <dt class="col-5 text-muted fw-normal small">Nama Sekolah</dt>
                                    <dd class="col-7 mb-0 fw-semibold">{{ $submission->school_name }}</dd>

                                    <dt class="col-5 text-muted fw-normal small">NPSN</dt>
                                    <dd class="col-7 mb-0">{{ $submission->npsn ?? '-' }}</dd>

                                    <dt class="col-5 text-muted fw-normal small">Alamat</dt>
                                    <dd class="col-7 mb-0">{{ $submission->address ?? '-' }}</dd>

                                    <dt class="col-5 text-muted fw-normal small">Kabupaten/Kota</dt>
                                    <dd class="col-7 mb-0">
                                        {{ $submission->school?->regency?->name ?? ($submission->regency?->name ?? '-') }}
                                    </dd>

                                    <dt class="col-5 text-muted fw-normal small">Provinsi</dt>
                                    <dd class="col-7 mb-0">
                                        {{ $submission->school?->province?->name ?? ($submission->province?->name ?? '-') }}
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row mb-0" style="row-gap:.5rem;">
                                    @if ($submission->school?->curriculum)
                                        <dt class="col-5 text-muted fw-normal small">Kurikulum</dt>
                                        <dd class="col-7 mb-0">
                                            <span
                                                class="badge {{ $submission->school->curriculum === 'K13' ? 'bg-warning text-dark' : 'bg-success' }}">
                                                {{ $submission->school->curriculum }}
                                            </span>
                                        </dd>
                                    @endif
                                    @if ($submission->school?->school_status)
                                        <dt class="col-5 text-muted fw-normal small">Status Sekolah</dt>
                                        <dd class="col-7 mb-0">{{ $submission->school->school_status }}</dd>
                                    @endif
                                    @if ($submission->school?->school_category)
                                        <dt class="col-5 text-muted fw-normal small">Kategori</dt>
                                        <dd class="col-7 mb-0">{{ $submission->school->school_category }}</dd>
                                    @endif
                                    @if ($submission->school?->program_duration)
                                        <dt class="col-5 text-muted fw-normal small">Durasi Program</dt>
                                        <dd class="col-7 mb-0">{{ $submission->school->program_duration }}</dd>
                                    @endif
                                    @if ($submission->school?->school_accreditation)
                                        <dt class="col-5 text-muted fw-normal small">Akreditasi</dt>
                                        <dd class="col-7 mb-0">{{ $submission->school->school_accreditation }}</dd>
                                    @endif
                                    @if ($submission->school?->expertise)
                                        <dt class="col-5 text-muted fw-normal small">Bidang Keahlian</dt>
                                        <dd class="col-7 mb-0">
                                            @foreach ((array) $submission->school->expertise as $e)
                                                <span
                                                    class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle me-1">{{ $e }}</span>
                                            @endforeach
                                        </dd>
                                    @endif
                                    @if ($submission->school?->expertise_program)
                                        <dt class="col-5 text-muted fw-normal small">Program Keahlian</dt>
                                        <dd class="col-7 mb-0">
                                            @foreach ((array) $submission->school->expertise_program as $e)
                                                <span
                                                    class="badge bg-info bg-opacity-10 text-info border border-info-subtle me-1">{{ $e }}</span>
                                            @endforeach
                                        </dd>
                                    @endif
                                    @if ($submission->school?->expertise_concentration)
                                        <dt class="col-5 text-muted fw-normal small">Konsentrasi</dt>
                                        <dd class="col-7 mb-0">
                                            @foreach ((array) $submission->school->expertise_concentration as $e)
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success border border-success-subtle me-1">{{ $e }}</span>
                                            @endforeach
                                        </dd>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Respondent --}}
            <div class="accordion-item border-0 mb-2 rounded shadow-sm overflow-hidden">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-semibold bg-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseRespondent">
                        <i class="bi bi-person-badge me-2 text-success"></i>Informasi Responden
                    </button>
                </h2>
                <div id="collapseRespondent" class="accordion-collapse collapse" data-bs-parent="#detailAccordion">
                    <div class="accordion-body pt-0">
                        <dl class="row mb-0" style="row-gap:.5rem;">
                            <dt class="col-3 text-muted fw-normal small">Nama</dt>
                            <dd class="col-9 mb-0 fw-semibold">{{ $submission->respondent_name }}</dd>

                            <dt class="col-3 text-muted fw-normal small">Jabatan</dt>
                            <dd class="col-9 mb-0">{{ $submission->respondent_position }}</dd>

                            <dt class="col-3 text-muted fw-normal small">Tanggal Isi</dt>
                            <dd class="col-9 mb-0">
                                {{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Status Pengajuan --}}
            <div class="accordion-item border-0 mb-2 rounded shadow-sm overflow-hidden">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-semibold bg-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseStatus">
                        <i class="bi bi-info-circle me-2 text-warning"></i>Status Pengajuan
                    </button>
                </h2>
                <div id="collapseStatus" class="accordion-collapse collapse" data-bs-parent="#detailAccordion">
                    <div class="accordion-body">
                        {{-- Status + Progress row --}}
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto">
                                <span class="badge {{ $submission->getStatusBadgeClass() }} fs-6 px-3 py-2">
                                    {{ $submission->getStatusLabel() }}
                                </span>
                            </div>
                            @if ($submission->completion_percentage)
                                <div class="col">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height:8px;">
                                            <div class="progress-bar bg-{{ $pctColor }}"
                                                style="width:{{ $pct }}%"></div>
                                        </div>
                                        <small
                                            class="text-muted text-nowrap fw-semibold">{{ number_format($pct, 0) }}%</small>
                                    </div>
                                    <div class="text-muted" style="font-size:.7rem;">Kelengkapan Data</div>
                                </div>
                            @endif
                        </div>

                        {{-- Verification timeline --}}
                        @if ($submission->verified_at)
                            <div class="border-top pt-3">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 text-center" style="width:32px;">
                                        <span
                                            class="rounded-circle d-inline-flex align-items-center justify-content-center bg-info"
                                            style="width:28px;height:28px;">
                                            <i class="bi bi-check text-white" style="font-size:.8rem;"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small">Diverifikasi oleh:
                                            {{ $submission->verifier?->name ?? '-' }}</div>
                                        <div class="text-muted small">{{ $submission->verified_at->format('d M Y, H:i') }}
                                        </div>
                                        @if ($submission->verification_notes)
                                            <div class="mt-1 p-2 bg-light rounded small text-muted">
                                                <i
                                                    class="bi bi-chat-left-text me-1"></i>{{ $submission->verification_notes }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Metadata --}}
            <div class="accordion-item border-0 rounded shadow-sm overflow-hidden">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-semibold bg-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseMetadata">
                        <i class="bi bi-gear me-2 text-secondary"></i>Metadata
                    </button>
                </h2>
                <div id="collapseMetadata" class="accordion-collapse collapse" data-bs-parent="#detailAccordion">
                    <div class="accordion-body pt-0">
                        <dl class="row mb-0" style="row-gap:.5rem;">
                            <dt class="col-3 text-muted fw-normal small">ID</dt>
                            <dd class="col-9 mb-0"><code>{{ $submission->id }}</code></dd>

                            <dt class="col-3 text-muted fw-normal small">Versi Form</dt>
                            <dd class="col-9 mb-0">{{ $submission->form_version }}</dd>

                            <dt class="col-3 text-muted fw-normal small">IP Address</dt>
                            <dd class="col-9 mb-0"><code>{{ $submission->ip_address ?? '-' }}</code></dd>

                            <dt class="col-3 text-muted fw-normal small">Created</dt>
                            <dd class="col-9 mb-0">{{ $submission->created_at->format('d M Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Verify Modal --}}
    @if ($submission->status === 'submitted')
        <div class="modal fade" id="verifyModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('verifier.submissions-v2.verify', $submission) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Verifikasi Pengajuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Anda akan memverifikasi pengajuan dari <strong>{{ $submission->school_name }}</strong>.</p>
                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success"><i
                                    class="bi bi-check-lg me-1"></i>Verifikasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('verifier.submissions-v2.reject', $submission) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Pengajuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Anda akan menolak pengajuan dari <strong>{{ $submission->school_name }}</strong>.</p>
                            <div class="mb-3">
                                <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                <textarea name="notes" class="form-control" rows="3" required placeholder="Jelaskan alasan penolakan..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger"><i class="bi bi-x-lg me-1"></i> Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Token Modal (always available for all statuses) --}}
    <div class="modal fade" id="tokenModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('verifier.submissions-v2.generate-token', $submission) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Generate Link Update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda akan membuat link update untuk pengajuan dari
                            <strong>{{ $submission->school_name }}</strong>.
                        </p>
                        {{-- <div class="alert alert-info small">
                            <i class="bi bi-info-circle me-1"></i>
                            Link akan berlaku selama <strong>5 hari</strong> dan hanya dapat digunakan sekali.
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning"><i class="bi bi-link-45deg me-1"></i> Generate
                            Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Link berhasil disalin!');
            }, function(err) {
                console.error('Gagal menyalin: ', err);
            });
        }
    </script>
@endpush
