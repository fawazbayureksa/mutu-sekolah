{{--
    Section Tracer Study Partial (A.2.1)
    Variables:
    - $code: Section code
    - $title: Section title
    - $data: Tracer study data with {header: {graduation_class}, rows: [...]}
--}}
@php
    $tracerRows = [
        ['key' => 'total_graduates', 'label' => 'Jumlah total lulusan', 'has_qualitative' => false],
        [
            'key' => 'employment_rate',
            'label' => 'Persentase bekerja (karyawan)',
            'has_qualitative' => true,
            'qualitative_label' => 'Sektor industri utama',
        ],
        [
            'key' => 'waiting_time',
            'label' => 'Rata-rata waktu tunggu mendapatkan pekerjaan pertama (bulan)',
            'has_qualitative' => false,
        ],
        [
            'key' => 'job_relevance',
            'label' => 'Kesesuaian bidang kerja dengan kompetensi keahlian (%)',
            'has_qualitative' => false,
        ],
        [
            'key' => 'user_satisfaction',
            'label' => 'Tingkat kepuasan pengguna (skala 1-5)',
            'has_qualitative' => true,
            'qualitative_label' => 'Testimoni',
        ],
        [
            'key' => 'entrepreneurship_rate',
            'label' => 'Persentase berwirausaha/membuka usaha (%)',
            'has_qualitative' => true,
            'qualitative_label' => 'Jenis usaha',
        ],
        [
            'key' => 'entrepreneurship_relevance',
            'label' => 'Persentase usaha terkait kompetensi keahlian (%)',
            'has_qualitative' => false,
        ],
        [
            'key' => 'continuing_education',
            'label' => 'Persentase yang melanjutkan kuliah (%)',
            'has_qualitative' => false,
        ],
    ];
@endphp

<div class="section-block mb-4">
    <h6 class="fw-bold mb-3">{{ $code }} - {{ $title }}</h6>

    @php
        $tableData = is_string($data) ? json_decode($data, true) : $data;
        $header = $tableData['header'] ?? [];
        $rows = $tableData['rows'] ?? [];

        // Convert rows array to keyed lookup - flatten all row data
        $rowsMap = [];
        foreach ($rows as $row) {
            foreach ($row as $key => $value) {
                $rowsMap[$key] = $value;
            }
        }
    @endphp

    @if (!empty($tableData))
        {{-- Show graduation class --}}
        @if (!empty($header['graduation_class']))
            <div class="bg-light p-2 rounded mb-2 small">
                <strong>Kelas Lulusan:</strong> {{ $header['graduation_class'] }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-sm" style="min-width: 650px;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px; white-space: nowrap; font-size: 0.75rem;">No</th>
                        <th style="width: 35%; white-space: nowrap; font-size: 0.75rem;">Pertanyaan</th>
                        <th style="width: 15%; white-space: nowrap; font-size: 0.75rem;">Standar Minimal SMK PK</th>
                        <th style="width: 15%; white-space: nowrap; font-size: 0.75rem;">Jawaban</th>
                        <th style="width: 30%; white-space: nowrap; font-size: 0.75rem;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tracerRows as $idx => $row)
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td>{{ $row['label'] }}</td>
                            <td>{{ $rows[$idx]['standard_minimal'] ?? '-' }}</td>
                            <td>{{ $rowsMap[$row['key'] . '_quantitative'] ?? '-' }}</td>
                            <td>
                                @if ($row['has_qualitative'])
                                    {{ $rowsMap[$row['key'] . '_qualitative'] ?? '-' }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-secondary small mb-0">
            <i class="bi bi-info-circle me-1"></i> Belum ada data untuk bagian ini.
        </div>
    @endif
</div>
