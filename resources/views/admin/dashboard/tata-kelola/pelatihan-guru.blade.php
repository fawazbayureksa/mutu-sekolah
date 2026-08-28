{{-- Pilar III: Data Pelatihan & Sertifikasi Guru Produktif (C.3.1 & C.3.2) --}}
<div class="card border mb-4">
    <div class="card-header bg-white py-2 px-3 border-bottom">
        <div class="d-flex align-items-baseline gap-2">
            <span class="text-muted small fw-semibold">III.</span>
            <h6 class="mb-0 fw-bold text-dark">DATA PELATIHAN DAN SERTIFIKASI GURU PRODUKTIF <span
                    class="fw-normal text-muted small">(C.3.1 & C.3.2)</span></h6>
            <span class="ms-auto text-muted small">Total Riwayat: <strong
                    class="text-dark">{{ number_format($guru['total_trained']) }}</strong></span>
        </div>
    </div>

    <div class="card-body p-3">
        <div class="row g-3 mb-3">

            {{-- Sebaran Jenis Pelatihan --}}
            <div class="col-12 col-lg-5">
                <div class="h-100 p-3 border rounded bg-white">
                    <div class="text-muted small fw-semibold mb-3">Sebaran Jenis Pelatihan Diikuti Guru</div>
                    <div class="d-flex flex-column gap-2">
                        @foreach ($guru['training_distribution'] as $item)
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-dark" style="font-size:0.82rem">{{ $item['label'] }}</span>
                                    <span class="fw-bold text-dark" style="font-size:0.82rem">{{ $item['percentage'] }}%
                                        <span class="fw-normal text-muted">({{ $item['count'] }})</span>
                                    </span>
                                </div>
                                <div class="progress" style="height:8px; border-radius:3px;">
                                    <div class="progress-bar bg-dark" style="width:{{ $item['percentage'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Analisis Kesenjangan (GAP) C.3.2 --}}
            <div class="col-12 col-lg-7">
                <div class="h-100 p-3 border rounded bg-white">
                    <div class="text-muted small fw-semibold mb-3">Analisis Kesenjangan (GAP) Kebutuhan Pelatihan <span
                            class="fw-normal">(C.3.2)</span></div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle mb-0" style="font-size:0.82rem;">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:44%">Aspek Pengukuran</th>
                                    <th class="text-center" style="width:18%">Kondisi Saat Ini</th>
                                    <th class="text-center" style="width:18%">Target Ideal</th>
                                    <th class="text-center" style="width:20%">Kesenjangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guru['gap_matrix'] as $gap)
                                    <tr>
                                        <td class="text-dark fw-medium">{{ $gap['aspect'] }}</td>
                                        <td class="text-center fw-bold text-dark">{{ $gap['current'] }}</td>
                                        <td class="text-center text-muted">{{ $gap['target'] }}</td>
                                        <td class="text-center">
                                            <span
                                                class="fw-bold {{ $gap['is_negative'] ? 'text-danger' : 'text-success' }}">
                                                {{ $gap['gap'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Riwayat Pelatihan Guru --}}
        {{-- <div class="border rounded overflow-hidden">
            <div class="px-3 py-2 bg-light border-bottom d-flex align-items-center justify-content-between">
                <span class="small fw-semibold text-dark">Daftar Pelatihan & Sertifikasi Guru (C.3.1)</span>
                <span class="text-muted small">Menampilkan {{ count($guru['training_list']) }} dari {{ number_format($guru['total_trainings_count'] ?? count($guru['training_list'])) }} data</span>
            </div>
            <div class="table-responsive" style="max-height:340px;">
                <table class="table table-sm table-hover align-middle mb-0" style="font-size:0.82rem;">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width:3%">No</th>
                            <th style="width:20%">Nama Sekolah</th>
                            <th style="width:14%">Nama Guru</th>
                            <th style="width:12%">Mata Pelajaran</th>
                            <th style="width:14%">Jenis Kompetensi</th>
                            <th style="width:24%">Judul Pelatihan / Penyedia</th>
                            <th style="width:13%">Tahun / Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($guru['training_list'] as $idx => $t)
                            <tr>
                                <td class="text-center text-muted">{{ $idx + 1 }}</td>
                                <td class="fw-medium text-dark">{{ $t['school_name'] }}</td>
                                <td class="text-dark">{{ $t['teacher_name'] }}</td>
                                <td class="text-muted">{{ $t['subject'] }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border" style="font-size:0.72rem">{{ $t['competency_type'] }}</span>
                                </td>
                                <td>
                                    <div class="text-dark text-truncate" style="max-width:200px; font-size:0.82rem" title="{{ $t['title'] }}">{{ $t['title'] }}</div>
                                    <div class="text-muted" style="font-size:0.73rem">{{ $t['provider'] }}</div>
                                </td>
                                <td class="text-muted">
                                    {{ $t['year'] }}
                                    @if (!empty($t['duration']) && $t['duration'] !== '-')
                                        <span class="text-muted small">({{ $t['duration'] }})</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data pelatihan guru untuk filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> --}}
    </div>
</div>
