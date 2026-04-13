@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid">

  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-outline-secondary btn-sm">
      <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
    </a>
    <h5 class="fw-bold mb-0">Detail Transaksi #{{ $transaksi->id }}</h5>
  </div>

  <div class="row g-3">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header"><h6 class="mb-0 fw-semibold">Info Anggota</h6></div>
        <div class="card-body">
          <table class="table table-sm mb-0">
            <tr><td class="text-muted">Nama</td><td>{{ $transaksi->user->nama }}</td></tr>
            <tr><td class="text-muted">Email</td><td>{{ $transaksi->user->email }}</td></tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header"><h6 class="mb-0 fw-semibold">Info Peminjaman</h6></div>
        <div class="card-body">
          <table class="table table-sm mb-0">
            <tr><td class="text-muted">Tgl Pinjam</td><td>{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d M Y') }}</td></tr>
            <tr><td class="text-muted">Tgl Kembali</td><td>{{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y') }}</td></tr>
            <tr>
              <td class="text-muted">Status</td>
              <td>
                @php
                  $badge = match($transaksi->status) {
                    'menunggu'     => 'warning text-dark',
                    'dipinjam'     => 'primary',
                    'dikembalikan' => 'success',
                    'ditolak'      => 'danger',
                    default        => 'secondary',
                  };
                @endphp
                <span class="badge bg-{{ $badge }}">{{ ucfirst($transaksi->status) }}</span>
              </td>
            </tr>
            <tr>
              <td class="text-muted">Denda</td>
              <td>
                @if($transaksi->denda > 0)
                  <span class="text-danger fw-semibold">Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</span>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-header"><h6 class="mb-0 fw-semibold">Daftar Buku</h6></div>
        <div class="card-body p-0">
          <table class="table mb-0">
            <thead class="table-light">
              <tr><th>Judul</th><th>Penulis</th><th>Jumlah</th></tr>
            </thead>
            <tbody>
              @foreach($transaksi->detailTransaksi as $d)
              <tr>
                <td>{{ $d->buku->judul }}</td>
                <td>{{ $d->buku->penulis }}</td>
                <td>{{ $d->jumlah }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection