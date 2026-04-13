@extends('layouts.app')
@section('title', 'Tambah Buku')

@section('content')
<div class="container-fluid">

  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary btn-sm">
      <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
    </a>
    <h5 class="fw-bold mb-0">Tambah Buku</h5>
  </div>

  <div class="card">
    <div class="card-body">

      @if($errors->any())
      <div class="alert alert-danger py-2">
        <ul class="mb-0 ps-3">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('admin.buku.store') }}">
        @csrf

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Judul Buku</label>
            <input type="text" name="judul"
                   class="form-control @error('judul') is-invalid @enderror"
                   value="{{ old('judul') }}" placeholder="Masukkan judul buku" required>
            @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Penulis</label>
            <input type="text" name="penulis"
                   class="form-control @error('penulis') is-invalid @enderror"
                   value="{{ old('penulis') }}" placeholder="Nama penulis" required>
            @error('penulis') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Penerbit <span class="text-muted small">(opsional)</span></label>
            <input type="text" name="penerbit"
                   class="form-control @error('penerbit') is-invalid @enderror"
                   value="{{ old('penerbit') }}" placeholder="Nama penerbit">
            @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-3">
            <label class="form-label">Tahun Terbit <span class="text-muted small">(opsional)</span></label>
            <input type="number" name="tahun"
                   class="form-control @error('tahun') is-invalid @enderror"
                   value="{{ old('tahun') }}" placeholder="{{ date('Y') }}"
                   min="1900" max="{{ date('Y') }}">
            @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok"
                   class="form-control @error('stok') is-invalid @enderror"
                   value="{{ old('stok', 0) }}" min="0" required>
            @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>
            Simpan
          </button>
          <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
        </div>
      </form>

    </div>
  </div>

</div>
@endsection