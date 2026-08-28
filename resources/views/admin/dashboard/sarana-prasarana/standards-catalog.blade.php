{{-- ROW 5: Standar Sarana & Prasarana Instrumen (col-12) --}}
<div class="row g-4 mb-4" id="katalog-sarpras">
    <div class="col-12">
        <div class="card chart-container-card shadow-sm">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3 pb-2 border-bottom">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">Katalog Standar Sarpras (Permendikbud & SKKNI)</h6>
                    <small class="text-muted">Daftar spesifikasi teknis ruang, peralatan praktik, K3, dan utilitas per konsentrasi keahlian</small>
                </div>

                {{-- Dropdown Selector --}}
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle btn-sm rounded-3 px-3 shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-box-seam me-1 text-secondary"></i>
                        {{ $catalogData['active']['title'] ?? 'Pilih Konsentrasi' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border" style="max-height: 320px; overflow-y: auto;">
                        @foreach ($catalogData['list'] as $key => $item)
                            <li>
                                <a class="dropdown-item py-2 {{ $catalogData['active_key'] === $key ? 'active fw-bold' : '' }}"
                                    href="{{ route('admin.dashboard.sarana-prasarana.index', array_merge($filters, ['catalog_key' => $key])) }}#katalog-sarpras">
                                    <div>
                                        <span class="d-block">{{ $item['title'] }}</span>
                                        <small class="{{ $catalogData['active_key'] === $key ? 'text-white-50' : 'text-muted' }}">{{ $item['expertise'] }}</small>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @if (empty($catalogData['active']))
                <x-dashboard.empty-state message="Pilih konsentrasi keahlian untuk melihat rincian instrumen standar." />
            @else
                {{-- Concentration Mini Banner --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-3">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem;">Konsentrasi Keahlian</small>
                            <h6 class="fw-bold mb-0 text-dark mt-1">{{ $catalogData['active']['title'] }}</h6>
                            <small class="text-secondary fw-semibold">{{ $catalogData['active']['expertise'] }}</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem;">Total Standar Ruang</small>
                            <h5 class="fw-bold mb-0 text-dark mt-1">{{ $catalogData['active']['total_rooms'] }} Ruangan</h5>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem;">Total Standar Alat</small>
                            <h5 class="fw-bold mb-0 text-dark mt-1">{{ $catalogData['active']['total_equipments'] }} Item</h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="p-3 bg-light rounded-3 border h-100">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem;">Kelengkapan Khusus</small>
                            <div class="mt-1 d-flex gap-2">
                                @if ($catalogData['active']['has_smart_class'])
                                    <span class="badge bg-light text-secondary border">Smart Class</span>
                                @endif
                                @if ($catalogData['active']['has_k3'])
                                    <span class="badge bg-light text-secondary border">Standar K3</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Accordion Sections --}}
                <div class="accordion" id="accordionCatalogSections">
                    @foreach ($catalogData['active']['sections'] as $index => $section)
                        <div class="accordion-item border mb-2 rounded-3 overflow-hidden shadow-none">
                            <h2 class="accordion-header" id="headingSection{{ $index }}">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }} fw-bold bg-white text-dark py-2 px-3" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSection{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                    <span class="badge bg-light text-secondary border me-2">{{ $index + 1 }}</span>
                                    {{ $section['title'] ?? 'Bagian Sarpras' }}
                                    <span class="badge bg-light text-dark border ms-auto me-2">{{ count($section['items'] ?? []) }} Item</span>
                                </button>
                            </h2>
                            <div id="collapseSection{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                data-bs-parent="#accordionCatalogSections">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 40px;" class="text-center">No</th>
                                                    <th>Nama Sarana / Prasarana</th>
                                                    @if (($section['type'] ?? '') === 'room')
                                                        <th>Standar Luas / Dimensi</th>
                                                        <th>Kapasitas Standar</th>
                                                    @else
                                                        <th>Spesifikasi Teknis Standar</th>
                                                        <th style="width: 160px;">Kuantitas Standar</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($section['items'] ?? [] as $itemIdx => $item)
                                                    <tr>
                                                        <td class="text-center text-muted">{{ $itemIdx + 1 }}</td>
                                                        <td class="fw-semibold text-dark">{{ $item['name'] ?? '-' }}</td>
                                                        @if (($section['type'] ?? '') === 'room')
                                                            <td>{{ $item['standard_area'] ?? '-' }}</td>
                                                            <td>{{ $item['capacity'] ?? '-' }}</td>
                                                        @else
                                                            <td class="text-muted">{{ $item['spec'] ?? '-' }}</td>
                                                            <td>
                                                                <span class="badge bg-light text-dark border fw-semibold">
                                                                    {{ $item['standard_qty'] ?? '-' }}
                                                                </span>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted py-3">Tidak ada data item.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
