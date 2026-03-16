{{--
    section-sapras.blade.php
    Variables:
      $code  - section code, e.g. 'B.sapras'
      $title - section title
      $data  - decoded value of answers['B.sapras'] (array or null)
--}}

@php
    // Normalise: $data may arrive as a JSON string (from the DB cast) or already decoded
    if (is_string($data)) {
        $data = json_decode($data, true);
    }

    $sections = $data['sections'] ?? [];
@endphp

<div class="mb-4">
    <h6 class="fw-bold text-secondary mb-1">
        <span class="badge bg-secondary me-2">{{ $code }}</span>
        {{ $title }}
    </h6>

    @if (empty($sections))
        <div class="text-muted fst-italic small ps-2">Tidak ada data sarana prasarana yang diisi.</div>
    @else
        @foreach ($sections as $si => $section)
            <div class="mb-3">
                <p class="fw-semibold mb-1 small">
                    <span class="badge bg-light text-dark border me-1">B.{{ $si + 1 }}</span>
                    {{ $section['title'] ?? 'Bagian ' . ($si + 1) }}
                </p>

                @php
                    $rows = $section['rows'] ?? [];
                @endphp

                @if (empty($rows))
                    <div class="text-muted fst-italic small ps-3">– Tidak ada baris data.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0 small" style="min-width: 650px;">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:4%; white-space: nowrap; font-size: 0.75rem;">#</th>
                                    <th style="white-space: nowrap; font-size: 0.75rem;">Nama Item</th>
                                    @php
                                        // Detect columns from the first row
                                        $firstRow = $rows[0];
                                        $fieldKeys = array_keys(array_diff_key($firstRow, ['name' => '']));
                                        $labelMap = [
                                            'qty_available' => 'Jumlah Tersedia',
                                            'condition' => 'Kondisi',
                                            'industry_standard' => 'Kesesuaian Standar Industri',
                                            'document' => 'Dokumen Pendukung',
                                            'remarks' => 'Keterangan',
                                            'actual_area' => 'Luas Tersedia (m²)',
                                            'available' => 'Ada/Tidak',
                                            'compliance' => 'Kesesuaian',
                                            'status' => 'Status',
                                            'age' => 'Usia',
                                            'source' => 'Sumber',
                                            'spec' => 'Spesifikasi',
                                        ];
                                    @endphp
                                    @foreach ($fieldKeys as $fk)
                                        <th style="white-space: nowrap; font-size: 0.75rem;">
                                            {{ $labelMap[$fk] ?? ucwords(str_replace('_', ' ', $fk)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $ri => $row)
                                    <tr>
                                        <td class="text-center text-muted">{{ $ri + 1 }}</td>
                                        <td>{{ $row['name'] ?? '-' }}</td>
                                        @foreach ($fieldKeys as $fk)
                                            @php $val = $row[$fk] ?? ''; @endphp
                                            <td>
                                                @if ($val === '' || $val === null)
                                                    <span class="text-muted">–</span>
                                                @elseif (in_array($val, ['Baik', 'Ya', 'Ada']))
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success">{{ $val }}</span>
                                                @elseif (in_array($val, ['Rusak', 'Tidak']))
                                                    <span
                                                        class="badge bg-danger-subtle text-danger border border-danger">{{ $val }}</span>
                                                @elseif ($val === 'Sebagian')
                                                    <span
                                                        class="badge bg-warning-subtle text-warning border border-warning">{{ $val }}</span>
                                                @elseif (filter_var($val, FILTER_VALIDATE_URL))
                                                    <a href="{{ $val }}" target="_blank"
                                                        class="text-truncate d-inline-block" style="max-width:120px">
                                                        <i class="bi bi-link-45deg me-1"></i>Lihat
                                                    </a>
                                                @else
                                                    {{ $val }}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>
