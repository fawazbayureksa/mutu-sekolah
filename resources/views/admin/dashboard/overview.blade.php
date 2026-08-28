@extends('layouts.admin')

@section('title', 'Overview - Dashboard Mutu SMK')

@section('content')
    <div class="container-fluid px-0">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <div>
                <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Overview</h3>
            </div>
        </div>

        {{-- Global Filter Bar --}}
        <x-dashboard.filter-bar :action="route('admin.dashboard.overview')" :provinces="$provinces" :regencies="$regencies" :expertises="$expertises" :years="$years"
            :filters="$filters" />

        {{-- ROW 1: 4 Primary KPI Cards --}}
        @include('admin.dashboard.overview.kpi-cards')

        {{-- ROW 2: Distribusi Pengajuan per Bidang Keahlian (Donut Chart + Breakdown) --}}
        @include('admin.dashboard.overview.expertise-distribution')

        {{-- ROW 3: 3 Indikator Capaian Mutu Aspek (A, B, C) --}}
        @include('admin.dashboard.overview.aspect-indicators')

        {{-- ROW 4: Prioritas Perhatian & Data Cakupan --}}
        @include('admin.dashboard.overview.priority-coverage')
    </div>
@endsection

@push('scripts')
    {{-- Load Chart.js from CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Expertise Donut Chart
            const donutCtx = document.getElementById('expertiseDonutChart');
            if (donutCtx) {
                const donutLabels = {!! json_encode($expertiseDist->pluck('expertise')) !!};
                const donutData = {!! json_encode($expertiseDist->pluck('total_submissions')) !!};
                const donutColors = [
                    '#0e4a66',
                    '#1e6080',
                    '#2d789a',
                    '#418ea9',
                    '#5ea6c2',
                    '#82bfd9',
                    '#aad6ec',
                    '#cbd5e1'
                ];

                new Chart(donutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: donutLabels,
                        datasets: [{
                            data: donutData,
                            backgroundColor: donutColors.slice(0, donutLabels.length),
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return ` ${context.label}: ${context.raw} Pengajuan`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
