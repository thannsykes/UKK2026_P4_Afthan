@extends('layouts.app')

@section('title', 'Dashboard Anggota')

@section('content')
<div class="row py-4">
    <div class="col-12 mb-4">
        <h4 class="fw-semibold">Selamat datang, {{ auth()->user()->nama }}! 👋</h4>
        <p class="text-muted mb-0">Berikut ringkasan aktivitas peminjaman buku kamu 📚</p>
    </div>

    {{-- STAT CARDS --}}
    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <iconify-icon icon="solar:book-bold-duotone" class="fs-4 text-primary"></iconify-icon>
                </div>
                <div>
                    <p class="mb-0 text-muted small">Sedang Dipinjam</p>
                    <h4 class="mb-0 fw-bold">{{ $stats['dipinjam'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <iconify-icon icon="solar:clock-circle-bold-duotone" class="fs-4 text-warning"></iconify-icon>
                </div>
                <div>
                    <p class="mb-0 text-muted small">Menunggu Konfirmasi</p>
                    <h4 class="mb-0 fw-bold">{{ $stats['menunggu'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <iconify-icon icon="solar:history-bold-duotone" class="fs-4 text-success"></iconify-icon>
                </div>
                <div>
                    <p class="mb-0 text-muted small">Total Peminjaman</p>
                    <h4 class="mb-0 fw-bold">{{ $stats['total_history'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <iconify-icon icon="solar:danger-triangle-bold-duotone" class="fs-4 text-danger"></iconify-icon>
                </div>
                <div>
                    <p class="mb-0 text-muted small">Terlambat</p>
                    <h4 class="mb-0 fw-bold">{{ $stats['terlambat'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- PEMINJAMAN AKTIF --}}
    <div class="col-lg-7 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold mb-0">Peminjaman Aktif</h5>
                <a href="{{ route('anggota.history') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>

            <div class="card-body p-0">
                @if($activeLoans->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <iconify-icon icon="solar:book-minimalistic-bold-duotone" class="fs-1 mb-2"></iconify-icon>
                        <p class="mb-0">Tidak ada peminjaman aktif 📭</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeLoans as $loan)
                                    @foreach($loan->detailTransaksi as $detail)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-medium">
                                                {{ $detail->buku->judul ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">
                                            {{ $loan->tanggal_pinjam ? \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') : '-' }}
                                        </td>
                                        <td class="text-muted small">
                                            {{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') : '-' }}
                                        </td>
                                        <td>
                                            @php
                                                $badge = match($loan->status) {
                                                    'menunggu' => 'warning',
                                                    'dipinjam' => 'primary',
                                                    default => 'secondary',
                                                };
                                            @endphp

                                            <span class="badge bg-{{ $badge }}">
                                                {{ ucfirst($loan->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- BUKU TERSEDIA --}}
    <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold mb-0">Buku Tersedia</h5>
                <a href="{{ route('anggota.buku.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>

            <div class="card-body p-0">
                @if($recentBooks->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <iconify-icon icon="solar:book-bold-duotone" class="fs-1 mb-2"></iconify-icon>
                        <p class="mb-0">Tidak ada buku tersedia 📚</p>
                    </div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($recentBooks as $buku)
                        <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-1 fw-medium">{{ $buku->judul }}</p>

                                <small class="text-muted d-block">
                                    {{ $buku->pengarang->nama_pengarang ?? '-' }}
                                </small>

                                <small class="text-muted d-block">
                                    {{ $buku->penerbit->nama_penerbit ?? '-' }}
                                    {{ $buku->tahun ? '(' . $buku->tahun . ')' : '' }}
                                </small>
                            </div>

                            <div class="text-end">
                                <span class="badge bg-success-subtle text-success mb-2">
                                    Stok: {{ $buku->stok }}
                                </span>

                                <div>
                                    <a href="{{ route('anggota.pinjam.konfirmasi', $buku->id) }}"
                                       class="btn btn-sm btn-primary py-0 px-2 {{ $buku->stok == 0 ? 'disabled' : '' }}"
                                       style="font-size:0.75rem">
                                        Pinjam
                                    </a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection