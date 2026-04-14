@extends('layouts.app')
@section('title', 'Edit Pengarang')

@section('content')
<div class="container-fluid">

  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.pengarang.index') }}" class="btn btn-outline-secondary btn-sm">
      <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
    </a>
    <h5 class="fw-bold mb-0">Edit Pengarang</h5>
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

      <form method="POST" action="{{ route('admin.pengarang.update', $pengarang->id) }}">
        @csrf @method('PUT')
        <div class="mb-4" style="max-width:400px">
          <label class="form-label">Nama Pengarang</label>
          <input type="text" name="nama_pengarang"
                 class="form-control @error('nama_pengarang') is-invalid @enderror"
                 value="{{ old('nama_pengarang', $pengarang->nama_pengarang) }}" required>
          @error('nama_pengarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">
          <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>Update
        </button>
        <a href="{{ route('admin.pengarang.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
      </form>
    </div>
  </div>

</div>
@endsection