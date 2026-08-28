@extends('layouts.admin')

@section('title', 'Sekolah - Dashboard Mutu SMK')

@section('content')
    <div class="container-fluid px-0">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <div>
                <h2 class="h3 fw-bold mb-1 text-dark">Informasi Kelembagaan</h2>
            </div>
            <div>
                <span class="badge bg-light text-secondary border px-3 py-2 font-monospace" style="font-size: 0.75rem;">
                    Data Induk Sekolah
                </span>
            </div>
        </div>

        {{-- Global Filter Bar --}}
        <x-dashboard.filter-bar :action="route('admin.dashboard.kelembagaan.index')" :provinces="$provinces" :regencies="$regencies" :expertises="$expertises" :years="$years"
            :filters="$filters" :showSearch="true" searchPlaceholder="Cari nama sekolah / NPSN / alamat..." />

        {{-- Stats Bar --}}
        @include('admin.dashboard.kelembagaan.kpi-cards')

        {{-- Row: Kategori Sekolah, Kurikulum, & Akreditasi --}}
        @include('admin.dashboard.kelembagaan.institutional-stats')
    </div>
@endsection
