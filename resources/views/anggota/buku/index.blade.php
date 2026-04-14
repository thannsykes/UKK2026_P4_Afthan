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
      <div class="card h-100 shadow-sm border-0">
        
        {{-- Foto Buku --}}
        @if($b->foto)
          <img src="{{ asset($b->foto) }}" alt="{{ $b->judul }}"
               class="card-img-top" style="height:180px; object-fit:cover;">
        @else
          <div class="d-flex align-items-center justify-content-center bg-light"
               style="height:180px;">
            <iconify-icon icon="solar:book-2-bold" width="48" class="text-muted opacity-50"></iconify-icon>
          </div>
        @endif

        <div class="card-body d-flex flex-column">

          {{-- Judul --}}
          <h6 class="fw-semibold mb-1">{{ $b->judul }}</h6>

          {{-- Pengarang --}}
          <p class="text-muted small mb-1">
            {{ $b->pengarang->nama_pengarang ?? '-' }}
          </p>

          {{-- Penerbit + Tahun --}}
          <p class="text-muted small mb-2">
            {{ $b->penerbit->nama_penerbit ?? '-' }}
            {{ $b->tahun ? '(' . $b->tahun . ')' : '' }}
          </p>

          {{-- Stok --}}
          <span class="badge {{ $b->stok > 0 ? 'bg-success' : 'bg-danger' }} mb-3">
            Stok: {{ $b->stok }}
          </span>

          {{-- Button --}}
          <div class="mt-auto">
            <a href="{{ route('anggota.pinjam.konfirmasi', $b->id) }}"
               class="btn btn-primary btn-sm w-100 {{ $b->stok == 0 ? 'disabled' : '' }}">
              <iconify-icon icon="solar:hand-money-bold" class="me-1"></iconify-icon>
              Pinjam
            </a>
          </div>

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