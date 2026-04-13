@extends('layouts.app')
@section('title', 'Transaksi Peminjaman')

@section('content')
<div class="container-fluid">

  <h5 class="fw-bold mb-4">
    <iconify-icon icon="solar:clipboard-list-bold-duotone" class="text-primary me-1"></iconify-icon>
    Transaksi Peminjaman
  </h5>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Anggota</th>
              <th>Buku</th>
              <th>Tgl Pinjam</th>
              <th>Tgl Kembali</th>
              <th>Status</th>
              <th>Denda</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($transaksi as $i => $t)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $t->user->nama }}</td>
              <td>
                @foreach($t->detailTransaksi as $d)
                  <div class="small">{{ $d->buku->judul }}</div>
                @endforeach
              </td>
              <td class="small">{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}</td>
              <td class="small">
                {{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }}
                @if($t->status === 'dipinjam' && \Carbon\Carbon::parse($t->tanggal_kembali)->isPast())
                  <span class="badge bg-danger">Terlambat</span>
                @endif
              </td>
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
              <td>
                @if($t->denda > 0)
                  <span class="text-danger small fw-semibold">
                    Rp {{ number_format($t->denda, 0, ',', '.') }}
                  </span>
                @else
                  <span class="text-muted small">-</span>
                @endif
              </td>
              <td>
                <div class="d-flex gap-1 flex-wrap">
                  @if($t->status === 'menunggu')
                    <form method="POST" action="{{ route('petugas.transaksi.terima', $t->id) }}">
                      @csrf @method('PATCH')
                      <button class="btn btn-sm btn-success">Terima</button>
                    </form>
                    <form method="POST" action="{{ route('petugas.transaksi.tolak', $t->id) }}">
                      @csrf @method('PATCH')
                      <button class="btn btn-sm btn-danger">Tolak</button>
                    </form>
                  @elseif($t->status === 'dipinjam')
                    <form method="POST" action="{{ route('petugas.transaksi.kembalikan', $t->id) }}"
                          onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                      @csrf @method('PATCH')
                      <button class="btn btn-sm btn-info text-white">Kembalikan</button>
                    </form>
                  @elseif($t->status === 'dikembalikan' && $t->denda > 0)
                    <form method="POST" action="{{ route('petugas.transaksi.lunasi', $t->id) }}"
                          onsubmit="return confirm('Tandai denda sudah lunas?')">
                      @csrf @method('PATCH')
                      <button class="btn btn-sm btn-warning">Lunasi Denda</button>
                    </form>
                  @else
                    <span class="text-muted small">-</span>
                  @endif
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center text-muted py-4">Belum ada transaksi</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection