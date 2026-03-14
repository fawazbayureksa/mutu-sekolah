{{--
    Section Table Partial
    Variables:
    - $code: Section code (e.g., 'A.1.1')
    - $title: Section title
    - $data: Object with {header: {}, rows: []}
    - $columns: Array of column definitions
    - $staticRows: Optional array of static row labels
    - $dynamicRows: Boolean, if rows can be dynamic
    - $headerFields: Optional array of header field definitions
--}}
<div class="section-block mb-4">
    <h6 class="fw-bold mb-3">{{ $code }} - {{ $title }}</h6>

    @php
        $tableData = is_string($data) ? json_decode($data, true) : $data;
        $header = $tableData['header'] ?? [];
        $rows = $tableData['rows'] ?? [];
    @endphp

    @if (!empty($tableData))
        {{-- Show header info if available --}}
        @if (!empty($header))
            <div class="bg-light p-2 rounded mb-2 small">
                @foreach ($header as $key => $value)
                    @if (!empty($value))
                        <span class="me-3">
                            <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}
                        </span>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-sm" style="min-width: 700px;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px; white-space: nowrap;">No</th>
                        @if (isset($staticRows) && !empty($staticRows))
                            <th style="white-space: nowrap;">Nama</th>
                        @endif
                        @foreach ($columns as $col)
                            <th style="white-space: nowrap;">{{ $col['label'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if (isset($staticRows) && !empty($staticRows))
                        {{-- Static rows with predefined labels --}}
                        @foreach ($staticRows as $idx => $rowLabel)
                            @php
                                $rowData = $rows[$idx] ?? [];
                            @endphp
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td>{{ $rowLabel }}</td>
                                @foreach ($columns as $col)
                                    <td>{{ $rowData[$col['key']] ?? '-' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @elseif(!empty($rows))
                        {{-- Dynamic rows --}}
                        @foreach ($rows as $idx => $row)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                @foreach ($columns as $col)
                                    <td>
                                        @if (($col['type'] ?? '') === 'boolean')
                                            @if (!empty($row[$col['key']]))
                                                <span class="text-success fw-bold">✓</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        @else
                                            {{ $row[$col['key']] ?? '-' }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ count($columns) + 1 + (isset($staticRows) ? 1 : 0) }}"
                                class="text-center text-muted py-3">
                                <i class="bi bi-inbox me-1"></i> Tidak ada data
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-secondary small mb-0">
            <i class="bi bi-info-circle me-1"></i> Belum ada data untuk bagian ini.
        </div>
    @endif
</div>
