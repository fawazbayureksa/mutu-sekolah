@extends('layouts.admin')

@section('title', 'Data Pengajuan')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0 text-gray-800">Data Pengajuan</h1>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Pengajuan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sekolah</th>
                                <th>Instrumen</th>
                                <th>Responden</th>
                                <th>Tanggal Isi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->school->school_name ?? '-' }}</td>
                                    <td>{{ $submission->instrument->name ?? '-' }}</td>
                                    <td>
                                        <div>{{ $submission->respondent_name }}</div>
                                        <small class="text-muted">{{ $submission->respondent_position }}</small>
                                    </td>
                                    <td>{{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $submission->status === 'submitted' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.submissions.show', $submission) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data submission</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $submissions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
