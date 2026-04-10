@extends('layouts.app')
@section('title', 'Dashboard Anggota')

@section('content')
<div class="container-fluid">

  {{-- Header --}}
  <div class="card bg-primary text-white mb-4">
    <div class="card-body py-4">
      <h4 class="mb-1 fw-bold">Selamat Datang, {{ auth()->user()->nama }}! 👋</h4>
      <p class="mb-0 opacity-75">Kelola peminjaman buku kamu di sini.</p>
    </div>
  </div>

  {{-- Stats --}}
  <div class="row g-3 mb-4">
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
            <div class="p-2 rounded bg-warning bg-opacity-10 text-warning">
              <iconify-icon icon="solar:clock-circle-bold" width="28"></iconify-icon>
            </div>
            <div>
              <h4 class="mb-0 fw-bold">{{ $stats['menunggu'] }}</h4>
              <span class="text-muted small">Menunggu</span>
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
              <h4 class="mb-0 fw-bold">{{ $stats['total_history'] }}</h4>
              <span class="text-muted small">Total Pinjaman</span>
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
    {{-- Peminjaman Aktif --}}
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-semibold">
            <iconify-icon icon="solar:document-text-bold" class="text-primary me-1"></iconify-icon>
            Peminjaman Aktif
          </h6>
          <a href="{{ route('anggota.history') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
          @forelse($activeLoans as $transaksi)
          <div class="d-flex align-items-start gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
            <div class="p-2 rounded bg-primary bg-opacity-10 text-primary">
              <iconify-icon icon="solar:book-bold" width="20"></iconify-icon>
            </div>
            <div class="flex-grow-1" style="min-width:0">
              @foreach($transaksi->detailTransaksi as $detail)
              <div class="fw-semibold small text-truncate">{{ $detail->buku->judul }}</div>
              <div class="text-muted" style="font-size:.75rem">{{ $detail->buku->penulis }}</div>
              @endforeach
              <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                @php
                  $badge = match($transaksi->status) {
                    'menunggu' => 'warning text-dark',
                    'dipinjam' => 'primary',
                    default    => 'secondary',
                  };
                @endphp
                <span class="badge bg-{{ $badge }}">{{ ucfirst($transaksi->status) }}</span>
                @if($transaksi->status === 'dipinjam')
                <span class="text-muted" style="font-size:.75rem">
                  Jatuh tempo: {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y') }}
                  @if(\Carbon\Carbon::parse($transaksi->tanggal_kembali)->isPast())
                    <span class="text-danger">
                      (Terlambat {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->diffInDays() }} hari)
                    </span>
                  @endif
                </span>
                @endif
              </div>
            </div>
          </div>
          @empty
          <div class="text-center py-5 text-muted">
            <iconify-icon icon="solar:book-minimalistic-bold" width="48" class="opacity-50 d-block mb-2"></iconify-icon>
            <p class="mb-2">Tidak ada peminjaman aktif</p>
            <a href="{{ route('anggota.buku.index') }}" class="btn btn-sm btn-primary">Pinjam Buku</a>
          </div>
          @endforelse
        </div>
      </div>
    </div>

    {{-- Buku Tersedia --}}
    <div class="col-lg-5">
      <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-semibold">
            <iconify-icon icon="solar:stars-bold" class="text-warning me-1"></iconify-icon>
            Buku Tersedia
          </h6>
          <a href="{{ route('anggota.buku.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
          @foreach($recentBooks as $buku)
          <a href="{{ route('anggota.buku.show', $buku->id) }}"
             class="d-flex align-items-center gap-3 p-3 text-decoration-none text-dark {{ !$loop->last ? 'border-bottom' : '' }}">
            <div class="p-2 rounded bg-info bg-opacity-10 text-info">
              <iconify-icon icon="solar:book-2-bold" width="20"></iconify-icon>
            </div>
            <div class="flex-grow-1" style="min-width:0">
              <div class="fw-semibold small text-truncate">{{ $buku->judul }}</div>
              <div class="text-muted" style="font-size:.75rem">{{ $buku->penulis }}</div>
            </div>
            <span class="badge bg-success">Tersedia ({{ $buku->stok }})</span>
          </a>
          @endforeach
        </div>
      </div>

      {{-- Ketentuan --}}
      <div class="card border border-info">
        <div class="card-body">
          <h6 class="text-info fw-semibold mb-2">
            <iconify-icon icon="solar:info-circle-bold" class="me-1"></iconify-icon>
            Ketentuan Peminjaman
          </h6>
          <ul class="mb-0 ps-3 text-muted small">
            <li>Maksimal 3 buku sekaligus</li>
            <li>Durasi pinjam: 7 hari</li>
            <li>Denda terlambat: Rp 1.000/hari</li>
            <li>Peminjaman perlu persetujuan petugas</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection