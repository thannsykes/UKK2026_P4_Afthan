<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class PetugasDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'menunggu'       => Transaksi::where('status', 'menunggu')->count(),
            'dipinjam'       => Transaksi::where('status', 'dipinjam')->count(),
            'dikembalikan'   => Transaksi::where('status', 'dikembalikan')->count(),
            'terlambat'      => Transaksi::where('status', 'dipinjam')
                                    ->whereDate('tanggal_kembali', '<', now())
                                    ->count(),
        ];

        // Transaksi menunggu persetujuan
        $menunggu = Transaksi::with(['user', 'detailTransaksi.buku'])
                    ->where('status', 'menunggu')
                    ->orderByDesc('id')
                    ->take(5)
                    ->get();

        // Transaksi yang sudah jatuh tempo
        $terlambat = Transaksi::with(['user', 'detailTransaksi.buku'])
                    ->where('status', 'dipinjam')
                    ->whereDate('tanggal_kembali', '<', now())
                    ->orderBy('tanggal_kembali')
                    ->take(5)
                    ->get();

        return view('petugas.dashboard', compact('stats', 'menunggu', 'terlambat'));
    }
}