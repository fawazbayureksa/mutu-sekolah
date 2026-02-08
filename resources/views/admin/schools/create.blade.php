@extends('layouts.admin')

@section('title', 'Tambah Sekolah - Panel Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Tambah Sekolah</h2>
        <p class="text-muted mb-0">Tambahkan data sekolah baru ke dalam sistem</p>
    </div>
    <a href="{{ route('admin.schools.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Formulir Sekolah</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.schools.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="school_name" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('school_name') is-invalid @enderror"
                            id="school_name" name="school_name"
                            value="{{ old('school_name') }}"
                            placeholder="Masukkan nama sekolah" required>
                        @error('school_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="npsn" class="form-label">NPSN <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('npsn') is-invalid @enderror"
                            id="npsn" name="npsn"
                            value="{{ old('npsn') }}"
                            placeholder="Masukkan NPSN" required>
                        @error('npsn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="province" class="form-label">Provinsi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('province') is-invalid @enderror"
                            id="province" name="province"
                            value="{{ old('province') }}"
                            placeholder="Masukkan nama provinsi" required>
                        @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                            id="city" name="city"
                            value="{{ old('city') }}"
                            placeholder="Masukkan nama kota/kabupaten" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Simpan Sekolah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
