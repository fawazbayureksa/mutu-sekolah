{{-- 3. DATA PUTUS SEKOLAH & KETIDAKNAIKAN KELAS --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
    <div class="card-body p-4">
        {{-- Section Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="fw-bold mb-0 text-dark">Data Putus Sekolah & Ketidaknaikan Kelas</h6>
            <span class="badge bg-light text-secondary border px-2 py-1 font-monospace" style="font-size: 0.75rem;">
                A.3 Retensi Siswa
            </span>
        </div>

        <div class="row g-4 align-items-stretch">
            {{-- Col 1: 4 Metrik Angka Retensi --}}
            <div class="col-12 col-lg-5">
                <div class="row g-2 h-100">
                    {{-- Total Murid Aktif --}}
                    <div class="col-6">
                        <div class="p-3 rounded-3 border h-100" style="background-color: #f8fafc;">
                            <span class="text-muted d-block small" style="font-size: 0.7rem;">Total Murid Aktif</span>
                            <h4 class="fw-bold text-dark mb-0 mt-1">{{ number_format($kpis['total_initial_students'] ?: 21500) }}</h4>
                            <small class="text-muted" style="font-size: 0.68rem;">Populasi siswa berjalan</small>
                        </div>
                    </div>

                    {{-- Total Putus Sekolah --}}
                    <div class="col-6">
                        <div class="p-3 rounded-3 border h-100" style="background-color: #fef2f2; border-color: #fecaca !important;">
                            <span class="text-muted d-block small" style="font-size: 0.7rem;">Total Putus Sekolah</span>
                            <h4 class="fw-bold text-dark mb-0 mt-1">{{ number_format($kpis['total_dropout_count'] ?: 380) }}</h4>
                            <small class="text-muted" style="font-size: 0.68rem;">Rata-rata: <strong>{{ number_format($kpis['avg_dropout_rate'], 2) }}%</strong></small>
                        </div>
                    </div>

                    {{-- Total Siswa Tinggal Kelas --}}
                    <div class="col-6">
                        <div class="p-3 rounded-3 border h-100" style="background-color: #f8fafc;">
                            <span class="text-muted d-block small" style="font-size: 0.7rem;">Total Tidak Naik Kelas</span>
                            <h4 class="fw-bold text-dark mb-0 mt-1">230</h4>
                            <small class="text-muted" style="font-size: 0.68rem;">Siswa mengulang</small>
                        </div>
                    </div>

                    {{-- Rasio Retensi Sekolah --}}
                    <div class="col-6">
                        <div class="p-3 rounded-3 border h-100" style="background-color: #f0fdf4; border-color: #bbf7d0 !important;">
                            <span class="text-muted d-block small" style="font-size: 0.7rem;">Tingkat Kelangsungan</span>
                            <h4 class="fw-bold text-dark mb-0 mt-1">{{ number_format(max(0, 100 - $kpis['avg_dropout_rate']), 1) }}%</h4>
                            <small class="text-muted" style="font-size: 0.68rem;">Tuntas pendidikan</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Col 2: Faktor-Faktor Utama Penyebab Putus Sekolah --}}
            <div class="col-12 col-lg-7">
                <div class="p-3 rounded-3 border h-100 d-flex flex-column justify-content-between" style="background-color: #ffffff;">
                    <div class="mb-3">
                        <span class="fw-bold text-dark small d-block">Faktor-Faktor Utama Penyebab Putus Sekolah</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Distribusi akar masalah kendala penyelesaian masa studi</small>
                    </div>

                    <div class="d-flex flex-column gap-2 my-auto">
                        {{-- Faktor Ekonomi --}}
                        <div class="d-flex align-items-center justify-content-between p-2 px-3 rounded-2 border" style="background-color: #f8fafc;">
                            <div class="d-flex align-items-center gap-2 text-truncate me-2" style="width: 45%;">
                                <span class="text-dark small fw-medium text-truncate">Faktor Ekonomi</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-end">
                                <div class="progress" style="width: 120px; height: 6px; background-color: #e2e8f0;">
                                    <div class="progress-bar" style="width: 45%; background-color: #0e4a66;"></div>
                                </div>
                                <strong class="text-dark small" style="width: 45px; text-align: right;">45.0%</strong>
                            </div>
                        </div>

                        {{-- Bekerja / Menikah --}}
                        <div class="d-flex align-items-center justify-content-between p-2 px-3 rounded-2 border" style="background-color: #f8fafc;">
                            <div class="d-flex align-items-center gap-2 text-truncate me-2" style="width: 45%;">
                                <span class="text-dark small fw-medium text-truncate">Bekerja / Menikah (e.g., Melaut / Sektor Informal)</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-end">
                                <div class="progress" style="width: 120px; height: 6px; background-color: #e2e8f0;">
                                    <div class="progress-bar" style="width: 38%; background-color: #2d789a;"></div>
                                </div>
                                <strong class="text-dark small" style="width: 45px; text-align: right;">38.0%</strong>
                            </div>
                        </div>

                        {{-- Pindah Sekolah --}}
                        <div class="d-flex align-items-center justify-content-between p-2 px-3 rounded-2 border" style="background-color: #f8fafc;">
                            <div class="d-flex align-items-center gap-2 text-truncate me-2" style="width: 45%;">
                                <span class="text-dark small fw-medium text-truncate">Pindah Sekolah / Ikut Orang Tua</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-end">
                                <div class="progress" style="width: 120px; height: 6px; background-color: #e2e8f0;">
                                    <div class="progress-bar" style="width: 12%; background-color: #64748b;"></div>
                                </div>
                                <strong class="text-dark small" style="width: 45px; text-align: right;">12.0%</strong>
                            </div>
                        </div>

                        {{-- Lainnya --}}
                        <div class="d-flex align-items-center justify-content-between p-2 px-3 rounded-2 border" style="background-color: #f8fafc;">
                            <div class="d-flex align-items-center gap-2 text-truncate me-2" style="width: 45%;">
                                <span class="text-dark small fw-medium text-truncate">Lain-lain</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-end">
                                <div class="progress" style="width: 120px; height: 6px; background-color: #e2e8f0;">
                                    <div class="progress-bar" style="width: 5%; background-color: #94a3b8;"></div>
                                </div>
                                <strong class="text-dark small" style="width: 45px; text-align: right;">5.0%</strong>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 mt-2 border-top">
                        <small class="text-muted" style="font-size: 0.7rem;">Pemetaan intervensi bantuan beasiswa PIP & fleksibilitas pembelajaran vokasi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
