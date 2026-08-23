{{-- TABEL KOMPARASI CAPAIAN MUTU PER KATEGORI KEAHLIAN --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
    <div class="card-header bg-white border-bottom p-3" style="border-radius: 18px 18px 0 0;">
        <ul class="nav nav-pills" id="pesertaDidikTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-3 py-2 fw-semibold me-2" id="tab-bidang-tab" data-bs-toggle="pill"
                    data-bs-target="#tab-bidang" type="button" role="tab" style="font-size: 0.85rem; border-radius: 8px;">
                    Per Bidang Keahlian
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-3 py-2 fw-semibold" id="tab-konsentrasi-tab" data-bs-toggle="pill"
                    data-bs-target="#tab-konsentrasi" type="button" role="tab" style="font-size: 0.85rem; border-radius: 8px;">
                    Per Konsentrasi Keahlian
                </button>
            </li>
        </ul>
    </div>

    <style>
        #pesertaDidikTabs .nav-link {
            color: #475569;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease-in-out;
        }
        #pesertaDidikTabs .nav-link:hover:not(.active) {
            color: #1e293b;
            background-color: #f1f5f9;
            border-color: #cbd5e1;
        }
        #pesertaDidikTabs .nav-link.active {
            color: #ffffff !important;
            background-color: var(--bs-primary, #0d6efd) !important;
            border-color: var(--bs-primary, #0d6efd) !important;
        }
    </style>

    <div class="card-body p-4">
        <div class="tab-content" id="pesertaDidikTabsContent">
            {{-- TAB 1: PER BIDANG KEAHLIAN --}}
            <div class="tab-pane fade show active" id="tab-bidang" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Komparasi Capaian Mutu per Bidang Keahlian</h6>
                    <span class="badge bg-light text-secondary border px-2 py-1 font-monospace" style="font-size: 0.75rem;">
                        {{ $expertiseBreakdown->count() }} Bidang Terdata
                    </span>
                </div>

                @if ($expertiseBreakdown->isEmpty())
                    <x-dashboard.empty-state message="Belum ada data bidang keahlian yang terdata." />
                @else
                    <div class="table-responsive rounded-3 border">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;" class="text-center">#</th>
                                    <th>Bidang Keahlian</th>
                                    <th class="text-center">Pengajuan</th>
                                    <th class="text-center">Sekolah</th>
                                    <th class="text-center">Kelulusan UKK</th>
                                    <th class="text-center">Tracer BMW</th>
                                    <th class="text-center">Putus Sekolah</th>
                                    <th class="text-center">Skor TKA</th>
                                    <th class="text-end" style="width: 90px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expertiseBreakdown as $idx => $item)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $idx + 1 }}</td>
                                        <td><strong class="text-dark">{{ $item->expertise }}</strong></td>
                                        <td class="text-center font-monospace">{{ number_format($item->total_submissions) }}</td>
                                        <td class="text-center font-monospace">{{ number_format($item->total_schools) }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border font-monospace">
                                                {{ number_format((float) $item->avg_ukk_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border font-monospace">
                                                {{ number_format((float) $item->avg_tracer_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border font-monospace">
                                                {{ number_format((float) $item->avg_dropout_rate, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center font-monospace">
                                            @php $tkaDiff = (float) $item->avg_tka_score; @endphp
                                            <strong class="{{ $tkaDiff >= 0 ? 'text-dark' : 'text-danger' }}">
                                                {{ $tkaDiff >= 0 ? '+' : '' }}{{ number_format($tkaDiff, 2) }}
                                            </strong>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.dashboard.peserta-didik.index', array_merge($filters, ['expertise' => $item->expertise])) }}"
                                                class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size: 0.75rem;" title="Filter Bidang Ini">
                                                Filter
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- TAB 2: PER KONSENTRASI KEAHLIAN --}}
            <div class="tab-pane fade" id="tab-konsentrasi" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Komparasi Capaian Mutu per Konsentrasi Keahlian</h6>
                    <span class="badge bg-light text-secondary border px-2 py-1 font-monospace" style="font-size: 0.75rem;">
                        Top {{ $concentrationBreakdown->count() }} Konsentrasi
                    </span>
                </div>

                @if ($concentrationBreakdown->isEmpty())
                    <x-dashboard.empty-state message="Belum ada data konsentrasi keahlian yang terdata." />
                @else
                    <div class="table-responsive rounded-3 border">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;" class="text-center">#</th>
                                    <th>Konsentrasi Keahlian</th>
                                    <th>Bidang & Program</th>
                                    <th class="text-center">Pengajuan</th>
                                    <th class="text-center">Sekolah</th>
                                    <th class="text-center">UKK (%)</th>
                                    <th class="text-center">Tracer (%)</th>
                                    <th class="text-center">Putus Sekolah (%)</th>
                                    <th class="text-center">Skor TKA</th>
                                    <th class="text-end" style="width: 90px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($concentrationBreakdown as $idx => $item)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $idx + 1 }}</td>
                                        <td><strong class="text-dark">{{ $item->expertise_concentration }}</strong></td>
                                        <td><small class="text-muted">{{ $item->expertise_program }} &bull; {{ $item->expertise }}</small></td>
                                        <td class="text-center font-monospace">{{ number_format($item->total_submissions) }}</td>
                                        <td class="text-center font-monospace">{{ number_format($item->total_schools) }}</td>
                                        <td class="text-center font-monospace">{{ number_format((float) $item->avg_ukk_rate, 1) }}%</td>
                                        <td class="text-center font-monospace">{{ number_format((float) $item->avg_tracer_rate, 1) }}%</td>
                                        <td class="text-center font-monospace">{{ number_format((float) $item->avg_dropout_rate, 1) }}%</td>
                                        <td class="text-center font-monospace">
                                            @php $tkaDiff = (float) $item->avg_tka_score; @endphp
                                            <strong class="{{ $tkaDiff >= 0 ? 'text-dark' : 'text-danger' }}">
                                                {{ $tkaDiff >= 0 ? '+' : '' }}{{ number_format($tkaDiff, 2) }}
                                            </strong>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.dashboard.peserta-didik.index', array_merge($filters, ['expertise_concentration' => $item->expertise_concentration])) }}"
                                                class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size: 0.75rem;" title="Filter Konsentrasi Ini">
                                                Filter
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

