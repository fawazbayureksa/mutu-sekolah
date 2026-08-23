{{-- 4. DATA SKOR RATA-RATA TKA 2025 (GAP VS STANDAR NASIONAL) --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
    <div class="card-body p-4">
        {{-- Section Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <div>
                <h6 class="fw-bold mb-0 text-dark">Data Skor Rata-rata TKA 2025 (Tes Kemampuan Akademik)</h6>
                <small class="text-muted">Komparasi nilai rata-rata mata pelajaran sekolah terhadap standar rata-rata nasional</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border px-2 py-1 font-monospace" style="font-size: 0.75rem;">
                    Rata-rata Sekolah: <strong>{{ number_format($kpis['avg_tka_school'] ?: 52.4, 2) }}</strong>
                </span>
                <span class="badge bg-light text-secondary border px-2 py-1 font-monospace" style="font-size: 0.75rem;">
                    Rata-rata Nasional: <strong>{{ number_format($kpis['avg_tka_national'] ?: 51.8, 2) }}</strong>
                </span>
            </div>
        </div>

        @php
            $tkaSubjects = [
                [
                    'name' => 'Bahasa Indonesia',
                    'category' => 'Wajib',
                    'national_avg' => 55.38,
                    'school_avg' => 56.08,
                    'diff' => 0.70,
                    'note' => 'Di atas standar nasional',
                ],
                [
                    'name' => 'Matematika',
                    'category' => 'Wajib',
                    'national_avg' => 36.10,
                    'school_avg' => 33.70,
                    'diff' => -2.40,
                    'note' => 'Perlu penguatan numerasi dasar',
                ],
                [
                    'name' => 'Bahasa Inggris',
                    'category' => 'Wajib',
                    'national_avg' => 24.93,
                    'school_avg' => 27.33,
                    'diff' => 2.40,
                    'note' => 'Keunggulan kompetensi literasi global',
                ],
                [
                    'name' => 'Projek Kreatif & Kewirausahaan (PKK)',
                    'category' => 'Kejuruan',
                    'national_avg' => 56.34,
                    'school_avg' => 57.84,
                    'diff' => 1.50,
                    'note' => 'Kesiapan produk & rintisan usaha',
                ],
                [
                    'name' => 'Mata Pelajaran Pilihan Terkait (Fisika / Kimia / Biologi / TIK)',
                    'category' => 'Pilihan Kejuruan',
                    'national_avg' => 45.20,
                    'school_avg' => 45.45,
                    'diff' => 0.25,
                    'note' => 'Mendukung fondasi kejuruan spesifik',
                ],
            ];
        @endphp

        <div class="row g-3 mb-4">
            @foreach ($tkaSubjects as $item)
                @php
                    $isPositive = $item['diff'] >= 0;
                    $badgeClass = $isPositive ? 'text-success' : 'text-danger';
                @endphp
                <div class="col-12 col-md-6 col-xl">
                    <div class="p-3 rounded-3 border h-100 d-flex flex-column justify-content-between" style="background-color: #f8fafc;">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="badge bg-white text-muted border" style="font-size: 0.65rem;">{{ $item['category'] }}</span>
                                <strong class="{{ $badgeClass }} small font-monospace">
                                    {{ $isPositive ? '+' : '' }}{{ number_format($item['diff'], 2) }}
                                </strong>
                            </div>
                            <strong class="text-dark small d-block mb-2 text-truncate" title="{{ $item['name'] }}">
                                {{ $item['name'] }}
                            </strong>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.7rem;">
                                <span>Sekolah: <strong class="text-dark">{{ number_format($item['school_avg'], 2) }}</strong></span>
                                <span>Nasional: {{ number_format($item['national_avg'], 2) }}</span>
                            </div>
                            <div class="progress mt-1" style="height: 4px; background-color: #e2e8f0;">
                                <div class="progress-bar" style="width: {{ min(100, $item['school_avg']) }}%; background-color: {{ $isPositive ? '#0e4a66' : '#94a3b8' }};"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tabel Rincian Mapel TKA --}}
        <div class="table-responsive rounded-3 border">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;" class="text-center">#</th>
                        <th>Mata Pelajaran</th>
                        <th>Kategori</th>
                        <th class="text-center">Rata-rata Nasional 2025</th>
                        <th class="text-center">Rata-rata Sekolah</th>
                        <th class="text-center">Gap Selisih (+ / -)</th>
                        <th>Catatan Analisis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tkaSubjects as $idx => $subj)
                        @php
                            $isPos = $subj['diff'] >= 0;
                        @endphp
                        <tr>
                            <td class="text-center text-muted small">{{ $idx + 1 }}</td>
                            <td><strong class="text-dark">{{ $subj['name'] }}</strong></td>
                            <td><span class="badge bg-light text-dark border">{{ $subj['category'] }}</span></td>
                            <td class="text-center font-monospace">{{ number_format($subj['national_avg'], 2) }}</td>
                            <td class="text-center font-monospace"><strong class="text-dark">{{ number_format($subj['school_avg'], 2) }}</strong></td>
                            <td class="text-center">
                                <span class="badge {{ $isPos ? 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' : 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25' }} fw-bold">
                                    {{ $isPos ? '+' : '' }}{{ number_format($subj['diff'], 2) }}
                                </span>
                            </td>
                            <td><small class="text-muted">{{ $subj['note'] }}</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
