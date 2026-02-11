@extends('verifier.layouts.verifier')

@section('title', 'Submissions')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0 text-gray-800">Submissions</h1>
            </div>
            <div class="col-md-6 text-end">
                <div class="btn-group">
                    <a href="{{ route('verifier.submissions.index', ['status' => 'pending']) }}"
                        class="btn btn-{{ $status === 'pending' ? 'primary' : 'outline-primary' }}">
                        Menunggu Verifikasi
                    </a>
                    <a href="{{ route('verifier.submissions.index', ['status' => 'verified']) }}"
                        class="btn btn-{{ $status === 'verified' ? 'success' : 'outline-success' }}">
                        Diverifikasi
                    </a>
                    <a href="{{ route('verifier.submissions.index', ['status' => 'rejected']) }}"
                        class="btn btn-{{ $status === 'rejected' ? 'danger' : 'outline-danger' }}">
                        Ditolak
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Submissions</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sekolah</th>
                                <th>Instrumen</th>
                                <th>Responden</th>
                                <th>Tanggal Isi</th>
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
                                        <a href="{{ route('verifier.submissions.show', $submission) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada submission</td>
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
