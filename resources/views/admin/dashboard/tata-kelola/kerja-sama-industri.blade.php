{{-- Pilar I: Kerja Sama Industri (C.1.1) --}}
<div class="card border mb-4">
    <div class="card-header bg-white py-2 px-3 border-bottom">
        <div class="d-flex align-items-baseline gap-2">
            <span class="text-muted small fw-semibold">I.</span>
            <h6 class="mb-0 fw-bold text-dark">KERJA SAMA INDUSTRI <span class="fw-normal text-muted small">(C.1.1)</span></h6>
            <span class="ms-auto text-muted small">Total Mitra: <strong class="text-dark">{{ number_format($industri['total_mitra']) }}</strong> Perusahaan / Instansi</span>
        </div>
    </div>

    <div class="card-body p-3">
        <div class="row g-3 mb-3">

            {{-- Status MoU --}}
            <div class="col-12 col-lg-4">
                <div class="h-100 p-3 border rounded bg-white">
                    <div class="text-muted small fw-semibold mb-3">Status MoU / MoA</div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-dark">Aktif</span>
                            <span class="small fw-bold text-dark">{{ $industri['mou_aktif_pct'] }}%
                                <span class="fw-normal text-muted">({{ number_format($industri['mou_aktif_count']) }})</span>
                            </span>
                        </div>
                        <div class="progress" style="height:10px; border-radius:4px;">
                            <div class="progress-bar bg-dark" style="width:{{ $industri['mou_aktif_pct'] }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-dark">Tidak Aktif</span>
                            <span class="small fw-bold text-dark">{{ $industri['mou_tidak_aktif_pct'] }}%
                                <span class="fw-normal text-muted">({{ number_format($industri['mou_tidak_aktif_count']) }})</span>
                            </span>
                        </div>
                        <div class="progress" style="height:10px; border-radius:4px;">
                            <div class="progress-bar bg-secondary" style="width:{{ $industri['mou_tidak_aktif_pct'] }}%"></div>
                        </div>
                    </div>

                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center" style="font-size:0.82rem">
                        <span class="text-muted">Rata-rata Durasi Kerja Sama</span>
                        <strong class="text-dark">{{ $industri['avg_duration'] }} Tahun</strong>
                    </div>
                </div>
            </div>

            {{-- 10 Distribusi Program --}}
            <div class="col-12 col-lg-8">
                <div class="h-100 p-3 border rounded bg-white">
                    <div class="text-muted small fw-semibold mb-3">Distribusi Cakupan Program Kerja Sama</div>

                    <div class="d-flex flex-column gap-2">
                        @foreach ($industri['program_distribution'] as $prog)
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-dark" style="font-size:0.82rem">{{ $prog['label'] }}</span>
                                    <span class="fw-bold text-dark" style="font-size:0.82rem">{{ $prog['percentage'] }}%</span>
                                </div>
                                <div class="progress" style="height:8px; border-radius:3px;">
                                    <div class="progress-bar bg-dark" style="width:{{ $prog['percentage'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Direktori Mitra --}}
        <div class="border rounded overflow-hidden">
            <div class="px-3 py-2 bg-light border-bottom d-flex align-items-center justify-content-between">
                <span class="small fw-semibold text-dark">Direktori Mitra Industri</span>
                <span class="text-muted small">Menampilkan {{ count($industri['partners_list']) }} dari {{ number_format($industri['total_partners_count'] ?? count($industri['partners_list'])) }} data</span>
            </div>
            <div class="table-responsive" style="max-height:340px;">
                <table class="table table-sm table-hover align-middle mb-0" style="font-size:0.82rem;">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width:3%">No</th>
                            <th style="width:22%">Nama Sekolah</th>
                            <th style="width:22%">Mitra Industri</th>
                            <th style="width:10%">Status MoU</th>
                            <th style="width:8%">Durasi</th>
                            <th style="width:35%">Cakupan Program</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($industri['partners_list'] as $idx => $p)
                            <tr>
                                <td class="text-center text-muted">{{ $idx + 1 }}</td>
                                <td>
                                    <div class="fw-medium text-dark">{{ $p['school_name'] }}</div>
                                    <div class="text-muted" style="font-size:0.73rem">NPSN {{ $p['school_npsn'] }} &bull; {{ $p['expertise'] }}</div>
                                </td>
                                <td class="fw-medium text-dark">{{ $p['partner_name'] }}</td>
                                <td>
                                    @php $isAktif = strcasecmp($p['mou_status'], 'Aktif') === 0; @endphp
                                    <span class="badge border {{ $isAktif ? 'bg-white text-dark' : 'bg-light text-secondary' }}" style="font-size:0.72rem;">
                                        {{ $p['mou_status'] ?: '-' }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $p['duration'] ?: '-' }}</td>
                                <td>
                                    @if (!empty($p['programs']))
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach (array_slice($p['programs'], 0, 3) as $prg)
                                                <span class="badge bg-light text-dark border" style="font-size:0.7rem;">{{ $prg }}</span>
                                            @endforeach
                                            @if (count($p['programs']) > 3)
                                                <span class="text-muted small">+{{ count($p['programs']) - 3 }} lainnya</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data mitra industri untuk filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
