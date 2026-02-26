@extends('layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
    <div class="container-fluid">
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Detail Pengajuan</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.submissions-v2.index') }}">Pengajuan</a></li>
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
                @elseif($submission->status === 'verified')
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#validateModal">
                        <i class="bi bi-patch-check me-1"></i> Validasi
                    </button>
                @elseif($submission->status === 'rejected')
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#tokenModal">
                        <i class="bi bi-link-45deg me-1"></i> Generate Link Update
                    </button>
                @endif
                <a href="{{ route('admin.submissions-v2.index') }}" class="btn btn-secondary">
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

        <div class="row">
            {{-- Info Sidebar --}}
            <div class="col-lg-4 mb-4">
                {{-- School Info Card --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-building me-2"></i>Informasi Sekolah
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td class="fw-semibold text-muted" style="width: 40%">Nama Sekolah</td>
                                <td>{{ $submission->school_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">NPSN</td>
                                <td>{{ $submission->npsn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Alamat</td>
                                <td>{{ $submission->address }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Provinsi</td>
                                <td>{{ $submission->school?->province?->name ?? ($submission->province?->name ?? '-') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Kabupaten/Kota</td>
                                <td>{{ $submission->school?->regency?->name ?? ($submission->regency?->name ?? '-') }}</td>
                            </tr>
                            @if ($submission->school?->expertise)
                                <tr>
                                    <td class="fw-semibold text-muted">Bidang Keahlian</td>
                                    <td>{{ $submission->school->expertise }}</td>
                                </tr>
                            @endif
                            @if ($submission->school?->expertise_program)
                                <tr>
                                    <td class="fw-semibold text-muted">Program Keahlian</td>
                                    <td>{{ $submission->school->expertise_program }}</td>
                                </tr>
                            @endif
                            @if ($submission->school?->expertise_concentration)
                                <tr>
                                    <td class="fw-semibold text-muted">Konsentrasi Keahlian</td>
                                    <td>{{ $submission->school->expertise_concentration }}</td>
                                </tr>
                            @endif
                            @if ($submission->school?->school_status)
                                <tr>
                                    <td class="fw-semibold text-muted">Status Sekolah</td>
                                    <td>{{ $submission->school->school_status }}</td>
                                </tr>
                            @endif
                            @if ($submission->school?->school_category)
                                <tr>
                                    <td class="fw-semibold text-muted">Kategori Sekolah</td>
                                    <td>{{ $submission->school->school_category }}</td>
                                </tr>
                            @endif
                            @if ($submission->school?->program_duration)
                                <tr>
                                    <td class="fw-semibold text-muted">Durasi Program</td>
                                    <td>{{ $submission->school->program_duration }}</td>
                                </tr>
                            @endif
                            @if ($submission->school?->school_accreditation)
                                <tr>
                                    <td class="fw-semibold text-muted">Akreditasi Sekolah</td>
                                    <td>{{ $submission->school->school_accreditation }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- Respondent Info Card --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-person-badge me-2"></i>Informasi Responden
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td class="fw-semibold text-muted" style="width: 40%">Nama</td>
                                <td>{{ $submission->respondent_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Jabatan</td>
                                <td>{{ $submission->respondent_position }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">Tanggal Isi</td>
                                <td>{{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Status Card --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-info-circle me-2"></i>Status Pengajuan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <span class="badge {{ $submission->getStatusBadgeClass() }} fs-6 px-3 py-2">
                                {{ $submission->getStatusLabel() }}
                            </span>
                        </div>

                        @if ($submission->completion_percentage)
                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Kelengkapan Data</label>
                                <div class="progress" style="height: 10px;">
                                    @php
                                        $pct = $submission->completion_percentage;
                                        $colorClass = $pct >= 80 ? 'success' : ($pct >= 50 ? 'warning' : 'danger');
                                    @endphp
                                    <div class="progress-bar bg-{{ $colorClass }}" style="width: {{ $pct }}%">
                                    </div>
                                </div>
                                <small class="text-muted">{{ number_format($pct, 0) }}% lengkap</small>
                            </div>
                        @endif

                        @if ($submission->verified_at)
                            <hr>
                            <div class="small">
                                <div class="fw-semibold text-muted mb-1">Diverifikasi oleh:</div>
                                <div>{{ $submission->verifier?->name ?? '-' }}</div>
                                <div class="text-muted">{{ $submission->verified_at->format('d M Y H:i') }}</div>
                                @if ($submission->verification_notes)
                                    <div class="mt-2 p-2 bg-light rounded small">
                                        <strong>Catatan:</strong> {{ $submission->verification_notes }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if ($submission->validated_at)
                            <hr>
                            <div class="small">
                                <div class="fw-semibold text-muted mb-1">Divalidasi oleh:</div>
                                <div>{{ $submission->validator?->name ?? '-' }}</div>
                                <div class="text-muted">{{ $submission->validated_at->format('d M Y H:i') }}</div>
                                @if ($submission->validation_notes)
                                    <div class="mt-2 p-2 bg-light rounded small">
                                        <strong>Catatan:</strong> {{ $submission->validation_notes }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Metadata Card --}}
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-gear me-2"></i>Metadata
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0 small">
                            <tr>
                                <td class="text-muted">ID</td>
                                <td><code>{{ $submission->id }}</code></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Versi Form</td>
                                <td>{{ $submission->form_version }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">IP Address</td>
                                <td><code>{{ $submission->ip_address ?? '-' }}</code></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Created</td>
                                <td>{{ $submission->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-file-text me-2"></i>Review Jawaban
                        </h6>
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

                            {{-- A.1.1 --}}
                            @include('admin.submissions-v2.partials.section-table', [
                                'code' => 'A.1.1',
                                'title' => 'Data Kelulusan Uji Kompetensi dan Sertifikasi',
                                'data' => $answers['A.1.1'] ?? null,
                                'columns' => [
                                    ['key' => 'year', 'label' => 'Tahun'],
                                    ['key' => 'total_participants', 'label' => 'Jumlah Peserta'],
                                    ['key' => 'total_passed', 'label' => 'Jumlah Lulus'],
                                    ['key' => 'pass_rate', 'label' => 'Tingkat Kelulusan (%)'],
                                    ['key' => 'organizer', 'label' => 'Lembaga'],
                                ],
                                'staticRows' => [
                                    'Uji Kompetensi Keahlian (UKK) Mandiri',
                                    'Uji Kompetensi Keahlian (UKK) LSP',
                                    'Sertifikasi Profesi',
                                ],
                            ])

                            {{-- A.1.2 --}}
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

                            {{-- A.2.1 --}}
                            @include('admin.submissions-v2.partials.section-tracer', [
                                'code' => 'A.2.1',
                                'title' => 'Penelusuran Alumni (Tracer Study)',
                                'data' => $answers['A.2.1'] ?? null,
                            ])

                            {{-- A.3 --}}
                            @include('admin.submissions-v2.partials.section-table', [
                                'code' => 'A.3',
                                'title' => 'Data Putus Sekolah dan Ketidaklulusan Kelas',
                                'data' => $answers['A.3'] ?? null,
                                'columns' => [
                                    ['key' => 'year', 'label' => 'Tahun Ajaran'],
                                    ['key' => 'initial_students', 'label' => 'Jumlah Murid Awal'],
                                    ['key' => 'final_students', 'label' => 'Jumlah Murid Akhir'],
                                    ['key' => 'dropouts', 'label' => 'Jumlah Putus Sekolah'],
                                    ['key' => 'failed_students', 'label' => 'Jumlah Tidak Naik Kelas'],
                                    ['key' => 'dropout_percentage', 'label' => '% Putus Sekolah'],
                                    ['key' => 'main_factor', 'label' => 'Faktor Utama Penyebab'],
                                ],
                                'dynamicRows' => true,
                            ])

                            {{-- A.4 --}}
                            @include('admin.submissions-v2.partials.section-a4', [
                                'data' => $answers['A.4'] ?? null,
                            ])
                        </div>

                        {{-- ASPECT B --}}
                        <div class="mb-5">
                            <h5 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-journal-text me-2"></i>B - Data Sarana Prasarana
                            </h5>

                            {{-- B.sapras — dynamic per-concentration table --}}
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

                            {{-- C.1.1 --}}
                            @include('admin.submissions-v2.partials.section-table', [
                                'code' => 'C.1.1',
                                'title' => 'Kerjasama Industri',
                                'data' => $answers['C.1.1'] ?? null,
                                'columns' => [
                                    ['key' => 'partner_name', 'label' => 'Nama Industri Mitra'],
                                    ['key' => 'mou_status', 'label' => 'Status MoU/MoA'],
                                    ['key' => 'duration', 'label' => 'Durasi Kerjasama (Tahun)'],
                                    ['key' => 'contribution_quantitative', 'label' => 'Kontribusi Kuantitatif'],
                                    ['key' => 'contribution_qualitative', 'label' => 'Kontribusi Kualitatif'],
                                ],
                                'dynamicRows' => true,
                            ])

                            {{-- C.2.1 --}}
                            @include('admin.submissions-v2.partials.section-table', [
                                'code' => 'C.2.1',
                                'title' => 'Teaching Factory (TEFA) / Unit Produksi Sekolah',
                                'data' => $answers['C.2.1'] ?? null,
                                'columns' => [
                                    ['key' => 'program_name', 'label' => 'Nama Program TEFA/Produk'],
                                    ['key' => 'industry_partner', 'label' => 'Mitra Industri'],
                                    ['key' => 'operation_scale', 'label' => 'Skala Operasi'],
                                    ['key' => 'store_name', 'label' => 'Skema TeFa'],
                                    ['key' => 'achievement', 'label' => 'Pencapaian & Manfaat'],
                                    ['key' => 'certification', 'label' => 'Sertifikasi Kompetensi'],
                                    ['key' => 'curriculum_integration', 'label' => 'Integrasi Kurikulum'],
                                    ['key' => 'branding_haki', 'label' => 'HaKI/Branding Produk'],
                                    ['key' => 'quality_evaluation', 'label' => 'Evaluasi Mutu Produk'],
                                    ['key' => 'revenue_activity', 'label' => 'Omzet/Sustainability'],
                                    ['key' => 'tracer_impact', 'label' => 'Dampak Tracer Study'],
                                    ['key' => 'industry_contribution', 'label' => 'Keterlibatan Alumni/Industri'],
                                    ['key' => 'constraints', 'label' => 'Kendala'],
                                ],
                                'dynamicRows' => true,
                            ])

                            {{-- C.3.1 --}}
                            @include('admin.submissions-v2.partials.section-table', [
                                'code' => 'C.3.1',
                                'title' => 'Data Pelatihan dan Sertifikasi Guru',
                                'data' => $answers['C.3.1'] ?? null,
                                'columns' => [
                                    ['key' => 'teacher_name', 'label' => 'Nama Guru'],
                                    ['key' => 'subject', 'label' => 'Mata Pelajaran'],
                                    ['key' => 'competency_type', 'label' => 'Jenis Kompetensi'],
                                    ['key' => 'training_title', 'label' => 'Judul Pelatihan'],
                                    ['key' => 'year', 'label' => 'Tahun'],
                                    ['key' => 'provider', 'label' => 'Penyedia'],
                                    ['key' => 'duration', 'label' => 'Durasi'],
                                    ['key' => 'evidence', 'label' => 'Bukti'],
                                    ['key' => 'remarks', 'label' => 'Keterangan'],
                                ],
                                'dynamicRows' => true,
                            ])

                            {{-- C.3.2 --}}
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

                            {{-- C.3.3 --}}
                            @include('admin.submissions-v2.partials.section-table', [
                                'code' => 'C.3.3',
                                'title' => 'Data Ketenagaan dan Beban Mengajar (Rasio Guru-Murid)',
                                'data' => $answers['C.3.3'] ?? null,
                                'columns' => [
                                    ['key' => 'concentration', 'label' => 'Kompetensi Keahlian'],
                                    ['key' => 'teacher_count', 'label' => 'Jumlah Guru Produktif'],
                                    ['key' => 'student_count', 'label' => 'Jumlah Total Murid'],
                                    ['key' => 'ratio', 'label' => 'Rasio Guru:Siswa'],
                                    ['key' => 'remarks', 'label' => 'Keterangan'],
                                ],
                                'dynamicRows' => true,
                            ])
                        </div>
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
                    <form action="{{ route('admin.submissions-v2.verify', $submission) }}" method="POST">
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
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>
                                Verifikasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.submissions-v2.reject', $submission) }}" method="POST">
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

    {{-- Validate Modal --}}
    @if ($submission->status === 'verified')
        <div class="modal fade" id="validateModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.submissions-v2.validate', $submission) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Validasi Pengajuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Anda akan memvalidasi pengajuan dari <strong>{{ $submission->school_name }}</strong>.</p>
                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-patch-check me-1"></i>
                                Validasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Token Modal --}}
    @if ($submission->status === 'rejected')
        <div class="modal fade" id="tokenModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.submissions-v2.generate-token', $submission) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Generate Link Update</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Anda akan membuat link update untuk pengajuan dari
                                <strong>{{ $submission->school_name }}</strong>.
                            </p>
                            <div class="alert alert-info small">
                                <i class="bi bi-info-circle me-1"></i>
                                Link akan berlaku selama 24 jam dan hanya dapat digunakan sekali.
                            </div>
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
    @endif
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
