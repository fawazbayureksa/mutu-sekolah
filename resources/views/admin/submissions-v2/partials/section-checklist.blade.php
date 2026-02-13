{{--
    Section Checklist Partial (B.2.1)
    Variables:
    - $code: Section code
    - $title: Section title
    - $data: Checklist data with {header: {}, rows: [...]}
--}}
@php
    $checklistItems = [
        [
            'key' => 'layout_industry',
            'label' => 'Apakah tata letak bengkel/lab meniru lingkungan kerja industri?',
        ],
        [
            'key' => 'calibration',
            'label' => 'Apakah peralatan telah melalui kalibrasi/pemeliharaan berkala?',
        ],
        [
            'key' => 'sop_available',
            'label' => 'Apakah tersedia prosedur operasi standar (SOP) untuk setiap alat utama?',
        ],
        [
            'key' => 'k3_implementation',
            'label' => 'Apakah K3 (Keselamatan dan Kesehatan Kerja) diterapkan dengan baik?',
        ],
    ];
@endphp

<div class="section-block mb-4">
    <h6 class="fw-bold mb-3">{{ $code }} - {{ $title }}</h6>

    @php
        $tableData = is_string($data) ? json_decode($data, true) : $data;
        $rows = $tableData['rows'] ?? [];

        // Convert rows array to keyed lookup
        $rowsMap = [];
        foreach ($rows as $row) {
            foreach ($row as $key => $value) {
                $rowsMap[$key] = $value;
            }
        }
    @endphp

    @if (!empty($tableData))
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50%">Aspek</th>
                        <th style="width: 15%" class="text-center">Ya</th>
                        <th style="width: 15%" class="text-center">Tidak</th>
                        <th style="width: 20%">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checklistItems as $item)
                        @php
                            $value = $rowsMap[$item['key']] ?? null;
                            $notes = $rowsMap[$item['key'] . '_notes'] ?? '-';
                        @endphp
                        <tr>
                            <td>{{ $item['label'] }}</td>
                            <td class="text-center">
                                @if ($value === 'yes')
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @else
                                    <i class="bi bi-circle text-muted"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($value === 'no')
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                @else
                                    <i class="bi bi-circle text-muted"></i>
                                @endif
                            </td>
                            <td class="small">{{ $notes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="small text-muted mt-2">
            <i class="bi bi-check-circle-fill text-success"></i> Ya
            <i class="bi bi-x-circle-fill text-danger ms-3"></i> Tidak
            <i class="bi bi-circle text-muted ms-3"></i> Belum diisi
        </div>
    @else
        <div class="alert alert-secondary small mb-0">
            <i class="bi bi-info-circle me-1"></i> Belum ada data untuk bagian ini.
        </div>
    @endif
</div>
