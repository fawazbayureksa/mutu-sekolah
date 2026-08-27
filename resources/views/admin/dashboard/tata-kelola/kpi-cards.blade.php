{{-- 4 Primary Summary Metric Cards for Tata Kelola — 2x2 layout --}}
<div class="row g-3 mb-4">

    {{-- I: Kerja Sama Industri --}}
    <div class="col-12 col-md-6">
        <div class="card border bg-white h-100">
            <div class="card-body p-4">
                <div class="text-uppercase text-muted fw-semibold mb-3" style="font-size:0.72rem; letter-spacing:0.08em;">
                    I &nbsp;/&nbsp; Kerja Sama Industri (C.1.1)
                </div>

                <div class="d-flex align-items-end gap-2 mb-1">
                    <span class="fw-bold text-dark lh-1" style="font-size:2.8rem;">{{ number_format($stats['total_mitra']) }}</span>
                    <span class="text-muted mb-1" style="font-size:1rem;">Mitra</span>
                </div>
                <div class="text-muted mb-4" style="font-size:0.85rem;">Perusahaan / Instansi terdata</div>

                <div class="row g-0 border rounded overflow-hidden">
                    <div class="col-6 p-3 border-end">
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Status MoU Aktif</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem; line-height:1.1;">{{ $industri['mou_aktif_pct'] }}<span class="fs-6 fw-normal text-muted">%</span></div>
                        <div class="text-muted" style="font-size:0.75rem;">{{ number_format($industri['mou_aktif_count']) }} mitra</div>
                    </div>
                    <div class="col-6 p-3">
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Rata-rata Durasi</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem; line-height:1.1;">{{ $industri['avg_duration'] }}<span class="fs-6 fw-normal text-muted"> Thn</span></div>
                        <div class="text-muted" style="font-size:0.75rem;">per kerja sama</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- II: Teaching Factory --}}
    <div class="col-12 col-md-6">
        <div class="card border bg-white h-100">
            <div class="card-body p-4">
                <div class="text-uppercase text-muted fw-semibold mb-3" style="font-size:0.72rem; letter-spacing:0.08em;">
                    II &nbsp;/&nbsp; Teaching Factory / TEFA (C.2.1)
                </div>

                <div class="d-flex align-items-end gap-2 mb-1">
                    <span class="fw-bold text-dark lh-1" style="font-size:2.8rem;">{{ number_format($stats['total_tefa_unit']) }}</span>
                    <span class="text-muted mb-1" style="font-size:1rem;">Unit</span>
                </div>
                <div class="text-muted mb-4" style="font-size:0.85rem;">Produk / Unit TEFA aktif terdata</div>

                <div class="row g-0 border rounded overflow-hidden">
                    <div class="col-6 p-3 border-end">
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Produk Terstandarisasi</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem; line-height:1.1;">{{ $tefa['standarisasi_pct'] }}<span class="fs-6 fw-normal text-muted">%</span></div>
                        <div class="text-muted" style="font-size:0.75rem;">ISO / Halal / BPOM</div>
                    </div>
                    <div class="col-6 p-3">
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Produk Ber-HAKI</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem; line-height:1.1;">{{ $tefa['haki_pct'] }}<span class="fs-6 fw-normal text-muted">%</span></div>
                        <div class="text-muted" style="font-size:0.75rem;">Merek / Hak Cipta</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- III: Pelatihan Guru --}}
    <div class="col-12 col-md-6">
        <div class="card border bg-white h-100">
            <div class="card-body p-4">
                <div class="text-uppercase text-muted fw-semibold mb-3" style="font-size:0.72rem; letter-spacing:0.08em;">
                    III &nbsp;/&nbsp; Pelatihan & Sertifikasi Guru (C.3.1)
                </div>

                <div class="d-flex align-items-end gap-2 mb-1">
                    <span class="fw-bold text-dark lh-1" style="font-size:2.8rem;">{{ number_format($stats['total_guru_trained']) }}</span>
                    <span class="text-muted mb-1" style="font-size:1rem;">Riwayat</span>
                </div>
                <div class="text-muted mb-4" style="font-size:0.85rem;">Pelatihan & sertifikasi guru produktif</div>

                <div class="row g-0 border rounded overflow-hidden">
                    <div class="col-12 p-3">
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Tercatat dari</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem; line-height:1.1;">{{ number_format($stats['total_schools']) }}<span class="fs-6 fw-normal text-muted"> Sekolah</span></div>
                        <div class="text-muted" style="font-size:0.75rem;">dalam periode yang difilter</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- IV: Rasio Guru : Murid --}}
    <div class="col-12 col-md-6">
        <div class="card border bg-white h-100">
            <div class="card-body p-4">
                <div class="text-uppercase text-muted fw-semibold mb-3" style="font-size:0.72rem; letter-spacing:0.08em;">
                    IV &nbsp;/&nbsp; Rasio Guru : Murid (C.3.3)
                </div>

                <div class="d-flex align-items-end gap-2 mb-1">
                    <span class="fw-bold text-dark lh-1" style="font-size:2.8rem;">{{ $stats['avg_ratio_gm'] }}</span>
                </div>
                <div class="text-muted mb-4" style="font-size:0.85rem;">Rata-rata rasio guru (PNA) terhadap murid</div>

                <div class="row g-0 border rounded overflow-hidden">
                    <div class="col-6 p-3 border-end">
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Target Ideal</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem; line-height:1.1;">1 : 15</div>
                        <div class="text-muted" style="font-size:0.75rem;">standar nasional</div>
                    </div>
                    <div class="col-6 p-3">
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Status</div>
                        <div class="fw-bold {{ $stats['is_ratio_ideal'] ? 'text-success' : 'text-danger' }}" style="font-size:1.1rem; line-height:1.3;">
                            {{ $stats['is_ratio_ideal'] ? 'Sangat Memadai' : 'Perlu Perhatian' }}
                        </div>
                        <div class="text-muted" style="font-size:0.75rem;">
                            {{ $stats['is_ratio_ideal'] ? 'Melampaui standar' : 'Melebihi batas ideal' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
