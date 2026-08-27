@extends('layouts.admin')

@section('title', 'Tata Kelola (Aspek C) - Dashboard Mutu SMK')

@section('content')
    <div class="container-fluid px-0">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <div>
                <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Pemetaan Mutu Pendidikan Vokasi — Aspek Tata Kelola</h3>
                <p class="text-muted small mb-0">Analisis menyeluruh Kerja Sama Industri, Teaching Factory (TEFA), Pelatihan Guru, & Rasio Ketenagaan</p>
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
        <x-dashboard.filter-bar :action="route('admin.dashboard.tata-kelola.index')" :provinces="$provinces" :regencies="$regencies" :expertises="$expertises"
            :years="$years" :filters="$filters" />

        {{-- 4 Primary KPI Summary Cards --}}
        @include('admin.dashboard.tata-kelola.kpi-cards')

        {{-- PILAR I: KERJA SAMA INDUSTRI (C.1.1) --}}
        @include('admin.dashboard.tata-kelola.kerja-sama-industri')

        {{-- PILAR II: TEACHING FACTORY (TEFA) / UNIT PRODUKSI (C.2.1) --}}
        @include('admin.dashboard.tata-kelola.teaching-factory')

        {{-- PILAR III: DATA PELATIHAN & SERTIFIKASI GURU PRODUKTIF (C.3.1 & C.3.2) --}}
        @include('admin.dashboard.tata-kelola.pelatihan-guru')

        {{-- PILAR IV: KETENAGAAN & BEBAN MENGAJAR (RASIO GURU-MURID) (C.3.3) --}}
        @include('admin.dashboard.tata-kelola.ketenagaan-rasio')
    </div>
@endsection
