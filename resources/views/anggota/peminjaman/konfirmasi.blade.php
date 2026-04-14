@extends('layouts.app')
@section('title', 'Konfirmasi Peminjaman')

@section('content')
<div class="container-fluid">

  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('anggota.buku.index') }}" class="btn btn-outline-secondary btn-sm">
      <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
    </a>
    <h5 class="fw-bold mb-0">Konfirmasi Peminjaman</h5>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">

          {{-- Info Buku --}}
          <div class="d-flex align-items-start gap-3 p-3 bg-light rounded mb-4">
            <div class="p-2 rounded bg-primary bg-opacity-10 text-primary">
              <iconify-icon icon="solar:book-2-bold" width="28"></iconify-icon>
            </div>

            <div>
              <div class="fw-semibold">{{ $buku->judul }}</div>

              {{-- Pengarang --}}
              <div class="text-muted small">
                {{ $buku->pengarang->nama_pengarang ?? '-' }}
              </div>

              {{-- Penerbit + Tahun --}}
              <div class="text-muted small">
                {{ $buku->penerbit->nama_penerbit ?? '-' }}
                {{ $buku->tahun ? '(' . $buku->tahun . ')' : '' }}
              </div>

              {{-- Stok --}}
              <span class="badge bg-success mt-1">
                Stok: {{ $buku->stok }}
              </span>
            </div>
          </div>

          {{-- Error --}}
          @if($errors->any())
          <div class="alert alert-danger py-2">
            <ul class="mb-0 ps-3">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          {{-- Form --}}
          <form method="POST" action="{{ route('anggota.pinjam.store') }}">
            @csrf
            <input type="hidden" name="buku_id" value="{{ $buku->id }}">

            <div class="mb-4">
              <label class="form-label fw-semibold">Berapa lama ingin meminjam?</label>

              <div class="input-group">
                <input type="number"
                       name="jumlah_hari"
                       class="form-control @error('jumlah_hari') is-invalid @enderror"
                       value="{{ old('jumlah_hari', 7) }}"
                       min="1"
                       max="30"
                       required>
                <span class="input-group-text">hari</span>

                @error('jumlah_hari')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="text-muted small mt-1">
                Minimal 1 hari, maksimal 30 hari
              </div>
            </div>

            {{-- Preview tanggal kembali --}}
            <div class="alert alert-info py-2 mb-4" id="preview-tanggal">
              <iconify-icon icon="solar:calendar-bold" class="me-1"></iconify-icon>
              Perkiraan tanggal kembali:
              <strong id="tgl-kembali"></strong>
            </div>

            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                <iconify-icon icon="solar:hand-money-bold" class="me-1"></iconify-icon>
                Ajukan Peminjaman
              </button>

              <a href="{{ route('anggota.buku.index') }}" class="btn btn-outline-secondary">
                Batal
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  function updateTanggal() {
    const hari = parseInt(document.querySelector('[name=jumlah_hari]').value) || 0;
    const tgl = new Date();
    tgl.setDate(tgl.getDate() + hari);

    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    document.getElementById('tgl-kembali').textContent =
      tgl.toLocaleDateString('id-ID', options);
  }

  document.querySelector('[name=jumlah_hari]').addEventListener('input', updateTanggal);
  updateTanggal();
</script>
@endpush