@extends('layouts.app')
@section('title', 'History Peminjaman')

@section('content')
<div class="container-fluid">

  <h5 class="fw-bold mb-4">
    <iconify-icon icon="solar:document-text-bold-duotone" class="text-primary me-1"></iconify-icon>
    History Peminjaman
  </h5>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>No</th>
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
              <td>
                @foreach($t->detailTransaksi as $d)
                  <div class="small">{{ $d->buku->judul }}</div>
                @endforeach
              </td>
              <td class="small">{{ Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}</td>
              <td class="small">
                {{ Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }}
                @if($t->status === 'dipinjam' && Carbon\Carbon::parse($t->tanggal_kembali)->isPast())
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
                @if($t->status === 'dipinjam')
                  <form method="POST" action="{{ route('anggota.kembalikan', $t->id) }}">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm btn-outline-success"
                            onclick="return confirm('Kembalikan buku ini?')">
                      Kembalikan
                    </button>
                  </form>
                @else
                  <span class="text-muted small">-</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat peminjaman</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection