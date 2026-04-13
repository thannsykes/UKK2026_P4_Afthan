@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
<div class="container-fluid">

  <h5 class="fw-bold mb-4">
    <iconify-icon icon="solar:book-bold-duotone" class="text-primary me-1"></iconify-icon>
    Daftar Buku Tersedia
  </h5>

  <div class="row g-3">
    @forelse($buku as $b)
    <div class="col-md-4 col-lg-3">
      <div class="card h-100">
        <div class="card-body">
          <div class="p-2 rounded bg-info bg-opacity-10 text-info d-inline-block mb-2">
            <iconify-icon icon="solar:book-2-bold" width="24"></iconify-icon>
          </div>
          <h6 class="fw-semibold">{{ $b->judul }}</h6>
          <p class="text-muted small mb-1">{{ $b->penulis }}</p>
          <p class="text-muted small mb-2">{{ $b->penerbit ?? '' }} {{ $b->tahun ? '(' . $b->tahun . ')' : '' }}</p>
          <span class="badge bg-success mb-3">Stok: {{ $b->stok }}</span>
          <form method="POST" action="{{ route('anggota.pinjam.store') }}">
            @csrf
            <input type="hidden" name="buku_id" value="{{ $b->id }}">
            <button type="submit" class="btn btn-primary btn-sm w-100"
                    onclick="return confirm('Pinjam buku {{ $b->judul }}?')">
              <iconify-icon icon="solar:hand-money-bold" class="me-1"></iconify-icon>
              Pinjam
            </button>
          </form>
        </div>
      </div>
    </div>
    @empty
    <div class="col-12">
      <div class="text-center py-5 text-muted">
        <iconify-icon icon="solar:book-minimalistic-bold" width="48" class="d-block mb-2 opacity-50"></iconify-icon>
        <p>Tidak ada buku tersedia saat ini.</p>
      </div>
    </div>
    @endforelse
  </div>

</div>
@endsection