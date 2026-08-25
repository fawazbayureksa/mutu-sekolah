{{-- Pilar I: Kerja Sama Industri (C.1.1) --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary text-white rounded-pill px-3 py-1">Pilar I</span>
            <h5 class="mb-0 fw-bold text-dark">Kerja Sama Industri (C.1.1)</h5>
        </div>
        <span class="badge bg-light text-muted border">
            Total Terdata: <strong>{{ number_format($industri['total_mitra']) }} Mitra</strong>
        </span>
    </div>

    <div class="card-body p-4">
        <div class="row g-4 mb-4">
            {{-- Status MoU & Durasi --}}
            <div class="col-12 col-lg-5">
                <div class="p-3 bg-light rounded-3 h-100 d-flex flex-column justify-content-between border">
                    <div>
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-pie-chart-fill text-primary"></i>
                            Status MoU / MoA
                        </h6>

                        {{-- Progress bars visual for MoU Status --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-semibold text-success">
                                    <i class="bi bi-circle-fill me-1" style="font-size: 0.6rem;"></i> Aktif
                                </span>
                                <span class="small fw-bold text-success">{{ $industri['mou_aktif_pct'] }}%
                                    ({{ number_format($industri['mou_aktif_count']) }} Mitra)</span>
                            </div>
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $industri['mou_aktif_pct'] }}%;"
                                    aria-valuenow="{{ $industri['mou_aktif_pct'] }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-semibold text-danger">
                                    <i class="bi bi-circle-fill me-1" style="font-size: 0.6rem;"></i> Tidak Aktif
                                </span>
                                <span class="small fw-bold text-danger">{{ $industri['mou_tidak_aktif_pct'] }}%
                                    ({{ number_format($industri['mou_tidak_aktif_count']) }} Mitra)</span>
                            </div>
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: {{ $industri['mou_tidak_aktif_pct'] }}%;"
                                    aria-valuenow="{{ $industri['mou_tidak_aktif_pct'] }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Avg Duration Card --}}
                    <div class="card bg-white border-0 shadow-sm p-3 mt-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary-subtle text-primary p-3 d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="bi bi-hourglass-split fs-4"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Rata-rata Durasi Kerja Sama</div>
                                <h4 class="fw-bold mb-0 text-dark">{{ $industri['avg_duration'] }} <span
                                        class="fs-6 fw-normal text-muted">Tahun</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 10 Cakupan Program Kerja Sama --}}
            <div class="col-12 col-lg-7">
                <div class="p-3 bg-light rounded-3 h-100 border">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-bar-chart-steps text-primary"></i>
                        Distribusi Cakupan Program Kerja Sama (10 Indikator)
                    </h6>

                    <div class="d-flex flex-column gap-2">
                        @foreach ($industri['program_distribution'] as $prog)
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small text-dark fw-medium"
                                        style="font-size: 0.8rem;">{{ $prog['label'] }}</span>
                                    <span class="small fw-bold text-primary">{{ $prog['percentage'] }}% <span
                                            class="text-muted fw-normal">({{ $prog['count'] }})</span></span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $prog['percentage'] }}%;"
                                        aria-valuenow="{{ $prog['percentage'] }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Direktori Mitra Industri --}}
        <div class="border rounded-3 overflow-hidden">
            <div class="bg-light p-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-list-columns-reverse text-primary"></i>
                    Direktori Mitra Industri & Bentuk Kontribusi
                </h6>
                <span class="badge bg-white text-dark border">Menampilkan {{ count($industri['partners_list']) }} dari
                    {{ number_format($industri['total_partners_count'] ?? count($industri['partners_list'])) }}
                    Data</span>
            </div>

            <div class="table-responsive" style="max-height: 380px;">
                <table class="table table-hover table-striped align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width: 4%;">No</th>
                            <th style="width: 20%;">Nama Sekolah</th>
                            <th style="width: 20%;">Mitra Industri</th>
                            <th style="width: 10%;">Status MoU</th>
                            <th style="width: 10%;">Durasi</th>
                            <th style="width: 20%;">Cakupan Program</th>
                            <th style="width: 16%;">Kontribusi Kuantitatif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($industri['partners_list'] as $idx => $p)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td>
                                    <strong>{{ $p['school_name'] }}</strong>
                                    <div class="text-muted" style="font-size: 0.75rem;">NPSN: {{ $p['school_npsn'] }}
                                        &bull; {{ $p['expertise'] }}</div>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $p['partner_name'] }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge {{ strcasecmp($p['mou_status'], 'Aktif') === 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border-0">
                                        {{ $p['mou_status'] }}
                                    </span>
                                </td>
                                <td>{{ $p['duration'] }}</td>
                                <td>
                                    @if (!empty($p['programs']))
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach (array_slice($p['programs'], 0, 3) as $prg)
                                                <span class="badge bg-secondary-subtle text-secondary border-0"
                                                    style="font-size: 0.7rem;">{{ $prg }}</span>
                                            @endforeach
                                            @if (count($p['programs']) > 3)
                                                <span class="badge bg-light text-muted border"
                                                    style="font-size: 0.7rem;">+{{ count($p['programs']) - 3 }}
                                                    lainnya</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 180px;"
                                        title="{{ $p['quant_contrib'] }}">
                                        {{ $p['quant_contrib'] }}
                                    </small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-folder-x fs-4 d-block mb-1"></i>
                                    Belum ada data mitra industri yang tercatat pada filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
