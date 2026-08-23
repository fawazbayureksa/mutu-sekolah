@extends('layouts.admin')

@section('title', 'Sarana Prasarana - Dashboard Mutu SMK')

@section('content')
    <div class="container-fluid px-0">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <div>
                <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Sarana & Prasarana</h3>
            </div>
            @if (!empty($filters['expertise']))
                <div>
                    <span class="badge bg-light text-secondary border px-3 py-2">
                        <i class="bi bi-layers me-1"></i> Bidang: <strong class="text-dark">{{ $filters['expertise'] }}</strong>
                    </span>
                </div>
            @endif
        </div>

        {{-- Global Filter Bar --}}
        <x-dashboard.filter-bar :action="route('admin.dashboard.sarana-prasarana.index')" :provinces="$provinces" :regencies="$regencies" :expertises="$expertises"
            :concentrations="$concentrations" :years="$years" :filters="$filters" />

        {{-- ROW 1: 4 Primary KPI Cards --}}
        @include('admin.dashboard.sarana-prasarana.kpi-cards')

        {{-- ROW 2: Pemetaan Detail Sarpras Konsentrasi Terpilih (col-12) --}}
        @include('admin.dashboard.sarana-prasarana.concentration-detail')

        {{-- ROW 3: Matriks Perbandingan Komprehensif Antar Konsentrasi (col-12) --}}
        @include('admin.dashboard.sarana-prasarana.comparison-matrix')

        {{-- ROW 4: Prioritas Perhatian Aspek Sarana & Prasarana (col-12) --}}
        @include('admin.dashboard.sarana-prasarana.priority-coverage')

        {{-- ROW 5: Katalog Standar Sarpras Permendikbud & SKKNI (col-12) --}}
        @include('admin.dashboard.sarana-prasarana.standards-catalog')
    </div>
@endsection
