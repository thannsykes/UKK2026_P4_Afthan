<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Transaksi;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_anggota'   => User::where('role', 'anggota')->count(),
            'total_petugas'   => User::where('role', 'petugas')->count(),
            'total_buku'      => Buku::count(),
            'total_dipinjam'  => Transaksi::where('status', 'dipinjam')->count(),
            'menunggu'        => Transaksi::where('status', 'menunggu')->count(),
            'terlambat'       => Transaksi::where('status', 'dipinjam')
                                    ->whereDate('tanggal_kembali', '<', now())
                                    ->count(),
        ];

        $transaksiTerbaru = Transaksi::with(['user', 'detailTransaksi.buku'])
                            ->orderByDesc('id')
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact('stats', 'transaksiTerbaru'));
    }
}