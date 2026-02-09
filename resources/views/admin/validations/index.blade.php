@extends('layouts.admin')

@section('title', 'Validasi Data')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0 text-gray-800">Validasi Data</h1>
            </div>
            <div class="col-md-6 text-end">
                <div class="btn-group">
                    <a href="{{ route('admin.validations.index', ['status' => 'verified']) }}"
                        class="btn btn-{{ $status === 'verified' ? 'success' : 'outline-success' }}">
                        Menunggu Validasi
                    </a>
                    <a href="{{ route('admin.validations.index', ['status' => 'validated']) }}"
                        class="btn btn-{{ $status === 'validated' ? 'primary' : 'outline-primary' }}">
                        Validasi Selesai
                    </a>
                    <a href="{{ route('admin.validations.index', ['status' => 'released']) }}"
                        class="btn btn-{{ $status === 'released' ? 'info' : 'outline-info' }}">
                        Released
                    </a>
                </div>
            </div>
        </div>

        @if($status === 'validated')
            <form action="{{ route('admin.validations.bulk-release') }}" method="POST" class="mb-3">
                @csrf
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-broadcast"></i> Bulk Release Selected
                    </button>
                    <small class="text-muted">Pilih submission yang ingin dirilis</small>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List Validasi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @if($status === 'validated')
                                        <th><input type="checkbox" id="selectAll"></th>
                                    @endif
                                    <th>Sekolah</th>
                                    <th>Instrumen</th>
                                    <th>Diverifikasi Oleh</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissions as $submission)
                                    <tr>
                                        @if($status === 'validated')
                                            <td><input type="checkbox" name="submission_ids[]" value="{{ $submission->id }}"></td>
                                        @endif
                                        <td>{{ $submission->school->school_name ?? '-' }}</td>
                                        <td>{{ $submission->instrument->name ?? '-' }}</td>
                                        <td>{{ $submission->verifier->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $submission->status === 'verified' ? 'success' : ($submission->status === 'validated' ? 'primary' : 'info') }}">
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.validations.show', $submission) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $status === 'validated' ? '6' : '5' }}" class="text-center">Belum
                                            ada data</td>
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
            @if($status === 'validated')
            </form>
        @endif
    </div>

    <script>
        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="submission_ids[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection
