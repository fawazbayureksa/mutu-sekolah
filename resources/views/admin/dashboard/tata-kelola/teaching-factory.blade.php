{{-- Pilar II: Teaching Factory (TEFA) / Unit Produksi (C.2.1) --}}
<div class="card border mb-4">
    <div class="card-header bg-white py-2 px-3 border-bottom">
        <div class="d-flex align-items-baseline gap-2">
            <span class="text-muted small fw-semibold">II.</span>
            <h6 class="mb-0 fw-bold text-dark">TEACHING FACTORY (TEFA) / UNIT PRODUKSI <span
                    class="fw-normal text-muted small">(C.2.1)</span></h6>
            <span class="ms-auto text-muted small">Total Produk Terdata: <strong
                    class="text-dark">{{ number_format($tefa['total_products']) }}</strong></span>
        </div>
    </div>

    <div class="card-body p-3">
        <div class="row g-3 mb-3">

            {{-- Sebaran Kategori TEFA --}}
            <div class="col-12 col-lg-4">
                <div class="h-100 p-3 border rounded bg-white">
                    <div class="text-muted small fw-semibold mb-3">Sebaran Kategori Penerapan TEFA</div>
                    <div class="d-flex flex-column gap-3 mt-1">
                        @foreach ($tefa['category_distribution'] as $cat)
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-dark" style="font-size:0.82rem">{{ $cat['label'] }}</span>
                                    <span class="fw-bold text-dark"
                                        style="font-size:0.82rem">{{ $cat['percentage'] }}%</span>
                                </div>
                                <div class="progress" style="height:8px; border-radius:3px;">
                                    <div class="progress-bar bg-dark" style="width:{{ $cat['percentage'] }}%"></div>
                                </div>
                                <div class="text-muted mt-1" style="font-size:0.73rem">
                                    {{ number_format($cat['count']) }} unit terdaftar</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Rata-rata Keterlaksanaan 7 Tahapan TEFA --}}
            <div class="col-12 col-lg-5">
                <div class="h-100 p-3 border rounded bg-white">
                    <div class="text-muted small fw-semibold mb-3">Rata-rata Keterlaksanaan Tahapan / Dokumen TEFA</div>
                    <div class="d-flex flex-column gap-2">
                        @foreach ($tefa['tahapan_distribution'] as $tahap)
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-dark" style="font-size:0.82rem">{{ $tahap['label'] }}</span>
                                    <span class="fw-bold text-dark"
                                        style="font-size:0.82rem">{{ $tahap['percentage'] }}%</span>
                                </div>
                                <div class="progress" style="height:8px; border-radius:3px;">
                                    <div class="progress-bar bg-dark" style="width:{{ $tahap['percentage'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Omzet TEFA & Evaluasi Mutu/Legalitas --}}
            <div class="col-12 col-lg-3">
                <div class="d-flex flex-column gap-3 h-100">
                    {{-- Omzet --}}
                    <div class="p-3 border rounded bg-white flex-fill">
                        <div class="text-muted small fw-semibold mb-2">Omzet TEFA</div>
                        <div class="fw-bold text-dark" style="font-size:0.95rem;">
                            @if (!empty($tefa['revenue_samples']))
                                {{ $tefa['revenue_samples'][0] }}
                            @else
                                <span class="text-muted fw-normal">Data tidak tersedia</span>
                            @endif
                        </div>
                        <div class="text-muted mt-1" style="font-size:0.73rem">
                            {{ number_format($tefa['total_products']) }} Unit Aktif
                        </div>
                    </div>

                    {{-- Evaluasi Mutu & Legalitas --}}
                    <div class="p-3 border rounded bg-white flex-fill">
                        <div class="text-muted small fw-semibold mb-2">Evaluasi Mutu & Legalitas</div>
                        <div class="d-flex gap-3">
                            <div class="text-center">
                                <div class="fw-bold text-dark fs-5 lh-1">{{ $tefa['standarisasi_pct'] }}%</div>
                                <div class="text-muted mt-1" style="font-size:0.73rem">Produk<br>Terstandarisasi</div>
                            </div>
                            <div class="border-start"></div>
                            <div class="text-center">
                                <div class="fw-bold text-dark fs-5 lh-1">{{ $tefa['haki_pct'] }}%</div>
                                <div class="text-muted mt-1" style="font-size:0.73rem">Produk<br>Ber-HAKI</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Katalog Produk TEFA --}}
        {{-- <div class="border rounded overflow-hidden">
            <div class="px-3 py-2 bg-light border-bottom d-flex align-items-center justify-content-between">
                <span class="small fw-semibold text-dark">Katalog Produk TEFA, Standarisasi & Kendala</span>
                <span class="text-muted small">Menampilkan {{ count($tefa['product_list']) }} dari {{ number_format($tefa['total_products_count'] ?? count($tefa['product_list'])) }} produk</span>
            </div>
            <div class="table-responsive" style="max-height:340px;">
                <table class="table table-sm table-hover align-middle mb-0" style="font-size:0.82rem;">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width:3%">No</th>
                            <th style="width:20%">Nama Sekolah</th>
                            <th style="width:18%">Nama Produk</th>
                            <th style="width:16%">Kategori</th>
                            <th style="width:10%">Tahapan</th>
                            <th style="width:16%">Mutu / HAKI</th>
                            <th style="width:17%">Kendala</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tefa['product_list'] as $idx => $prod)
                            <tr>
                                <td class="text-center text-muted">{{ $idx + 1 }}</td>
                                <td>
                                    <div class="fw-medium text-dark">{{ $prod['school_name'] }}</div>
                                    <div class="text-muted" style="font-size:0.73rem">{{ $prod['expertise'] }}</div>
                                </td>
                                <td class="fw-medium text-dark">{{ $prod['product_name'] }}</td>
                                <td>
                                    <div class="text-dark" style="font-size:0.8rem">{{ $prod['category'] }}</div>
                                    <div class="text-muted" style="font-size:0.73rem">Mitra: {{ $prod['partner'] }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border" style="font-size:0.72rem">{{ $prod['tahapan_score'] }}</span>
                                </td>
                                <td>
                                    <div class="text-truncate small" style="max-width:160px" title="{{ $prod['quality_eval'] }}">{{ $prod['quality_eval'] }}</div>
                                    <div class="text-muted text-truncate" style="font-size:0.73rem; max-width:160px" title="{{ $prod['branding_haki'] }}">HAKI: {{ $prod['branding_haki'] }}</div>
                                </td>
                                <td>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width:160px" title="{{ $prod['constraints'] }}">{{ $prod['constraints'] ?: '-' }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data produk TEFA untuk filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> --}}
    </div>
</div>
