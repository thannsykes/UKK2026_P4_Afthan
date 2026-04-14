@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h5 class="fw-bold mb-0">
            <iconify-icon icon="solar:tag-bold-duotone" class="text-primary me-1"></iconify-icon>
            Edit Kategori
        </h5>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.kategori.update', $kategori->id) }}">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-medium">Nama Kategori</label>
                    <input type="text" name="nama_kategori"
                           class="form-control @error('nama_kategori') is-invalid @enderror"
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}">
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection