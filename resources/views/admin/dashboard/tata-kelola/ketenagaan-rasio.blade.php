{{-- Pilar IV: Ketenagaan & Rasio Beban Mengajar (C.3.3) --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success text-white rounded-pill px-3 py-1">Pilar IV</span>
            <h5 class="mb-0 fw-bold text-dark">Ketenagaan & Beban Mengajar (Rasio Guru-Murid) (C.3.3)</h5>
        </div>
        <span class="badge bg-light text-muted border">
            Total Konsentrasi Terdata: <strong>{{ count($ketenagaan['concentration_rows']) }} Data</strong>
        </span>
    </div>

    <div class="card-body p-4">
        {{-- 3 Summary Comparison Panels matching Infographic --}}
        <div class="row g-4 mb-4">
            {{-- Box 1: Rata-rata Guru PNA & Murid per Sekolah --}}
            <div class="col-12 col-md-4">
                <div class="p-3 bg-light rounded-3 h-100 border d-flex flex-column justify-content-between">
                    <div class="mb-3 p-3 bg-white rounded-3 border text-center shadow-sm">
                        <span class="text-muted small fw-medium d-block mb-1">Rata-rata Jumlah Guru (PNA) / Sekolah</span>
                        <h2 class="fw-bold text-dark mb-0">{{ $ketenagaan['avg_teacher_per_school'] }} <span class="fs-6 fw-normal text-muted">Orang</span></h2>
                    </div>

                    <div class="p-3 bg-white rounded-3 border text-center shadow-sm">
                        <span class="text-muted small fw-medium d-block mb-1">Rata-rata Jumlah Murid / Sekolah</span>
                        <h2 class="fw-bold text-dark mb-0">{{ $ketenagaan['avg_student_per_school'] }} <span class="fs-6 fw-normal text-muted">Orang</span></h2>
                    </div>
                </div>
            </div>

            {{-- Box 2: Rasio Guru (PNA) : Murid --}}
            <div class="col-12 col-md-4">
                <div class="p-3 bg-light rounded-3 h-100 border text-center d-flex flex-column justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Rasio Guru (PNA) : Murid</span>
                        <div class="my-2">
                            <h1 class="fw-bold text-primary mb-0" style="font-size: 2.8rem; letter-spacing: -1px;">
                                {{ $ketenagaan['avg_ratio_gm_label'] }}
                            </h1>
                        </div>
                        <div class="text-muted small mb-2">Target Ideal: <strong>1 : 15.0</strong></div>
                    </div>

                    <div class="mt-2">
                        @if ($ketenagaan['is_ratio_ideal'])
                            <div class="alert alert-success d-flex align-items-center justify-content-center gap-2 py-2 px-3 mb-0 border-0 shadow-sm">
                                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                                <div class="text-start">
                                    <strong class="d-block text-success" style="font-size: 0.85rem;">SANGAT MEMADAI</strong>
                                    <small class="text-success-emphasis" style="font-size: 0.72rem;">Rasio riil melampaui standar nasional</small>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning d-flex align-items-center justify-content-center gap-2 py-2 px-3 mb-0 border-0 shadow-sm">
                                <i class="bi bi-exclamation-triangle-fill fs-5 text-warning"></i>
                                <div class="text-start">
                                    <strong class="d-block text-warning-emphasis" style="font-size: 0.85rem;">PERLU PERHATIAN</strong>
                                    <small class="text-muted" style="font-size: 0.72rem;">Rasio melebihi beban ideal 1:15</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Box 3: Guru Produktif per Konsentrasi Keahlian --}}
            <div class="col-12 col-md-4">
                <div class="p-3 bg-light rounded-3 h-100 border text-center d-flex flex-column justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase tracking-wider">Guru Produktif / Konsentrasi</span>
                        <div class="d-flex align-items-center justify-content-center gap-3 my-2">
                            <div>
                                <i class="bi bi-person-fill text-info fs-3 d-block"></i>
                                <span class="fw-bold text-dark fs-3">{{ $ketenagaan['avg_prod_per_conc'] }}</span>
                                <small class="text-muted d-block" style="font-size: 0.7rem;">Aktual</small>
                            </div>
                            <span class="text-muted fw-bold fs-5">VS</span>
                            <div>
                                <i class="bi bi-people-fill text-secondary fs-3 d-block"></i>
                                <span class="fw-bold text-dark fs-3">{{ $ketenagaan['target_ideal_prod'] }}</span>
                                <small class="text-muted d-block" style="font-size: 0.7rem;">Target Ideal</small>
                            </div>
                        </div>
                        <div class="text-muted small mb-2">Target Bidang: <strong>1 : {{ (int)$ketenagaan['target_ideal_prod'] }} Konsentrasi</strong></div>
                    </div>

                    <div class="mt-2">
                        @if ($ketenagaan['is_prod_ideal_met'])
                            <div class="alert alert-success d-flex align-items-center justify-content-center gap-2 py-2 px-3 mb-0 border-0 shadow-sm">
                                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                                <div class="text-start">
                                    <strong class="d-block text-success" style="font-size: 0.85rem;">MENCAPAI TARGET IDEAL</strong>
                                    <small class="text-success-emphasis" style="font-size: 0.72rem;">Kecukupan guru produktif terpenuhi</small>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger d-flex align-items-center justify-content-center gap-2 py-2 px-3 mb-0 border-0 shadow-sm">
                                <i class="bi bi-x-circle-fill fs-5 text-danger"></i>
                                <div class="text-start">
                                    <strong class="d-block text-danger" style="font-size: 0.85rem;">BELUM MENCAPAI TARGET</strong>
                                    <small class="text-danger-emphasis" style="font-size: 0.72rem;">Perlu penambahan guru produktif</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Ketenagaan & Rasio per Konsentrasi --}}
        <div class="border rounded-3 overflow-hidden">
            <div class="bg-light p-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-table text-success"></i>
                    Matriks Beban Mengajar & Rasio Ketenagaan per Konsentrasi
                </h6>
                <span class="badge bg-white text-dark border">Menampilkan {{ count($ketenagaan['concentration_rows']) }} dari {{ number_format($ketenagaan['total_concentration_count'] ?? count($ketenagaan['concentration_rows'])) }} Data</span>
            </div>

            <div class="table-responsive" style="max-height: 380px;">
                <table class="table table-hover table-striped align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width: 4%;">No</th>
                            <th style="width: 18%;">Nama Sekolah</th>
                            <th style="width: 18%;">Konsentrasi Keahlian</th>
                            <th style="width: 12%;" class="text-center">Total Guru / Murid</th>
                            <th style="width: 12%;" class="text-center">Rasio G:M</th>
                            <th style="width: 14%;" class="text-center">Guru Produktif</th>
                            <th style="width: 12%;" class="text-center">Rasio Produktif</th>
                            <th style="width: 10%;">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ketenagaan['concentration_rows'] as $idx => $row)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td>
                                    <strong>{{ $row['school_name'] }}</strong>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $row['expertise'] }}</div>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $row['concentration'] }}</span>
                                </td>
                                <td class="text-center">
                                    <div><strong>{{ $row['total_teachers'] }}</strong> Guru</div>
                                    <small class="text-muted">{{ $row['total_students'] }} Murid</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary border-0 fs-6 px-2 py-1">
                                        {{ $row['ratio_gm'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-dark">{{ $row['productive_teachers'] }}</span> Orang
                                    <div class="text-muted" style="font-size: 0.72rem;">{{ $row['ideal_ratio'] }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary-subtle text-dark border-0">
                                        {{ $row['ratio_pc'] }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $row['remarks'] }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-folder-x fs-4 d-block mb-1"></i>
                                    Belum ada data ketenagaan yang tercatat pada filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
