{{-- Row: Kategori Sekolah, Kurikulum, & Akreditasi --}}
<div class="row g-4 mb-4">
    {{-- Kategori Sekolah Card --}}
    <div class="col-12 col-xl-6 col-md-6">
        <div class="card border-0 shadow-sm h-100"
            style="border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-bold mb-0 text-dark">Kategori Sekolah</h6>
                </div>

                <div class="d-flex flex-column gap-3">
                    @foreach ($stats['category_distribution'] ?? [] as $cat)
                        @php
                            $isUnknownCat = str_contains(strtolower($cat['label']), 'belum');
                            $barFill = $isUnknownCat ? '#64748b' : '#0e4a66';
                        @endphp
                        <div class="d-flex align-items-center">
                            <div class="text-end pe-3 fw-medium small text-dark"
                                style="width: 140px; min-width: 140px; font-size: 0.775rem;">
                                {{ $cat['label'] }}:
                            </div>
                            <div class="flex-grow-1 d-flex align-items-center gap-2"
                                style="border-left: 2px solid #94a3b8; padding-left: 8px; height: 32px;">
                                <div style="width: {{ max(4, $cat['percentage']) }}%; height: 22px; background-color: {{ $barFill }}; border-radius: 2px;"
                                    title="{{ $cat['count'] }} Sekolah ({{ $cat['percentage'] }}%)">
                                </div>
                                <span class="fw-bold text-dark small font-monospace">
                                    {{ $cat['percentage'] }}%
                                </span>
                                <span class="text-muted small" style="font-size: 0.725rem;">
                                    ({{ number_format($cat['count']) }})
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Kurikulum yang Digunakan Card --}}
    <div class="col-12 col-xl-6 col-md-6">
        <div class="card border-0 shadow-sm h-100"
            style="border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-bold mb-0 text-dark">Kurikulum yang Digunakan</h6>
                </div>

                <div class="d-flex flex-column gap-3 justify-content-center">
                    @foreach ($stats['curriculum_distribution'] ?? [] as $curr)
                        @php
                            $isUnknown = str_contains(strtolower($curr['label']), 'belum');
                            $barBg = $isUnknown ? '#f1f5f9' : '#e0f2fe';
                            $fillBg = $isUnknown ? '#64748b' : '#0e4a66';
                        @endphp
                        <div class="position-relative overflow-hidden"
                            style="height: 42px; border-radius: 999px; background-color: {{ $barBg }};"
                            title="{{ $curr['count'] }} Sekolah ({{ $curr['percentage'] }}%)">
                            <div class="h-100"
                                style="width: {{ $curr['percentage'] }}%; background-color: {{ $fillBg }}; border-radius: 999px 0 0 999px; transition: width 0.4s ease;">
                            </div>
                            <div
                                class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-between px-3 pointer-events-none">
                                <span class="fw-bold small {{ $curr['percentage'] > 40 ? 'text-white' : 'text-dark' }}"
                                    style="font-size: 0.8rem;">
                                    {{ $curr['label'] }}: {{ $curr['percentage'] }}%
                                </span>
                                <span
                                    class="small fw-semibold {{ $curr['percentage'] > 70 ? 'text-white' : 'text-secondary' }}"
                                    style="font-size: 0.725rem;">
                                    {{ number_format($curr['count']) }} Sek.
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Akreditasi Sekolah Card --}}
    <div class="col-12 col-xl-12 col-md-12">
        <div class="card border-0 shadow-sm h-100"
            style="border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-bold mb-0 text-dark">Akreditasi Sekolah</h6>
                </div>

                <div class="d-flex flex-column gap-2 justify-content-center">
                    @foreach ($stats['accreditation_distribution'] ?? [] as $acc)
                        <div class="p-2 px-3 rounded-3 d-flex align-items-center justify-content-between border"
                            style="background-color: #f8fafc;"
                            title="{{ $acc['count'] }} Sekolah ({{ $acc['percentage'] }}%)">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge fw-bold"
                                    style="background-color: {{ $acc['color'] }}; color: #ffffff; width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 0.75rem;">
                                    {{ $acc['badge'] }}
                                </span>
                                <span class="fw-semibold text-dark small">{{ $acc['label'] }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-dark fw-bold" style="font-size: 0.8rem;">
                                    {{ $acc['percentage'] }}%
                                </span>
                                <small class="text-muted" style="font-size: 0.725rem;">
                                    ({{ number_format($acc['count']) }})
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Program Keahlian Dominan Card --}}
    <div class="col-12 col-xl-12 col-md-12">
        <div class="card border-0 shadow-sm h-100"
            style="border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">
                            Program Keahlian Dominan
                            @if (!empty($filters['expertise']))
                                <span class="fw-normal text-muted small" style="font-size: 0.8rem;">({{ $filters['expertise'] }})</span>
                            @endif
                        </h6>
                    </div>
                    <span class="badge bg-light text-secondary border px-2 py-1 font-monospace" style="font-size: 0.75rem;">
                        {{ count($stats['program_distribution'] ?? []) }} Program
                    </span>
                </div>

                @if (empty($stats['program_distribution']))
                    <div class="text-center py-4 text-muted">
                        <small>Belum ada data program keahlian untuk kriteria ini.</small>
                    </div>
                @else
                    <div class="d-flex flex-column gap-2 justify-content-center">
                        @foreach ($stats['program_distribution'] as $idx => $prog)
                            @php
                                $isUnknownProg = str_contains(strtolower($prog['label']), 'belum');
                                $barBg = $isUnknownProg ? '#94a3b8' : '#0e4a66';
                            @endphp
                            <div class="p-2 px-3 rounded-3 d-flex align-items-center justify-content-between border"
                                style="background-color: #f8fafc;"
                                title="{{ $prog['count'] }} Pengajuan ({{ $prog['percentage'] }}%)">
                                <div class="d-flex align-items-center gap-2 text-truncate me-2" style="max-width: 60%;">
                                    <span class="badge fw-bold"
                                        style="background-color: #0e4a66; color: #ffffff; width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 0.72rem;">
                                        {{ $idx + 1 }}
                                    </span>
                                    <span class="fw-semibold text-dark small text-truncate" title="{{ $prog['label'] }}">
                                        {{ $prog['label'] }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    <div class="progress" style="width: 70px; height: 6px; background-color: #e2e8f0; border-radius: 3px;">
                                        <div class="progress-bar" style="width: {{ $prog['percentage'] }}%; background-color: {{ $barBg }};"></div>
                                    </div>
                                    <span class="text-dark fw-bold" style="font-size: 0.8rem; width: 45px; text-align: right;">
                                        {{ $prog['percentage'] }}%
                                    </span>
                                    <small class="text-muted" style="font-size: 0.725rem;">
                                        ({{ number_format($prog['count']) }})
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
