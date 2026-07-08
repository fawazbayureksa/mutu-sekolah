@extends('layouts.app')

@section('title', 'Detail Pengajuan - ' . $school->school_name)

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0">Detail Pengajuan</h1>
            <p class="text-muted mb-0">{{ $school->school_name }}</p>
        </div>
        <a href="{{ route('schools.shared.show', $school->share_token) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Sekolah
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-4 px-4">
            <div class="row g-3 align-items-center">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width:56px;height:56px;">
                            <i class="bi bi-building text-primary" style="font-size:1.5rem;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">{{ $submission->school_name }}</h5>
                            <div class="small text-muted mt-1">
                                <i class="bi bi-geo-alt me-1"></i>{{ $submission->address ?? '-' }}
                            </div>
                            @if ($submission->expertise_concentration)
                                <div class="mt-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle">
                                        {{ $submission->expertise_concentration }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-person-badge text-secondary" style="font-size:1.5rem;"></i>
                        <div>
                            <div class="fw-bold">{{ $submission->respondent_name }}</div>
                            <div class="text-muted small">{{ $submission->respondent_position }}</div>
                            <div class="text-muted small">
                                {{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <span class="badge {{ $submission->getStatusBadgeClass() }} fs-6 px-3 py-2 d-inline-block">
                        {{ $submission->getStatusLabel() }}
                    </span>
                    @if ($submission->verified_at)
                        <div class="small text-muted mt-1">Diverifikasi: {{ $submission->verified_at->format('d M Y') }}</div>
                    @endif
                    @if ($submission->validated_at)
                        <div class="small text-muted">Divalidasi: {{ $submission->validated_at->format('d M Y') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-2">
            <span class="rounded-circle d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10"
                style="width:32px;height:32px;">
                <i class="bi bi-file-text text-primary" style="font-size:.9rem;"></i>
            </span>
            <span class="fw-semibold">Review Jawaban</span>
        </div>
        <div class="card-body">
            @if (!$answers)
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #dee2e6;"></i>
                    <p class="mt-3 mb-0">Belum ada data jawaban.</p>
                </div>
            @else
                @php
                    $partialPrefix = 'admin.submissions-v2.partials';
                @endphp

                @if (isset($answers['A.1.1']) || isset($answers['A.1.2']) || isset($answers['A.2.1']) || isset($answers['A.3']) || isset($answers['A.4']))
                    <div class="mb-5">
                        <h5 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-journal-text me-2"></i>A - Peserta Didik
                        </h5>
                        @include("$partialPrefix.section-table", ['code' => 'A.1.1', 'title' => 'Data Kelulusan Uji Kompetensi dan Sertifikasi', 'data' => $answers['A.1.1'] ?? null, 'columns' => [['key' => 'year', 'label' => 'Tahun Ajaran'], ['key' => 'label', 'label' => 'Jenis Ujian/Sertifikasi'], ['key' => 'total_participants', 'label' => 'Jumlah Peserta'], ['key' => 'total_passed', 'label' => 'Jumlah Lulus'], ['key' => 'pass_rate', 'label' => 'Tingkat Kelulusan (%)'], ['key' => 'organizer', 'label' => 'Lembaga Penyelenggara'], ['key' => 'description', 'label' => 'Keterangan']], 'dynamicRows' => true])
                        @include("$partialPrefix.section-table", ['code' => 'A.1.2', 'title' => 'Analisis Skema Sertifikasi dan Kesesuaian KKNI', 'data' => $answers['A.1.2'] ?? null, 'columns' => [['key' => 'label', 'label' => 'Skema Sertifikasi'], ['key' => 'scheme_type', 'label' => 'Jenis Kemasan'], ['key' => 'kkni_level', 'label' => 'Jenjang KKNI'], ['key' => 'competency_units', 'label' => 'Jumlah Unit Kompetensi'], ['key' => 'compliance', 'label' => 'Kesesuaian'], ['key' => 'remarks', 'label' => 'Keterangan']], 'dynamicRows' => true])
                        @include("$partialPrefix.section-tracer", ['code' => 'A.2.1', 'title' => 'Penelusuran Alumni (Tracer Study)', 'data' => $answers['A.2.1'] ?? null])
                        @include("$partialPrefix.section-table", ['code' => 'A.3', 'title' => 'Data Putus Sekolah dan Ketidaknaikan Kelas', 'data' => $answers['A.3'] ?? null, 'columns' => [['key' => 'year', 'label' => 'Tahun Ajaran'], ['key' => 'initial_students', 'label' => 'Jumlah Murid Awal'], ['key' => 'final_students', 'label' => 'Jumlah Murid Akhir'], ['key' => 'dropouts', 'label' => 'Jumlah Putus Sekolah'], ['key' => 'failed_students', 'label' => 'Jumlah Tidak Naik Kelas'], ['key' => 'dropout_percentage', 'label' => '% Putus Sekolah'], ['key' => 'main_factor', 'label' => 'Faktor Utama Penyebab'], ['key' => 'main_factor_other', 'label' => 'Faktor Lainnya (Keterangan)']], 'dynamicRows' => true])
                        @include("$partialPrefix.section-a4", ['data' => $answers['A.4'] ?? null])
                    </div>
                @endif

                @if (isset($answers['B.sapras']))
                    <div class="mb-5">
                        <h5 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-journal-text me-2"></i>B - Data Sarana Prasarana
                        </h5>
                        @include("$partialPrefix.section-sapras", ['code' => 'B.sapras', 'title' => 'Inventarisasi Sarana Prasarana per Konsentrasi Keahlian', 'data' => $answers['B.sapras'] ?? null])
                    </div>
                @endif

                @if (isset($answers['C.1.1']) || isset($answers['C.2.1']) || isset($answers['C.3.1']) || isset($answers['C.3.2']) || isset($answers['C.3.3']))
                    <div class="mb-5">
                        <h5 class="text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-journal-text me-2"></i>C - Data Tata Kelola
                        </h5>
                        @include("$partialPrefix.section-table", ['code' => 'C.1.1', 'title' => 'Kerjasama Industri', 'data' => $answers['C.1.1'] ?? null, 'columns' => [['key' => 'partner_name', 'label' => 'Nama Industri Mitra'], ['key' => 'mou_status', 'label' => 'Status MoU/MoA'], ['key' => 'duration', 'label' => 'Durasi (Tahun)'], ['key' => 'program_kurikulum', 'label' => '1. Penyelarasan Kurikulum', 'type' => 'boolean'], ['key' => 'program_guru', 'label' => '2. Guru Tamu', 'type' => 'boolean'], ['key' => 'program_magang', 'label' => '3. Magang/PKL Siswa', 'type' => 'boolean'], ['key' => 'program_sertifikasi', 'label' => '4. Sertifikasi (BNSP/LSP)', 'type' => 'boolean'], ['key' => 'program_pelatihan', 'label' => '5. Pelatihan Guru', 'type' => 'boolean'], ['key' => 'program_rekrutmen', 'label' => '6. Penyerapan Lulusan', 'type' => 'boolean'], ['key' => 'program_tefa', 'label' => '7. Teaching Factory', 'type' => 'boolean'], ['key' => 'program_kelas', 'label' => '8. Kelas Industri', 'type' => 'boolean'], ['key' => 'program_csr', 'label' => '9. CSR/Alat/Bahan/Beasiswa', 'type' => 'boolean'], ['key' => 'program_lainnya_text', 'label' => '10. Lainnya'], ['key' => 'contribution_quantitative', 'label' => 'Kontribusi Kuantitatif'], ['key' => 'contribution_qualitative', 'label' => 'Kontribusi Kualitatif']], 'dynamicRows' => true])
                        @include("$partialPrefix.section-table", ['code' => 'C.2.1', 'title' => 'Teaching Factory (TEFA) / Unit Produksi Sekolah', 'data' => $answers['C.2.1'] ?? null, 'columns' => [['key' => 'kategori_tefa', 'label' => 'Kategori TEFA'], ['key' => 'product_name', 'label' => 'Nama Produk (Barang/Jasa)'], ['key' => 'product_description', 'label' => 'Deskripsi Produk'], ['key' => 'industry_partner', 'label' => 'Mitra Industri'], ['key' => 'tefa_identifikasi', 'label' => '1. Identifikasi Produk', 'type' => 'boolean'], ['key' => 'tefa_analisis_komp', 'label' => '2. Analisis Kompetensi', 'type' => 'boolean'], ['key' => 'tefa_perencanaan', 'label' => '3. Perencanaan Produksi', 'type' => 'boolean'], ['key' => 'tefa_analisis_sda', 'label' => '4. Analisis Sumber Daya', 'type' => 'boolean'], ['key' => 'tefa_pengerjaan', 'label' => '5. Pengerjaan Produk', 'type' => 'boolean'], ['key' => 'tefa_penyerahan', 'label' => '6. Penyerahan Produk', 'type' => 'boolean'], ['key' => 'tefa_purna_jual', 'label' => '7. Layanan Purna Jual', 'type' => 'boolean'], ['key' => 'certification', 'label' => 'Sertifikasi Kompetensi'], ['key' => 'curriculum_sync', 'label' => 'Sinkronisasi Kurikulum'], ['key' => 'branding_haki', 'label' => 'Branding/HAKI'], ['key' => 'quality_evaluation', 'label' => 'Evaluasi Mutu Produk'], ['key' => 'revenue_activity', 'label' => 'Omzet (Rp/Bulan/Tahun)'], ['key' => 'industry_contribution', 'label' => 'Keterlibatan Alumni/Industri'], ['key' => 'constraints', 'label' => 'Kendala']], 'dynamicRows' => true])
                        @include("$partialPrefix.section-table", ['code' => 'C.3.1', 'title' => 'Data Pelatihan dan Sertifikasi Guru', 'data' => $answers['C.3.1'] ?? null, 'columns' => [['key' => 'teacher_name', 'label' => 'Nama Guru'], ['key' => 'subject', 'label' => 'Mata Pelajaran'], ['key' => 'competency_type', 'label' => 'Jenis Pelatihan/Sertifikasi'], ['key' => 'training_title', 'label' => 'Judul Pelatihan'], ['key' => 'year', 'label' => 'Tahun'], ['key' => 'provider', 'label' => 'Penyedia'], ['key' => 'duration', 'label' => 'Durasi'], ['key' => 'evidence', 'label' => 'Bukti'], ['key' => 'remarks', 'label' => 'Keterangan']], 'dynamicRows' => true])
                        @include("$partialPrefix.section-table", ['code' => 'C.3.2', 'title' => 'Analisis Kebutuhan Pelatihan Guru ke Depan', 'data' => $answers['C.3.2'] ?? null, 'columns' => [['key' => 'current_condition', 'label' => 'Kondisi Saat Ini'], ['key' => 'gap', 'label' => 'Kesenjangan']], 'staticRows' => ['Persentase guru produktif bersertifikat kompetensi (BNSP/Industri)', 'Rata-rata jam pelatihan per guru per tahun', 'Keterlibatan dalam magang industri', 'Frekuensi update teknologi/kompetensi', 'Ketersediaan guru dengan sertifikat asesor BNSP']])
                        @include("$partialPrefix.section-table", ['code' => 'C.3.3', 'title' => 'Data Ketenagaan dan Beban Mengajar (Rasio Guru-Murid)', 'data' => $answers['C.3.3'] ?? null, 'columns' => [['key' => 'concentration', 'label' => 'Konsentrasi Keahlian'], ['key' => 'total_teacher_count', 'label' => 'Jumlah Guru (PNA)'], ['key' => 'student_count', 'label' => 'Jumlah Total Murid'], ['key' => 'ideal_ratio', 'label' => 'Rasio Ideal (Guru PNA : Murid)'], ['key' => 'ratio_gm', 'label' => 'Rasio Guru:Murid (G:M)'], ['key' => 'concentration_count', 'label' => 'Jml Konsentrasi per Bidang'], ['key' => 'productive_teacher_count', 'label' => 'Jml Guru Produktif'], ['key' => 'ideal_productive_ratio', 'label' => 'Rasio Ideal (Guru Produktif : Konsentrasi)'], ['key' => 'ratio_productive_concentration', 'label' => 'Rasio Guru Produktif : Konsentrasi'], ['key' => 'remarks', 'label' => 'Keterangan']], 'dynamicRows' => true])
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
