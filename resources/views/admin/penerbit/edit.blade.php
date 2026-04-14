@extends('layouts.app')
@section('title', 'Edit Penerbit')

@section('content')
<div class="container-fluid">

  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.penerbit.index') }}" class="btn btn-outline-secondary btn-sm">
      <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
    </a>
    <h5 class="fw-bold mb-0">Edit Penerbit</h5>
  </div>

  <div class="card">
    <div class="card-body">
      @if($errors->any())
      <div class="alert alert-danger py-2">
        <ul class="mb-0 ps-3">
          @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('admin.penerbit.update', $penerbit->id) }}">
        @csrf @method('PUT')
        <div class="mb-4" style="max-width:400px">
          <label class="form-label">Nama Penerbit</label>
          <input type="text" name="nama_penerbit"
                 class="form-control @error('nama_penerbit') is-invalid @enderror"
                 value="{{ old('nama_penerbit', $penerbit->nama_penerbit) }}" required>
          @error('nama_penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">
          <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>Update
        </button>
        <a href="{{ route('admin.penerbit.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
      </form>
    </div>
  </div>

</div>
@endsection