@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(3, count($rows));

    $samplePlaceholders = [
        0 => [
            'year' => '2024/2025',
            'label' => 'UKK (Uji Kompetensi Keahlian)',
            'total_participants' => 32,
            'total_passed' => 32,
            'organizer' => 'SMK Negeri 3 Pacitan (bekerja sama dengan mitra industri "Srikandi Ce\'eS")',
            'description' =>
                'Uji kompetensi mandiri dengan penguji internal dan eksternal dari dunia industri. Materi: Pembuatan surimi dan bakso ikan.',
        ],
        1 => [
            'year' => '2024/2025',
            'label' => 'Sertifikasi Kompetensi Ahli Pengolahan Rumput Laut',
            'total_participants' => 25,
            'total_passed' => 25,
            'organizer' => 'LSP Kelautan dan Perikanan (LSP-KP)',
            'description' =>
                'Skema sertifikasi yang diakui BNSP. Diikuti oleh siswa yang telah menyelesaikan UKK dengan nilai memuaskan.',
        ],
        2 => [
            'year' => '2024/2025',
            'label' => 'Sertifikasi Kompetensi Ahli Budidaya Rumput Laut',
            'total_participants' => 20,
            'total_passed' => 20,
            'organizer' => 'LSP Kelautan dan Perikanan (LSP-KP)',
            'description' =>
                'Skema sertifikasi yang diakui BNSP. Diikuti siswa yang mengambil mata pelajaran budidaya rumput laut.',
        ],
    ];
    $defaultPlaceholder = [
        'year' => 'Contoh: 2024/2025',
        'label' => 'Nama Ujian/Sertifikasi',
        'total_participants' => 0,
        'total_passed' => 0,
        'organizer' => 'Nama lembaga penyelenggara',
        'description' => 'Keterangan tambahan',
    ];
@endphp

{{-- Table A.1.1: Data Kelulusan Uji Kompetensi dan Sertifikasi --}}
<div class="card table-card">
    <div class="card-body p-0">
        @php
            $initialValue = old('answers.A.1.1');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData, true);
            }
        @endphp
        <input type="hidden" name="answers[A.1.1]" id="table-a11-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table mb-0" id="table-a11">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 15%; white-space: normal;">Tahun Ajaran</th>
                        <th style="width: 50%; white-space: normal;">Jenis Ujian/Sertifikasi</th>
                        <th style="width: 10%; white-space: normal;">Jumlah Peserta</th>
                        <th style="width: 10%; white-space: normal;">Jumlah Lulus</th>
                        <th style="width: 10%; white-space: normal;">Tingkat Kelulusan (%)</th>
                        <th style="width: 10%; white-space: normal;">Lembaga Penyelenggara/Penguji</th>
                        <th style="width: 10%; white-space: normal;">Keterangan</th>
                        <th style="width: 10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $rowCount; $i++)
                        @php
                            $rowData = $rows[$i] ?? [];
                            $ph = $samplePlaceholders[$i] ?? $defaultPlaceholder;
                        @endphp
                        <tr data-row="{{ $i }}">
                            <td class="text-center row-number">{{ $i + 1 }}</td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input" data-key="year"
                                    data-row="{{ $i }}" placeholder="{{ $ph['year'] }}"
                                    value="{{ $rowData['year'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input" data-key="label"
                                    data-row="{{ $i }}" placeholder="{{ $ph['label'] }}"
                                    value="{{ $rowData['label'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="total_participants" data-row="{{ $i }}"
                                    placeholder="{{ $ph['total_participants'] }}" min="0"
                                    value="{{ $rowData['total_participants'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm table-input"
                                    data-key="total_passed" data-row="{{ $i }}"
                                    placeholder="{{ $ph['total_passed'] }}" min="0"
                                    value="{{ $rowData['total_passed'] ?? '' }}">
                            </td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control table-input bg-light" data-key="pass_rate"
                                        data-row="{{ $i }}" placeholder="0.00" readonly
                                        value="{{ $rowData['pass_rate'] ?? '' }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="organizer" data-row="{{ $i }}"
                                    placeholder="{{ $ph['organizer'] }}" value="{{ $rowData['organizer'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="description" data-row="{{ $i }}"
                                    placeholder="{{ $ph['description'] }}"
                                    value="{{ $rowData['description'] ?? '' }}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-remove-row" title="Hapus baris">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        {{-- Add Row Button --}}
        <div class="p-3 text-center border-top">
            <button type="button" class="btn btn-add-row" data-table-id="table-a11">
                <i class="bi bi-plus-circle me-2"></i>Tambah Item
            </button>
        </div>
    </div>
</div>
