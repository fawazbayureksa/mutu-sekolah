{{-- ROW 2: Pemetaan Detail Sarpras per Konsentrasi Keahlian (col-12) --}}
<div class="row g-4 mb-4" id="detail-konsentrasi">
    <div class="col-12">
        <div class="card chart-container-card shadow-sm">
            @if (empty($activeConcentration))
                <x-dashboard.empty-state message="Pilih konsentrasi keahlian pada filter untuk melihat analisis detail sarana dan prasarana." />
            @else
                {{-- Concentration Card Header with Selector --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3 pb-3 border-bottom">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-light text-secondary border">
                                {{ $activeConcentration['expertise'] }}
                            </span>
                            @if (!empty($activeConcentration['program']))
                                <span class="badge bg-light text-muted border">
                                    {{ $activeConcentration['program'] }}
                                </span>
                            @endif
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">{{ $activeConcentration['name'] }}</h5>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        {{-- Quick Switcher for Concentrations --}}
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle rounded-3 px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-diagram-3 me-1 text-secondary"></i> Ganti Konsentrasi
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border" style="max-height: 320px; overflow-y: auto;">
                                @foreach ($concentrationCards as $cItem)
                                    <li>
                                        <a class="dropdown-item py-2 {{ ($activeConcentration['name'] ?? '') === $cItem['name'] ? 'active fw-bold' : '' }}"
                                            href="{{ route('admin.dashboard.sarana-prasarana.index', array_filter(array_merge($filters, ['expertise_concentration' => $cItem['name']]))) }}#detail-konsentrasi">
                                            <span class="d-block">{{ $cItem['name'] }}</span>
                                            <small class="{{ ($activeConcentration['name'] ?? '') === $cItem['name'] ? 'text-white-50' : 'text-muted' }}">{{ $cItem['expertise'] }}</small>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <span class="badge bg-light text-dark border px-3 py-2 font-monospace">
                            {{ $activeConcentration['total_submissions'] }} Pengajuan Terdata
                        </span>
                    </div>
                </div>

                {{-- Card Content Grid --}}
                <div class="row g-4 align-items-stretch">
                    {{-- Left Column: Equipment & Tools Progress Checklist --}}
                    <div class="col-12 col-lg-12 col-md-12">
                        <div class="card aspect-card h-100 shadow-none border">
                            <div class="aspect-header d-flex justify-content-between align-items-center">
                                <span>Inventarisasi Peralatan Praktik Utama</span>
                                <small class="text-muted fw-normal">Standar Kebutuhan Minimal</small>
                            </div>
                            <div class="d-flex flex-column flex-grow-1">
                                @foreach ($activeConcentration['items'] as $item)
                                    <div class="aspect-item">
                                        <div class="flex-grow-1">
                                            <span class="fw-bold text-dark d-block small lh-1 mb-1">{{ $item['name'] }}</span>
                                            <small class="text-muted" style="font-size: 0.7rem;">
                                                Tingkat kesesuaian peralatan
                                            </small>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="aspect-progress-container">
                                                <div class="aspect-progress-fill" style="width: {{ $item['rate'] }}%;"></div>
                                            </div>
                                            <span class="fw-bold text-dark small" style="width: 45px; text-align: right;">
                                                {{ $item['rate'] }}%
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
