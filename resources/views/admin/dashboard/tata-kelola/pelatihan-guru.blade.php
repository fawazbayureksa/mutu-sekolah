{{-- Pilar III: Data Pelatihan & Sertifikasi Guru Produktif (C.3.1 & C.3.2) --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning text-dark rounded-pill px-3 py-1">Pilar III</span>
            <h5 class="mb-0 fw-bold text-dark">Data Pelatihan & Sertifikasi Guru Produktif (C.3.1 & C.3.2)</h5>
        </div>
        <span class="badge bg-light text-muted border">
            Total Terdata: <strong>{{ number_format($guru['total_trained']) }} Riwayat Pelatihan</strong>
        </span>
    </div>

    <div class="card-body p-4">
        <div class="row g-4 mb-4">
            {{-- Sebaran Jenis Pelatihan --}}
            <div class="col-12 col-lg-5">
                <div class="p-3 bg-light rounded-3 h-100 border">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-pie-chart text-warning"></i>
                        Sebaran Jenis Pelatihan Diikuti Guru
                    </h6>

                    <div class="d-flex flex-column gap-2 mt-2">
                        @foreach ($guru['training_distribution'] as $item)
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small text-dark fw-medium" style="font-size: 0.8rem;">{{ $item['label'] }}</span>
                                    <span class="small fw-bold text-dark">{{ $item['percentage'] }}% <span class="text-muted fw-normal">({{ $item['count'] }})</span></span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $item['percentage'] }}%;" aria-valuenow="{{ $item['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Analisis Kesenjangan (GAP) Kebutuhan Pelatihan (5 Aspek Standar C.3.2) --}}
            <div class="col-12 col-lg-7">
                <div class="p-3 bg-light rounded-3 h-100 border">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-sliders text-warning"></i>
                            Analisis Kesenjangan (GAP) Kebutuhan Pelatihan (C.3.2)
                        </h6>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered bg-white align-middle mb-0" style="font-size: 0.82rem;">
                            <thead class="table-secondary">
                                <tr>
                                    <th style="width: 42%;">Aspek Pengukuran</th>
                                    <th style="width: 20%;" class="text-center">Kondisi Saat Ini</th>
                                    <th style="width: 18%;" class="text-center">Target Ideal</th>
                                    <th style="width: 20%;" class="text-center">Kesenjangan (GAP)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guru['gap_matrix'] as $gap)
                                    <tr>
                                        <td>
                                            <span class="fw-medium text-dark">{{ $gap['aspect'] }}</span>
                                        </td>
                                        <td class="text-center fw-bold text-dark">
                                            {{ $gap['current'] }}
                                        </td>
                                        <td class="text-center text-muted">
                                            {{ $gap['target'] }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $gap['is_negative'] ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} border-0 px-2 py-1">
                                                <i class="bi {{ $gap['is_negative'] ? 'bi-dash-circle-fill' : 'bi-plus-circle-fill' }} me-1"></i>
                                                {{ $gap['gap'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Riwayat Pelatihan Guru --}}
        <div class="border rounded-3 overflow-hidden">
            <div class="bg-light p-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-person-lines-fill text-warning"></i>
                    Daftar Pelatihan & Sertifikasi Guru yang Diikuti (C.3.1)
                </h6>
                <span class="badge bg-white text-dark border">Menampilkan {{ count($guru['training_list']) }} dari {{ number_format($guru['total_trainings_count'] ?? count($guru['training_list'])) }} Data</span>
            </div>

            <div class="table-responsive" style="max-height: 380px;">
                <table class="table table-hover table-striped align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width: 4%;">No</th>
                            <th style="width: 18%;">Nama Sekolah</th>
                            <th style="width: 16%;">Nama Guru</th>
                            <th style="width: 14%;">Mata Pelajaran</th>
                            <th style="width: 16%;">Jenis Kompetensi</th>
                            <th style="width: 20%;">Judul Pelatihan</th>
                            <th style="width: 12%;">Tahun / Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($guru['training_list'] as $idx => $t)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td>
                                    <strong>{{ $t['school_name'] }}</strong>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $t['teacher_name'] }}</span>
                                </td>
                                <td>{{ $t['subject'] }}</td>
                                <td>
                                    <span class="badge bg-warning-subtle text-dark border-0">{{ $t['competency_type'] }}</span>
                                </td>
                                <td>
                                    <div class="small fw-medium text-dark text-truncate" style="max-width: 200px;" title="{{ $t['title'] }}">
                                        {{ $t['title'] }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Penyedia: {{ $t['provider'] }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $t['year'] }}</span>
                                    <span class="text-muted small ms-1">{{ $t['duration'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-folder-x fs-4 d-block mb-1"></i>
                                    Belum ada data pelatihan guru yang tercatat pada filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
