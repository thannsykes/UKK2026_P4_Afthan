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
          @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
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
            <label class="form-label">Pengarang</label>
            <select name="pengarang_id" class="form-select @error('pengarang_id') is-invalid @enderror" required>
              <option value="">-- Pilih Pengarang --</option>
              @foreach($pengarang as $pg)
              <option value="{{ $pg->id }}" {{ old('pengarang_id') == $pg->id ? 'selected' : '' }}>
                {{ $pg->nama_pengarang }}
              </option>
              @endforeach
            </select>
            @error('pengarang_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Penerbit</label>
            <select name="penerbit_id" class="form-select @error('penerbit_id') is-invalid @enderror" required>
              <option value="">-- Pilih Penerbit --</option>
              @foreach($penerbit as $pb)
              <option value="{{ $pb->id }}" {{ old('penerbit_id') == $pb->id ? 'selected' : '' }}>
                {{ $pb->nama_penerbit }}
              </option>
              @endforeach
            </select>
            @error('penerbit_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Kategori <span class="text-muted small">(opsional)</span></label>
            <select name="kategori_id" class="form-select">
              <option value="">-- Pilih Kategori --</option>
              @foreach($kategori as $k)
              <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
              </option>
              @endforeach
            </select>
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

          <div class="col-md-6">
            <label class="form-label">Rak Buku <span class="text-muted small">(opsional)</span></label>
            <select name="rak_id" class="form-select @error('rak_id') is-invalid @enderror">
              <option value="">-- Pilih Rak --</option>
              @foreach($rak as $r)
              <option value="{{ $r->id }}" {{ old('rak_id') == $r->id ? 'selected' : '' }}>
                {{ $r->nama_rak }}{{ $r->lokasi ? ' - ' . $r->lokasi : '' }}
              </option>
              @endforeach
            </select>
            @error('rak_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Foto Buku <span class="text-muted small">(opsional, maks 2MB)</span></label>
            <input type="file" name="foto" accept="image/*"
                   class="form-control @error('foto') is-invalid @enderror" id="fotoInput">
            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="mt-2" id="previewContainer" style="display:none">
              <img id="previewImg" src="" alt="Preview" class="rounded"
                   style="max-height:150px; max-width:200px; object-fit:cover;">
            </div>
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>Simpan
          </button>
          <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  document.getElementById('fotoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = ev => {
        document.getElementById('previewImg').src = ev.target.result;
        document.getElementById('previewContainer').style.display = 'block';
      };
      reader.readAsDataURL(file);
    }
  });
</script>
@endpush