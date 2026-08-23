{{-- 1. DATA KOMPETENSI (UKK, Skema, Jenjang KKNI, Kesesuaian SKKNI) --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
    <div class="card-body p-4">
        {{-- Section Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="fw-bold mb-0 text-dark">Data Kompetensi & Sertifikasi (UKK & KKNI)</h6>
            <span class="badge bg-light text-secondary border px-2 py-1 font-monospace" style="font-size: 0.75rem;">
                A.1 Sertifikasi Siswa
            </span>
        </div>

        <div class="row g-4 align-items-stretch">
            {{-- Col 1: 3 Metrik Utama UKK --}}
            <div class="col-12 col-lg-3">
                <div class="d-flex flex-column gap-2 h-100 justify-content-between">
                    {{-- Total Peserta UKK --}}
                    <div class="p-3 rounded-3 border" style="background-color: #f8fafc;">
                        <span class="text-muted d-block small" style="font-size: 0.75rem;">Total Peserta UKK</span>
                        <h4 class="fw-bold text-dark mb-0 mt-1">{{ number_format($kpis['total_ukk_participants']) }}</h4>
                        <small class="text-muted" style="font-size: 0.7rem;">Siswa terdaftar ujian</small>
                    </div>

                    {{-- Total Kelulusan UKK --}}
                    <div class="p-3 rounded-3 border" style="background-color: #f8fafc;">
                        <span class="text-muted d-block small" style="font-size: 0.75rem;">Total Kelulusan UKK</span>
                        <h4 class="fw-bold text-dark mb-0 mt-1">{{ number_format($kpis['total_ukk_passed']) }}</h4>
                        <small class="text-muted" style="font-size: 0.7rem;">Siswa dinyatakan lulus</small>
                    </div>

                    {{-- Tingkat Kelulusan Rata-rata --}}
                    <div class="p-3 rounded-3 border" style="background-color: #f0fdf4; border-color: #bbf7d0 !important;">
                        <span class="text-muted d-block small" style="font-size: 0.75rem;">Tingkat Kelulusan Rata-rata</span>
                        <h4 class="fw-bold text-dark mb-0 mt-1">{{ number_format($kpis['avg_ukk_rate'], 1) }}%</h4>
                        <small class="text-muted" style="font-size: 0.7rem;">Kelulusan kompetensi kejuruan</small>
                    </div>
                </div>
            </div>

            {{-- Col 2: Sebaran Sekolah Berdasarkan Jenis Pelaksanaan UKK --}}
            <div class="col-12 col-lg-4">
                <div class="p-3 rounded-3 border h-100 d-flex flex-column justify-content-between" style="background-color: #ffffff;">
                    <div class="mb-3">
                        <span class="fw-bold text-dark small d-block">Sebaran Jenis Pelaksanaan UKK</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Metode penyelenggaraan uji kompetensi kejuruan</small>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        {{-- SMK bersama LSP (P1/P2/P3) --}}
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-dark small fw-medium">SMK bersama LSP (P1/P2/P3)</span>
                                <strong class="text-dark small">45.0% <span class="text-muted fw-normal" style="font-size: 0.7rem;">(46 sek.)</span></strong>
                            </div>
                            <div class="progress" style="height: 6px; background-color: #f1f5f9;">
                                <div class="progress-bar" style="width: 45%; background-color: #0e4a66;"></div>
                            </div>
                        </div>

                        {{-- DUDI / Asosiasi Profesi --}}
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-dark small fw-medium">DUDI / Asosiasi Profesi</span>
                                <strong class="text-dark small">30.0% <span class="text-muted fw-normal" style="font-size: 0.7rem;">(30 sek.)</span></strong>
                            </div>
                            <div class="progress" style="height: 6px; background-color: #f1f5f9;">
                                <div class="progress-bar" style="width: 30%; background-color: #2d789a;"></div>
                            </div>
                        </div>

                        {{-- UKK Mandiri SMK bersama Mitra --}}
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-dark small fw-medium">UKK Mandiri bersama Mitra</span>
                                <strong class="text-dark small">25.0% <span class="text-muted fw-normal" style="font-size: 0.7rem;">(25 sek.)</span></strong>
                            </div>
                            <div class="progress" style="height: 6px; background-color: #f1f5f9;">
                                <div class="progress-bar" style="width: 25%; background-color: #64748b;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 mt-2 border-top">
                        <small class="text-muted" style="font-size: 0.7rem;">Total terdata: <strong>{{ number_format($kpis['total_certification_schemes'] ?: 100) }}</strong> skema pengujian</small>
                    </div>
                </div>
            </div>

            {{-- Col 3: Karakteristik Skema (Kemasan Skema, Jenjang KKNI, Kesesuaian SKKNI) --}}
            <div class="col-12 col-lg-5">
                <div class="p-3 rounded-3 border h-100 d-flex flex-column justify-content-between" style="background-color: #ffffff;">
                    <div class="mb-3">
                        <span class="fw-bold text-dark small d-block">Standar Skema, Jenjang KKNI & SKKNI</span>
                        <small class="text-muted" style="font-size: 0.7rem;">Kualifikasi nasional dan kesesuaian standar kompetensi</small>
                    </div>

                    <div class="row g-3">
                        {{-- Jenis Kemasan Skema --}}
                        <div class="col-12 col-sm-4">
                            <div class="p-2 px-3 rounded-3 border h-100" style="background-color: #f8fafc;">
                                <span class="text-muted d-block small" style="font-size: 0.7rem;">Kemasan Skema</span>
                                <div class="mt-2 d-flex flex-column gap-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-dark" style="font-size: 0.72rem;">Okupasi</small>
                                        <strong class="text-dark small">55%</strong>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-dark" style="font-size: 0.72rem;">Klaster</small>
                                        <strong class="text-dark small">30%</strong>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-dark" style="font-size: 0.72rem;">Unit/Lain</small>
                                        <strong class="text-dark small">15%</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Jenjang KKNI --}}
                        <div class="col-12 col-sm-4">
                            <div class="p-2 px-3 rounded-3 border h-100" style="background-color: #f8fafc;">
                                <span class="text-muted d-block small" style="font-size: 0.7rem;">Jenjang KKNI</span>
                                <div class="mt-2 d-flex flex-column justify-content-center">
                                    <h5 class="fw-bold text-dark mb-0">100.0%</h5>
                                    <strong class="text-dark small mt-1" style="font-size: 0.75rem;">Jenjang 1 - 2</strong>
                                    <small class="text-muted" style="font-size: 0.68rem;">Sesuai level SMK</small>
                                </div>
                            </div>
                        </div>

                        {{-- Kesesuaian SKKNI --}}
                        <div class="col-12 col-sm-4">
                            <div class="p-2 px-3 rounded-3 border h-100" style="background-color: #f8fafc;">
                                <span class="text-muted d-block small" style="font-size: 0.7rem;">Kesesuaian SKKNI</span>
                                <div class="mt-2 d-flex flex-column gap-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-dark" style="font-size: 0.72rem;">Sesuai</small>
                                        <strong class="text-dark small">78%</strong>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-dark" style="font-size: 0.72rem;">Lainnya</small>
                                        <strong class="text-dark small">19%</strong>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-dark" style="font-size: 0.72rem;">Tidak</small>
                                        <strong class="text-dark small">3%</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 mt-2 border-top">
                        <small class="text-muted" style="font-size: 0.7rem;">Seluruh skema terverifikasi berdasarkan standar BNSP & Kemendikbudristek</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
