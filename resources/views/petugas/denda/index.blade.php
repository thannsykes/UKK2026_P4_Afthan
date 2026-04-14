@extends('layouts.app')
@section('title', 'Pelunasan Denda')

@section('content')
<div class="container-fluid">

  <h5 class="fw-bold mb-4">
    <iconify-icon icon="solar:wallet-money-bold-duotone" class="text-danger me-1"></iconify-icon>
    Pelunasan Denda
  </h5>

  {{-- Total Denda --}}
  <div class="card bg-danger text-white mb-4">
    <div class="card-body py-3">
      <div class="d-flex align-items-center gap-3">
        <div class="p-2 rounded bg-white bg-opacity-25">
          <iconify-icon icon="solar:danger-bold" width="28"></iconify-icon>
        </div>
        <div>
          <div class="small opacity-75">Total Denda Belum Lunas</div>
          <h4 class="mb-0 fw-bold">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h4>
        </div>
      </div>
    </div>
  </div>

  {{-- Denda Belum Lunas --}}
  <div class="card mb-4">
    <div class="card-header">
      <h6 class="mb-0 fw-semibold">
        <iconify-icon icon="solar:clock-circle-bold" class="text-danger me-1"></iconify-icon>
        Denda Belum Lunas
      </h6>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Anggota</th>
              <th>Buku</th>
              <th>Tgl Kembali</th>
              <th>Denda</th>
              <th width="120">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($dendaBelumLunas as $i => $t)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $t->user->nama }}</td>
              <td>
                @foreach($t->detailTransaksi as $d)
                  <div class="small">{{ $d->buku->judul }}</div>
                @endforeach
              </td>
              <td class="small">{{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }}</td>
              <td>
                <span class="text-danger fw-semibold">
                  Rp {{ number_format($t->denda, 0, ',', '.') }}
                </span>
              </td>
              <td>
                <form method="POST" action="{{ route('petugas.denda.lunasi', $t->id) }}"
                      onsubmit="return confirm('Tandai denda Rp {{ number_format($t->denda, 0, ',', '.') }} dari {{ $t->user->nama }} sudah lunas?')">
                  @csrf @method('PATCH')
                  <button class="btn btn-sm btn-success">
                    <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>
                    Lunasi
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">
                <iconify-icon icon="solar:check-circle-bold" width="32" class="text-success d-block mb-1"></iconify-icon>
                Tidak ada denda yang belum lunas
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Riwayat Lunas --}}
  <div class="card">
    <div class="card-header">
      <h6 class="mb-0 fw-semibold">
        <iconify-icon icon="solar:check-circle-bold" class="text-success me-1"></iconify-icon>
        Riwayat Denda Lunas (10 Terakhir)
      </h6>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Anggota</th>
              <th>Buku</th>
              <th>Tgl Kembali</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($dendaSudahLunas as $i => $t)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $t->user->nama }}</td>
              <td>
                @foreach($t->detailTransaksi as $d)
                  <div class="small">{{ $d->buku->judul }}</div>
                @endforeach
              </td>
              <td class="small">{{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }}</td>
              <td><span class="badge bg-success">Lunas</span></td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection