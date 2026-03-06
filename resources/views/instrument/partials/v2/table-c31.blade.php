@php
    $existingData = $existingData ?? [];
    if (is_string($existingData)) {
        $existingData = json_decode($existingData, true) ?? [];
    }
    $rows = $existingData['rows'] ?? [];
    $rowCount = max(2, count($rows));
@endphp

{{-- Table C.3.1: Data Pelatihan dan Sertifikasi Guru yang Telah Diikuti (Dynamic Rows) --}}
<div class="card table-card">
    <div class="card-body p-0">
        @php
            $initialValue = old('answers[C.3.1]');
            if (is_null($initialValue) && !empty($existingData)) {
                $initialValue = json_encode($existingData);
            }
        @endphp
        <input type="hidden" name="answers[C.3.1]" id="table-c31-input" value="{{ $initialValue ?? '{}' }}">

        <div class="table-responsive">
            <table class="table instrument-table table-sm-header mb-0" id="table-c31">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran/Keahlian</th>
                        <th>Jenis Pelatihan/Sertifikasi</th>
                        <th>Judul Pelatihan/Sertifikasi</th>
                        <th>Tahun (Kegiatan)</th>
                        <th>Penyedia (Industri/Lembaga)</th>
                        <th>Durasi Pelatihan (Jam/Hari)</th>
                        <th>Bukti/Dokumen</th>
                        <th>Keterangan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $rowCount; $i++)
                        @php
                            $rowData = $rows[$i] ?? [];
                        @endphp
                        <tr data-row="{{ $i }}">
                            <td class="text-center row-number">{{ $i + 1 }}</td>
                            {{-- Nama Guru --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="teacher_name" data-row="{{ $i }}" placeholder="Nama guru"
                                    value="{{ $rowData['teacher_name'] ?? '' }}">
                            </td>
                            {{-- Mata Pelajaran/Keahlian --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="subject" data-row="{{ $i }}"
                                    placeholder="Mata pelajaran/keahlian" value="{{ $rowData['subject'] ?? '' }}">
                            </td>
                            {{-- Jenis Pengembangan Kompetensi (Checkboxes) --}}
                            <td>
                                <select class="form-select form-select-sm table-input" data-key="competency_type"
                                    data-row="{{ $i }}">
                                    <option value="">Pilih</option>
                                    @foreach (config('constant.jenis_pengembangan_kompetensi') as $type)
                                        <option value="{{ $type }}"
                                            {{ ($rowData['competency_type'] ?? '') === $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            {{-- Judul Pelatihan/Sertifikasi --}}
                            <td>
                                <textarea class="form-control form-control-sm table-input" data-key="training_title" data-row="{{ $i }}"
                                    rows="2" placeholder="Judul pelatihan/sertifikasi yang diikuti">{{ $rowData['training_title'] ?? '' }}</textarea>
                            </td>
                            {{-- Tahun --}}
                            <td>
                                <input type="number" class="form-control form-control-sm table-input" data-key="year"
                                    data-row="{{ $i }}" placeholder="2024" min="2000" max="2100"
                                    value="{{ $rowData['year'] ?? '' }}">
                            </td>
                            {{-- Penyedia --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="provider" data-row="{{ $i }}"
                                    placeholder="Nama industri/lembaga penyedia"
                                    value="{{ $rowData['provider'] ?? '' }}">
                            </td>
                            {{-- Durasi Pelatihan --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="duration" data-row="{{ $i }}" placeholder="Contoh: 40 jam"
                                    value="{{ $rowData['duration'] ?? '' }}">
                            </td>
                            {{-- Bukti/Dokumen --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="evidence" data-row="{{ $i }}"
                                    placeholder="Sertifikat, SK, dll" value="{{ $rowData['evidence'] ?? '' }}">
                            </td>
                            {{-- Keterangan --}}
                            <td>
                                <input type="text" class="form-control form-control-sm table-input"
                                    data-key="remarks" data-row="{{ $i }}" placeholder="Keterangan"
                                    value="{{ $rowData['remarks'] ?? '' }}">
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
            <button type="button" class="btn btn-add-row" data-table-id="table-c31">
                <i class="bi bi-plus-circle me-2"></i>Tambah Data Guru
            </button>
        </div>
    </div>
</div>
