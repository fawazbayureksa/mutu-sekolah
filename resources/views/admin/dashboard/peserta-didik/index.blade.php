@extends('layouts.admin')

@section('title', 'Mutu Peserta Didik - Kategori Keahlian - Dashboard Mutu SMK')

@section('content')
    <div class="container-fluid px-0">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <div>
                <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Mutu Peserta Didik</h3>
            </div>

            @if (!empty($filters['expertise']))
                <div>
                    <span class="badge bg-light text-secondary border px-3 py-2 font-monospace" style="font-size: 0.75rem;">
                        Bidang: <strong>{{ $filters['expertise'] }}</strong>
                    </span>
                </div>
            @endif
        </div>

        {{-- Global Filter Bar --}}
        <x-dashboard.filter-bar :action="route('admin.dashboard.peserta-didik.index')" :provinces="$provinces" :regencies="$regencies" :expertises="$expertises"
            :years="$years" :filters="$filters" />

        {{-- 4 Primary Summary Metric Cards --}}
        @include('admin.dashboard.peserta-didik.kpi-cards')

        {{-- 1. DATA KOMPETENSI (UKK, Skema, Jenjang KKNI, Kesesuaian SKKNI) --}}
        @include('admin.dashboard.peserta-didik.data-kompetensi')

        {{-- 2. PENELUSURAN ALUMNI (TRACER STUDY & SERAPAN KERJA) --}}
        @include('admin.dashboard.peserta-didik.tracer-study')

        {{-- 3. DATA PUTUS SEKOLAH & KETIDAKNAIKAN KELAS --}}
        @include('admin.dashboard.peserta-didik.putus-sekolah')

        {{-- 4. DATA SKOR RATA-RATA TKA 2025 (GAP VS STANDAR NASIONAL) --}}
        @include('admin.dashboard.peserta-didik.skor-tka')

        {{-- 5. TABEL KOMPARASI CAPAIAN MUTU PER KATEGORI KEAHLIAN --}}
        @include('admin.dashboard.peserta-didik.breakdown-tables')
    </div>
@endsection

