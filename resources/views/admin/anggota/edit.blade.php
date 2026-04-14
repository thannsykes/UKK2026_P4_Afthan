@extends('layouts.app')
@section('title', 'Edit Anggota')

@section('content')
<div class="container-fluid">

  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary btn-sm">
      <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
    </a>
    <h5 class="fw-bold mb-0">Edit Anggota</h5>
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

      <form method="POST" action="{{ route('admin.anggota.update', $anggota->id) }}">
        @csrf @method('PUT')

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama"
                   class="form-control @error('nama') is-invalid @enderror"
                   value="{{ old('nama', $anggota->nama) }}" required>
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $anggota->email) }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">NIS <span class="text-muted small">(opsional)</span></label>
            <input type="text" name="nis"
                   class="form-control @error('nis') is-invalid @enderror"
                   value="{{ old('nis', $kelasAnggota?->nis) }}" placeholder="Nomor Induk Siswa">
            @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">No. Telepon <span class="text-muted small">(opsional)</span></label>
            <input type="text" name="no_telp"
                   class="form-control @error('no_telp') is-invalid @enderror"
                   value="{{ old('no_telp', $kelasAnggota?->no_telp) }}" placeholder="08xxxxxxxxxx">
            @error('no_telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select">
              <option value="">-- Pilih Kelas --</option>
              @foreach($kelas as $k)
              <option value="{{ $k->id }}"
                {{ old('kelas_id', $kelasAnggota?->kelas_id) == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kelas }}
              </option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
              <option value="aktif" {{ old('status', $kelasAnggota?->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
              <option value="tidak aktif" {{ old('status', $kelasAnggota?->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Password Baru <span class="text-muted small">(kosongkan jika tidak ingin mengubah)</span></label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Minimal 6 karakter">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6 mb-4">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation"
                   class="form-control" placeholder="Ulangi password baru">
          </div>
        </div>

        <button type="submit" class="btn btn-primary">
          <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>
          Update
        </button>
        <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
      </form>

    </div>
  </div>

</div>
@endsection