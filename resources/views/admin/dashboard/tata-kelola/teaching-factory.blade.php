{{-- Pilar II: Teaching Factory (TEFA) / Unit Produksi (C.2.1) --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-info text-white rounded-pill px-3 py-1">Pilar II</span>
            <h5 class="mb-0 fw-bold text-dark">Teaching Factory (TEFA) / Unit Produksi (C.2.1)</h5>
        </div>
        <span class="badge bg-light text-muted border">
            Total Terdata: <strong>{{ number_format($tefa['total_products']) }} Unit Produk</strong>
        </span>
    </div>

    <div class="card-body p-4">
        <div class="row g-4 mb-4">
            {{-- Sebaran Kategori Penerapan TEFA --}}
            <div class="col-12 col-lg-4">
                <div class="p-3 bg-light rounded-3 h-100 border">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-diagram-3-fill text-info"></i>
                        Sebaran Kategori TEFA
                    </h6>

                    <div class="d-flex flex-column gap-3 mt-2">
                        @foreach ($tefa['category_distribution'] as $cat)
                            <div class="p-2 bg-white rounded-2 border">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small fw-semibold text-dark">{{ $cat['label'] }}</span>
                                    <span class="small fw-bold text-info">{{ $cat['percentage'] }}%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $cat['percentage'] }}%;" aria-valuenow="{{ $cat['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-muted mt-1" style="font-size: 0.7rem;">{{ number_format($cat['count']) }} Produk/Unit terdaftar</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 7 Tahapan Keterlaksanaan TEFA --}}
            <div class="col-12 col-lg-5">
                <div class="p-3 bg-light rounded-3 h-100 border">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-check2-square text-info"></i>
                        Keterlaksanaan 7 Tahapan Dokumen TEFA
                    </h6>

                    <div class="d-flex flex-column gap-2">
                        @foreach ($tefa['tahapan_distribution'] as $tahap)
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small text-dark fw-medium" style="font-size: 0.8rem;">{{ $tahap['label'] }}</span>
                                    <span class="small fw-bold text-success">{{ $tahap['percentage'] }}%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $tahap['percentage'] }}%;" aria-valuenow="{{ $tahap['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Omzet & Legalitas --}}
            <div class="col-12 col-lg-3">
                <div class="d-flex flex-column gap-3 h-100">
                    {{-- Standarisasi Card --}}
                    <div class="card border bg-white shadow-sm p-3 flex-fill">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted small fw-medium">Produk Terstandarisasi</span>
                            <i class="bi bi-patch-check-fill text-primary fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">{{ $tefa['standarisasi_pct'] }}%</h3>
                        <small class="text-muted" style="font-size: 0.75rem;">Standar ISO, BPOM, Halal MUI, SKKNI</small>
                    </div>

                    {{-- HAKI Card --}}
                    <div class="card border bg-white shadow-sm p-3 flex-fill">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted small fw-medium">Produk Ber-HAKI</span>
                            <i class="bi bi-shield-check text-info fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">{{ $tefa['haki_pct'] }}%</h3>
                        <small class="text-muted" style="font-size: 0.75rem;">Memiliki Merek Dagang / Hak Cipta</small>
                    </div>

                    {{-- Omzet Card --}}
                    <div class="card border bg-white shadow-sm p-3 flex-fill">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="text-muted small fw-medium">Aktivitas Omzet</span>
                            <i class="bi bi-cash-stack text-success fs-4"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size: 0.95rem;">
                            @if (!empty($tefa['revenue_samples']))
                                {{ $tefa['revenue_samples'][0] }}
                            @else
                                <span class="text-muted fs-6 fw-normal">Sesuai unit produksi aktif</span>
                            @endif
                        </div>
                        <small class="text-muted" style="font-size: 0.75rem;">Rata-rata pendapatan per unit</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Katalog Produk TEFA --}}
        <div class="border rounded-3 overflow-hidden">
            <div class="bg-light p-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-grid-3x3-gap-fill text-info"></i>
                    Katalog Produk TEFA, Standarisasi, & Kendala
                </h6>
                <span class="badge bg-white text-dark border">Menampilkan {{ count($tefa['product_list']) }} dari {{ number_format($tefa['total_products_count'] ?? count($tefa['product_list'])) }} Produk</span>
            </div>

            <div class="table-responsive" style="max-height: 380px;">
                <table class="table table-hover table-striped align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width: 4%;">No</th>
                            <th style="width: 18%;">Nama Sekolah</th>
                            <th style="width: 18%;">Nama Produk</th>
                            <th style="width: 18%;">Kategori & Mitra</th>
                            <th style="width: 10%;">Tahapan</th>
                            <th style="width: 16%;">Mutu / HAKI</th>
                            <th style="width: 16%;">Kendala Teridentifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tefa['product_list'] as $idx => $prod)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td>
                                    <strong>{{ $prod['school_name'] }}</strong>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $prod['expertise'] }}</div>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $prod['product_name'] }}</span>
                                </td>
                                <td>
                                    <div class="small fw-medium text-dark">{{ $prod['category'] }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Mitra: {{ $prod['partner'] }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border-0">{{ $prod['tahapan_score'] }}</span>
                                </td>
                                <td>
                                    <div class="small text-truncate" style="max-width: 180px;" title="{{ $prod['quality_eval'] }}">
                                        <strong>Mutu:</strong> {{ $prod['quality_eval'] }}
                                    </div>
                                    <div class="small text-truncate text-muted" style="max-width: 180px;" title="{{ $prod['branding_haki'] }}">
                                        <strong>HAKI:</strong> {{ $prod['branding_haki'] }}
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 180px;" title="{{ $prod['constraints'] }}">
                                        {{ $prod['constraints'] }}
                                    </small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-folder-x fs-4 d-block mb-1"></i>
                                    Belum ada data produk TEFA yang tercatat pada filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
