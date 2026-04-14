@extends('layouts.app')
@section('title', 'Edit Rak')

@section('content')
<div class="container-fluid">

  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.rak.index') }}" class="btn btn-outline-secondary btn-sm">
      <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
    </a>
    <h5 class="fw-bold mb-0">Edit Rak</h5>
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

      <form method="POST" action="{{ route('admin.rak.update', $rak->id) }}">
        @csrf @method('PUT')

        <div class="row g-3" style="max-width:600px">
          <div class="col-12">
            <label class="form-label">Nama Rak</label>
            <input type="text" name="nama_rak"
                   class="form-control @error('nama_rak') is-invalid @enderror"
                   value="{{ old('nama_rak', $rak->nama_rak) }}" required>
            @error('nama_rak') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-12">
            <label class="form-label">Lokasi</label>
            <input type="text" name="lokasi"
                   class="form-control @error('lokasi') is-invalid @enderror"
                   value="{{ old('lokasi', $rak->lokasi) }}">
            @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>
            Update
          </button>
          <a href="{{ route('admin.rak.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
        </div>
      </form>

    </div>
  </div>

</div>
@endsection