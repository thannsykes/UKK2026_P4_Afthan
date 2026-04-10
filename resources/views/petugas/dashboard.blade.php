@extends('layouts.app')
@section('title', 'Dashboard Petugas')

@section('content')
<div class="container-fluid">

  {{-- Header --}}
  <div class="card bg-info text-white mb-4">
    <div class="card-body py-4">
      <h4 class="mb-1 fw-bold">Dashboard Petugas 📋</h4>
      <p class="mb-0 opacity-75">Selamat datang, {{ auth()->user()->nama }}</p>
    </div>
  </div>

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="p-2 rounded bg-warning bg-opacity-10 text-warning">
              <iconify-icon icon="solar:clock-circle-bold" width="28"></iconify-icon>
            </div>
            <div>
              <h4 class="mb-0 fw-bold">{{ $stats['menunggu'] }}</h4>
              <span class="text-muted small">Menunggu Persetujuan</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="p-2 rounded bg-primary bg-opacity-10 text-primary">
              <iconify-icon icon="solar:book-bold" width="28"></iconify-icon>
            </div>
            <div>
              <h4 class="mb-0 fw-bold">{{ $stats['dipinjam'] }}</h4>
              <span class="text-muted small">Sedang Dipinjam</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="p-2 rounded bg-success bg-opacity-10 text-success">
              <iconify-icon icon="solar:check-circle-bold" width="28"></iconify-icon>
            </div>
            <div>
              <h4 class="mb-0 fw-bold">{{ $stats['dikembalikan'] }}</h4>
              <span class="text-muted small">Dikembalikan</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="p-2 rounded bg-danger bg-opacity-10 text-danger">
              <iconify-icon icon="solar:danger-bold" width="28"></iconify-icon>
            </div>
            <div>
              <h4 class="mb-0 fw-bold">{{ $stats['terlambat'] }}</h4>
              <span class="text-muted small">Terlambat</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    {{-- Menunggu Persetujuan --}}
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-semibold">
            <iconify-icon icon="solar:clock-circle-bold" class="text-warning me-1"></iconify-icon>
            Menunggu Persetujuan
          </h6>
          <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
          @forelse($menunggu as $t)
          <div class="d-flex align-items-start gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
            <div class="p-2 rounded bg-warning bg-opacity-10 text-warning">
              <iconify-icon icon="solar:user-bold" width="20"></iconify-icon>
            </div>
            <div class="flex-grow-1" style="min-width:0">
              <div class="fw-semibold small">{{ $t->user->nama }}</div>
              @foreach($t->detailTransaksi as $d)
              <div class="text-muted" style="font-size:.75rem">{{ $d->buku->judul }}</div>
              @endforeach
              <div class="text-muted" style="font-size:.75rem">
                {{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}
              </div>
            </div>
            <div class="d-flex gap-1">
              <form method="POST" action="{{ route('petugas.transaksi.terima', $t->id) }}">
                @csrf @method('PATCH')
                <button class="btn btn-xs btn-success">Terima</button>
              </form>
              <form method="POST" action="{{ route('petugas.transaksi.tolak', $t->id) }}">
                @csrf @method('PATCH')
                <button class="btn btn-xs btn-danger">Tolak</button>
              </form>
            </div>
          </div>
          @empty
          <div class="text-center py-4 text-muted small">Tidak ada transaksi menunggu</div>
          @endforelse
        </div>
      </div>
    </div>

    {{-- Terlambat --}}
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-semibold">
            <iconify-icon icon="solar:danger-bold" class="text-danger me-1"></iconify-icon>
            Peminjaman Terlambat
          </h6>
        </div>
        <div class="card-body p-0">
          @forelse($terlambat as $t)
          <div class="d-flex align-items-start gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
            <div class="p-2 rounded bg-danger bg-opacity-10 text-danger">
              <iconify-icon icon="solar:user-bold" width="20"></iconify-icon>
            </div>
            <div class="flex-grow-1" style="min-width:0">
              <div class="fw-semibold small">{{ $t->user->nama }}</div>
              @foreach($t->detailTransaksi as $d)
              <div class="text-muted" style="font-size:.75rem">{{ $d->buku->judul }}</div>
              @endforeach
              <span class="badge bg-danger mt-1">
                Terlambat {{ \Carbon\Carbon::parse($t->tanggal_kembali)->diffInDays() }} hari
              </span>
            </div>
            <a href="{{ route('petugas.transaksi.show', $t->id) }}" class="btn btn-sm btn-outline-danger">
              <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
            </a>
          </div>
          @empty
          <div class="text-center py-4 text-muted small">Tidak ada peminjaman terlambat</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('styles')
<style>.btn-xs { padding: .2rem .45rem; font-size: .75rem; }</style>
@endpush