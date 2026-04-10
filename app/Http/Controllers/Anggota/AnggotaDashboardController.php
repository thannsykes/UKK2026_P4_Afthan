<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class AnggotaDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'dipinjam'     => Transaksi::where('user_id', $userId)
                                ->where('status', 'dipinjam')->count(),
            'menunggu'     => Transaksi::where('user_id', $userId)
                                ->where('status', 'menunggu')->count(),
            'total_history'=> Transaksi::where('user_id', $userId)->count(),
            'terlambat'    => Transaksi::where('user_id', $userId)
                                ->where('status', 'dipinjam')
                                ->whereDate('tanggal_kembali', '<', now())
                                ->count(),
        ];

        $activeLoans = Transaksi::with(['detailTransaksi.buku'])
                        ->where('user_id', $userId)
                        ->whereIn('status', ['menunggu', 'dipinjam'])
                        ->orderByDesc('id')
                        ->take(5)
                        ->get();

        $recentBooks = Buku::where('stok', '>', 0)
                        ->orderByDesc('id')
                        ->take(5)
                        ->get();

        return view('anggota.dashboard', compact('stats', 'activeLoans', 'recentBooks'));
    }
}