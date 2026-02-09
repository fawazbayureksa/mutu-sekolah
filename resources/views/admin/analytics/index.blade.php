@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0 text-gray-800">Analytics</h1>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                    Data Released</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_released'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-database fa-2x text-gray-300 fs-2 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total
                                    Sekolah</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_schools'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-building fa-2x text-gray-300 fs-2 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jenis
                                    Instrumen</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['by_instrument']->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-clipboard-data fa-2x text-gray-300 fs-2 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- By Instrument Stats -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data per Instrumen</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Instrumen</th>
                                <th>Jumlah Submission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stats['by_instrument'] as $instrumentData)
                                <tr>
                                    <td>{{ $instrumentData->instrument->name ?? '-' }}</td>
                                    <td>{{ $instrumentData->count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Released -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Terbaru yang Dirilis</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sekolah</th>
                                <th>Instrumen</th>
                                <th>Tanggal Release</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentReleased as $submission)
                                <tr>
                                    <td>{{ $submission->school->school_name ?? '-' }}</td>
                                    <td>{{ $submission->instrument->name ?? '-' }}</td>
                                    <td>{{ $submission->released_at ? $submission->released_at->format('d M Y H:i') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
