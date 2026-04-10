@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

  {{-- Header --}}
  <div class="card bg-danger text-white mb-4">
    <div class="card-body py-4">
      <h4 class="mb-1 fw-bold">Dashboard Admin 👑</h4>
      <p class="mb-0 opacity-75">Selamat datang, {{ auth()->user()->nama }}</p>
    </div>
  </div>

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
      <div class="card text-center">
        <div class="card-body">
          <div class="p-2 rounded bg-primary bg-opacity-10 text-primary d-inline-block mb-2">
            <iconify-icon icon="solar:users-group-rounded-bold" width="28"></iconify-icon>
          </div>
          <h4 class="mb-0 fw-bold">{{ $stats['total_anggota'] }}</h4>
          <span class="text-muted small">Anggota</span>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-2">
      <div class="card text-center">
        <div class="card-body">
          <div class="p-2 rounded bg-info bg-opacity-10 text-info d-inline-block mb-2">
            <iconify-icon icon="solar:user-id-bold" width="28"></iconify-icon>
          </div>
          <h4 class="mb-0 fw-bold">{{ $stats['total_petugas'] }}</h4>
          <span class="text-muted small">Petugas</span>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-2">
      <div class="card text-center">
        <div class="card-body">
          <div class="p-2 rounded bg-success bg-opacity-10 text-success d-inline-block mb-2">
            <iconify-icon icon="solar:book-bold" width="28"></iconify-icon>
          </div>
          <h4 class="mb-0 fw-bold">{{ $stats['total_buku'] }}</h4>
          <span class="text-muted small">Total Buku</span>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-2">
      <div class="card text-center">
        <div class="card-body">
          <div class="p-2 rounded bg-warning bg-opacity-10 text-warning d-inline-block mb-2">
            <iconify-icon icon="solar:clock-circle-bold" width="28"></iconify-icon>
          </div>
          <h4 class="mb-0 fw-bold">{{ $stats['menunggu'] }}</h4>
          <span class="text-muted small">Menunggu</span>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-2">
      <div class="card text-center">
        <div class="card-body">
          <div class="p-2 rounded bg-primary bg-opacity-10 text-primary d-inline-block mb-2">
            <iconify-icon icon="solar:document-text-bold" width="28"></iconify-icon>
          </div>
          <h4 class="mb-0 fw-bold">{{ $stats['total_dipinjam'] }}</h4>
          <span class="text-muted small">Dipinjam</span>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-2">
      <div class="card text-center">
        <div class="card-body">
          <div class="p-2 rounded bg-danger bg-opacity-10 text-danger d-inline-block mb-2">
            <iconify-icon icon="solar:danger-bold" width="28"></iconify-icon>
          </div>
          <h4 class="mb-0 fw-bold">{{ $stats['terlambat'] }}</h4>
          <span class="text-muted small">Terlambat</span>
        </div>
      </div>
    </div>
  </div>

  {{-- Transaksi Terbaru --}}
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h6 class="mb-0 fw-semibold">
        <iconify-icon icon="solar:document-text-bold" class="text-primary me-1"></iconify-icon>
        Transaksi Terbaru
      </h6>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>Anggota</th>
              <th>Buku</th>
              <th>Tgl Pinjam</th>
              <th>Tgl Kembali</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($transaksiTerbaru as $t)
            <tr>
              <td>{{ $t->user->nama }}</td>
              <td>
                @foreach($t->detailTransaksi as $d)
                  <div class="small">{{ $d->buku->judul }}</div>
                @endforeach
              </td>
              <td class="small">{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}</td>
              <td class="small">{{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }}</td>
              <td>
                @php
                  $badge = match($t->status) {
                    'menunggu'     => 'warning text-dark',
                    'dipinjam'     => 'primary',
                    'dikembalikan' => 'success',
                    'ditolak'      => 'danger',
                    default        => 'secondary',
                  };
                @endphp
                <span class="badge bg-{{ $badge }}">{{ ucfirst($t->status) }}</span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">Belum ada transaksi</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection