{{-- Pilar IV: Ketenagaan & Beban Mengajar (Rasio Guru-Murid) (C.3.3) --}}
<div class="card border mb-4">
    <div class="card-header bg-white py-2 px-3 border-bottom">
        <div class="d-flex align-items-baseline gap-2">
            <span class="text-muted small fw-semibold">IV.</span>
            <h6 class="mb-0 fw-bold text-dark">KETENAGAAN DAN BEBAN MENGAJAR (RASIO GURU-MURID) <span
                    class="fw-normal text-muted small">(C.3.3)</span></h6>
            <span class="ms-auto text-muted small">Data Konsentrasi: <strong
                    class="text-dark">{{ number_format($ketenagaan['total_concentration_count'] ?? count($ketenagaan['concentration_rows'])) }}</strong></span>
        </div>
    </div>

    <div class="card-body p-3">
        <div class="row g-3 mb-3">

            {{-- Box 1: Rata-rata Guru & Murid per Sekolah --}}
            <div class="col-12 col-md-4">
                <div class="h-100 p-3 border rounded bg-white">
                    <div class="text-muted small fw-semibold mb-3">Rata-rata per Sekolah</div>

                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="text-dark" style="font-size:0.85rem">Jumlah Guru (PNA)</span>
                        <div class="text-end">
                            <div class="fw-bold fs-5 text-dark lh-1">{{ $ketenagaan['avg_teacher_per_school'] }}</div>
                            <div class="text-muted" style="font-size:0.73rem">Orang</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-dark" style="font-size:0.85rem">Jumlah Murid</span>
                        <div class="text-end">
                            <div class="fw-bold fs-5 text-dark lh-1">{{ $ketenagaan['avg_student_per_school'] }}</div>
                            <div class="text-muted" style="font-size:0.73rem">Orang</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Box 2: Rasio Guru (PNA) : Murid --}}
            <div class="col-12 col-md-4">
                <div class="h-100 p-3 border rounded bg-white text-center d-flex flex-column justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold mb-2">Rasio Guru (PNA) : Murid</div>
                        <div class="fw-bold text-dark lh-1 mb-2" style="font-size:2.6rem; letter-spacing:-1px;">
                            {{ $ketenagaan['avg_ratio_gm_label'] }}
                        </div>
                        <div class="text-muted small">Target Ideal: <strong class="text-dark">1 : 15.0</strong></div>
                    </div>
                    <div class="mt-3">
                        @if ($ketenagaan['is_ratio_ideal'])
                            <div class="border rounded p-2 bg-light">
                                <div class="fw-semibold text-dark" style="font-size:0.82rem">SANGAT MEMADAI</div>
                                <div class="text-muted" style="font-size:0.73rem">Riil melampaui standar nasional</div>
                            </div>
                        @else
                            <div class="border rounded p-2 bg-light">
                                <div class="fw-semibold text-dark" style="font-size:0.82rem">PERLU PERHATIAN</div>
                                <div class="text-muted" style="font-size:0.73rem">Rasio melebihi beban ideal 1:15</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Box 3: Guru Produktif per Konsentrasi --}}
            <div class="col-12 col-md-4">
                <div class="h-100 p-3 border rounded bg-white text-center d-flex flex-column justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold mb-2">Jumlah Guru Produktif per Konsentrasi Keahlian
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-4 mt-3">
                            <div>
                                <div class="fw-bold text-dark lh-1" style="font-size:2rem;">
                                    {{ $ketenagaan['avg_prod_per_conc'] }}</div>
                                <div class="text-muted mt-1" style="font-size:0.75rem">Orang<br><span
                                        class="text-dark fw-medium">Aktual</span></div>
                            </div>
                            <div class="text-muted fw-bold">vs</div>
                            <div>
                                <div class="fw-bold text-dark lh-1" style="font-size:2rem;">
                                    {{ $ketenagaan['target_ideal_prod'] }}</div>
                                <div class="text-muted mt-1" style="font-size:0.75rem">Orang<br><span
                                        class="text-dark fw-medium">Target Ideal</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if ($ketenagaan['is_prod_ideal_met'])
                            <div class="border rounded p-2 bg-light">
                                <div class="fw-semibold text-dark" style="font-size:0.82rem">MENCAPAI TARGET IDEAL</div>
                                <div class="text-muted" style="font-size:0.73rem">Kecukupan guru produktif terpenuhi
                                </div>
                            </div>
                        @else
                            <div class="border rounded p-2 bg-light">
                                <div class="fw-semibold text-danger" style="font-size:0.82rem">BELUM MENCAPAI TARGET
                                    IDEAL</div>
                                <div class="text-muted" style="font-size:0.73rem">Perlu penambahan guru produktif</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Matriks Beban Mengajar per Konsentrasi --}}
        {{-- <div class="border rounded overflow-hidden">
            <div class="px-3 py-2 bg-light border-bottom d-flex align-items-center justify-content-between">
                <span class="small fw-semibold text-dark">Matriks Beban Mengajar & Rasio Ketenagaan per Konsentrasi</span>
                <span class="text-muted small">Menampilkan {{ count($ketenagaan['concentration_rows']) }} dari {{ number_format($ketenagaan['total_concentration_count'] ?? count($ketenagaan['concentration_rows'])) }} data</span>
            </div>
            <div class="table-responsive" style="max-height:340px;">
                <table class="table table-sm table-hover align-middle mb-0" style="font-size:0.82rem;">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width:3%">No</th>
                            <th style="width:22%">Nama Sekolah</th>
                            <th style="width:18%">Konsentrasi Keahlian</th>
                            <th class="text-center" style="width:12%">Total Guru</th>
                            <th class="text-center" style="width:10%">Total Murid</th>
                            <th class="text-center" style="width:11%">Rasio G:M</th>
                            <th class="text-center" style="width:12%">Guru Produktif</th>
                            <th class="text-center" style="width:12%">Rasio Produktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ketenagaan['concentration_rows'] as $idx => $row)
                            <tr>
                                <td class="text-center text-muted">{{ $idx + 1 }}</td>
                                <td>
                                    <div class="fw-medium text-dark">{{ $row['school_name'] }}</div>
                                    <div class="text-muted" style="font-size:0.73rem">{{ $row['expertise'] }}</div>
                                </td>
                                <td class="text-dark">{{ $row['concentration'] }}</td>
                                <td class="text-center fw-bold text-dark">{{ $row['total_teachers'] }}</td>
                                <td class="text-center text-muted">{{ $row['total_students'] }}</td>
                                <td class="text-center">
                                    <span class="fw-medium text-dark">{{ $row['ratio_gm'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-dark">{{ $row['productive_teachers'] }}</span>
                                    <div class="text-muted" style="font-size:0.73rem">Target: {{ $row['ideal_ratio'] }}</div>
                                </td>
                                <td class="text-center text-muted">{{ $row['ratio_pc'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada data ketenagaan untuk filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> --}}
    </div>
</div>
