{{-- 
    [DEFERRED FOR REPORT / LAPORAN MODULE]
    Tabel Direktori Pengajuan Sekolah untuk digunakan pada modul Laporan (Report Page).
--}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="fw-bold text-dark mb-0">Direktori Pengajuan Sekolah</h6>
                <small class="text-muted">Rincian per pengajuan instrumen asesmen</small>
            </div>
            @if(isset($schoolList))
                <span class="badge bg-light text-secondary border px-2 py-1 font-monospace" style="font-size: 0.75rem;">
                    {{ $schoolList->total() }} Data
                </span>
            @endif
        </div>

        @if (!isset($schoolList) || $schoolList->isEmpty())
            <x-dashboard.empty-state message="Tidak ada data pengajuan sekolah yang sesuai dengan filter." />
        @else
            <div class="table-responsive rounded-3 border">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;" class="text-center">#</th>
                            <th>Sekolah & NPSN</th>
                            <th>Wilayah</th>
                            <th>Konsentrasi Keahlian</th>
                            <th class="text-center">UKK (%)</th>
                            <th class="text-center">Tracer (%)</th>
                            <th class="text-center">Putus Sekolah (%)</th>
                            <th class="text-center">Skor TKA</th>
                            <th class="text-end" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schoolList as $idx => $row)
                            <tr>
                                <td class="text-center text-muted small">{{ $schoolList->firstItem() + $idx }}</td>
                                <td>
                                    <strong class="text-dark d-block">{{ $row->school_name }}</strong>
                                    <small class="text-muted">NPSN: {{ $row->npsn ?: '-' }} &bull; {{ $row->school_status ?: 'Negeri' }}</small>
                                </td>
                                <td>
                                    <span class="small text-muted">{{ $row->regency->name ?? '-' }}, {{ $row->province->name ?? '-' }}</span>
                                </td>
                                <td>
                                    <strong class="text-dark d-block small">{{ $row->expertise_concentration ?: $row->expertise }}</strong>
                                    <small class="text-muted">{{ $row->expertise }}</small>
                                </td>
                                <td class="text-center font-monospace">{{ number_format((float) $row->ukk_rate, 1) }}%</td>
                                <td class="text-center font-monospace">{{ number_format((float) $row->tracer_rate, 1) }}%</td>
                                <td class="text-center font-monospace">{{ number_format((float) $row->dropout_rate, 1) }}%</td>
                                <td class="text-center font-monospace">
                                    @php $tkaDiff = (float) $row->tka_score; @endphp
                                    <strong>{{ $tkaDiff >= 0 ? '+' : '' }}{{ number_format($tkaDiff, 2) }}</strong>
                                </td>
                                <td class="text-end">
                                    @if ($row->school_id)
                                        <a href="{{ route('admin.dashboard.kelembagaan.show', $row->school_id) }}"
                                            class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size: 0.75rem;" title="Detail Sekolah">
                                            Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    Menampilkan {{ $schoolList->firstItem() }} - {{ $schoolList->lastItem() }} dari {{ $schoolList->total() }} data
                </small>
                <div>
                    {{ $schoolList->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
