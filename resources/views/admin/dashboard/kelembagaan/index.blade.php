@extends('layouts.admin')

@section('title', 'Sekolah - Dashboard Mutu SMK')

@section('content')
    <div class="container-fluid px-0">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <div>
                <h2 class="h3 fw-bold mb-1 text-dark">Sekolah</h2>
                <p class="text-muted mb-0">Direktori sekolah, data identitas, dan sebaran struktur keahlian kejuruan.</p>
            </div>
            <div>
                <span class="badge bg-light text-dark border px-3 py-2">
                    <i class="bi bi-buildings me-1 text-primary"></i> Data Induk Sekolah
                </span>
            </div>
        </div>

        {{-- Stats Bar --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-lg-3">
                <x-dashboard.kpi-card title="Total Sekolah Terdata" :value="$stats['total_sekolah']" icon="bi-building" variant="default" />
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <x-dashboard.kpi-card title="Provinsi Tercakup" :value="$stats['total_provinsi']" icon="bi-geo-alt" variant="default" />
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <x-dashboard.kpi-card title="Bidang Keahlian" :value="$stats['total_bidang']" icon="bi-diagram-3" variant="default" />
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <x-dashboard.kpi-card title="Konsentrasi Keahlian" :value="$stats['total_konsentrasi']" icon="bi-layers" variant="default" />
            </div>
        </div>

        {{-- Filter Bar --}}
        <x-dashboard.filter-bar :action="route('admin.dashboard.kelembagaan.index')" :provinces="$provinces" :regencies="$regencies" :expertises="$expertises" :years="$years"
            :filters="$filters" :showSearch="true" searchPlaceholder="Cari nama sekolah / NPSN / alamat..." />

        {{-- School Directory Table --}}
        <x-dashboard.section-card title="Sekolah & Pengajuan Asesmen" :subtitle="'Menampilkan ' .
            $schools->firstItem() .
            ' - ' .
            $schools->lastItem() .
            ' dari ' .
            $schools->total() .
            ' sekolah'">
            @if ($schools->isEmpty())
                <x-dashboard.empty-state message="Tidak ditemukan data sekolah yang sesuai."
                    hint="Silakan coba ubah kata kunci pencarian atau sesuaikan filter wilayah." />
            @else
                <x-dashboard.data-table>
                    <x-slot:thead>
                        <tr>
                            <th style="width: 50px;" class="text-center">#</th>
                            <th>Nama Sekolah</th>
                            <th>NPSN</th>
                            <th>Wilayah</th>
                            <th>Status</th>
                            <th>Akreditasi</th>
                            <th class="text-center">Pengajuan</th>
                            <th class="text-end" style="width: 120px;">Aksi</th>
                        </tr>
                    </x-slot:thead>

                    @foreach ($schools as $index => $school)
                        <tr>
                            <td class="text-center text-muted small">
                                {{ $schools->firstItem() + $index }}
                            </td>
                            <td>
                                <a href="{{ route('admin.dashboard.kelembagaan.show', $school) }}"
                                    class="fw-bold text-dark text-decoration-none hover-primary">
                                    {{ $school->school_name }}
                                </a>
                                @if ($school->address)
                                    <small class="text-muted d-block text-truncate" style="max-width: 280px;"
                                        title="{{ $school->address }}">
                                        {{ $school->address }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <code class="text-dark bg-light px-2 py-1 rounded small">{{ $school->npsn ?: '-' }}</code>
                            </td>
                            <td>
                                <span class="d-block small fw-medium">{{ $school->province->name ?? '-' }}</span>
                                <small class="text-muted">{{ $school->regency->name ?? '-' }}</small>
                            </td>
                            <td>
                                @if ($school->school_status)
                                    <span
                                        class="badge {{ strtolower($school->school_status) === 'negeri' ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ ucfirst($school->school_status) }}
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($school->school_accreditation)
                                    @php
                                        $accColors = [
                                            'A' => 'bg-success',
                                            'B' => 'bg-info',
                                            'C' => 'bg-warning text-dark',
                                        ];
                                        $accColor = $accColors[$school->school_accreditation] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $accColor }}">
                                        {{ $school->school_accreditation }}
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($school->instrument_submissions_v2_count > 0)
                                    <span class="badge bg-primary rounded-pill px-3 py-1">
                                        {{ $school->instrument_submissions_v2_count }} Asesmen
                                    </span>
                                @else
                                    <span class="badge bg-light text-muted border px-2 py-1">
                                        0 Asesmen
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.dashboard.kelembagaan.show', $school) }}"
                                    class="btn btn-sm btn-outline-primary" title="Lihat Profil & Struktur Kejuruan">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-dashboard.data-table>

                @if ($schools->hasPages())
                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted">
                            Halaman {{ $schools->currentPage() }} dari {{ $schools->lastPage() }}
                        </small>
                        {{ $schools->links() }}
                    </div>
                @endif
            @endif
        </x-dashboard.section-card>
    </div>
@endsection
