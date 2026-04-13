@extends('layouts.app')
@section('title', 'Tambah Anggota')

@section('content')
<div class="container-fluid">

  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary btn-sm">
      <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
    </a>
    <h5 class="fw-bold mb-0">Tambah Anggota</h5>
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

      <form method="POST" action="{{ route('admin.anggota.store') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="nama"
                 class="form-control @error('nama') is-invalid @enderror"
                 value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
          @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email"
                 class="form-control @error('email') is-invalid @enderror"
                 value="{{ old('email') }}" placeholder="nama@email.com" required>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Kelas <span class="text-muted small">(opsional)</span></label>
          <select name="kelas_id" class="form-select">
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelas as $k)
            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
              {{ $k->nama_kelas }}
            </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password"
                 class="form-control @error('password') is-invalid @enderror"
                 placeholder="Minimal 6 karakter" required>
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
          <label class="form-label">Konfirmasi Password</label>
          <input type="password" name="password_confirmation"
                 class="form-control" placeholder="Ulangi password" required>
        </div>

        <button type="submit" class="btn btn-primary">
          <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>
          Simpan
        </button>
        <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
      </form>

    </div>
  </div>

</div>
@endsection