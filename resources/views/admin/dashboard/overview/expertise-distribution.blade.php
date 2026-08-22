{{-- ROW 2: Distribusi Pengajuan per Bidang Keahlian (Donut Chart + Breakdown) --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card chart-container-card shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <h6 class="fw-bold mb-0 text-dark">Distribusi Pengajuan per Bidang Keahlian</h6>
                </div>
                <span class="badge bg-light text-secondary border px-2 py-1 font-monospace"
                    style="font-size: 0.75rem;">
                    {{ $stats['total_bidang'] }} Bidang Keahlian
                </span>
            </div>

            @if ($expertiseDist->isEmpty())
                <x-dashboard.empty-state message="Belum ada data distribusi bidang keahlian." />
            @else
                <div class="row align-items-center py-2">
                    <div class="col-12 col-md-3 text-center position-relative mb-3 mb-md-0">
                        <div style="height: 220px; width: 220px; margin: 0 auto; position: relative;">
                            <canvas id="expertiseDonutChart"></canvas>
                            <div
                                class="position-absolute top-50 start-50 translate-middle text-center pointer-events-none">
                                <h3 class="fw-bold mb-0 text-dark lh-1">
                                    {{ number_format($stats['total_submission']) }}</h3>
                                <small class="text-muted" style="font-size: 0.7rem;">Total Pengajuan</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            @php
                                $donutColors = [
                                    '#0e4a66',
                                    '#1e6080',
                                    '#2d789a',
                                    '#418ea9',
                                    '#5ea6c2',
                                    '#82bfd9',
                                    '#aad6ec',
                                    '#cbd5e1',
                                ];
                            @endphp
                            @foreach ($expertiseDist as $idx => $item)
                                @php
                                    $dotColor = $donutColors[$idx % count($donutColors)];
                                @endphp
                                <div class="col-12 col-sm-6">
                                    <div
                                        class="p-3 bg-light rounded-3 border-0 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2 text-truncate me-2">
                                            <span class="legend-dot flex-shrink-0"
                                                style="background-color: {{ $dotColor }};"></span>
                                            <span class="text-dark small fw-semibold text-truncate"
                                                title="{{ $item->expertise }}">{{ $item->expertise }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3 flex-shrink-0 text-end">
                                            <strong class="text-dark small">{{ $item->total_submissions }} <span
                                                    class="fw-normal text-muted"
                                                    style="font-size: 0.7rem;">Pengajuan</span></strong>
                                            <span class="badge bg-white text-dark border"
                                                style="width: 50px;">{{ $item->percentage }}%</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>