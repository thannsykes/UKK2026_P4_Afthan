<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Buku;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Statistik
        $stats = [
            // Transaksi dengan status dipinjam
            'active_loans'   => Transaksi::where('user_id', $userId)
                                    ->where('status', 'dipinjam')
                                    ->count(),

            // Pending: transaksi hari ini yang belum melewati tanggal kembali
            // (sesuaikan logika ini jika kamu punya status 'pending' di enum)
            'pending_loans'  => 0,

            // Total semua transaksi user ini
            'total_borrowed' => Transaksi::where('user_id', $userId)->count(),

            // Terlambat: status dipinjam dan tanggal_kembali sudah lewat
            'overdue_loans'  => Transaksi::where('user_id', $userId)
                                    ->where('status', 'dipinjam')
                                    ->whereDate('tanggal_kembali', '<', now())
                                    ->count(),
        ];

        // Peminjaman aktif (max 5) beserta detail buku
        $activeLoans = Transaksi::with(['detailTransaksi.buku'])
                        ->where('user_id', $userId)
                        ->where('status', 'dipinjam')
                        ->orderByDesc('tanggal_pinjam')
                        ->take(5)
                        ->get();

        // Buku terbaru (max 5 berdasarkan id terbesar)
        $recentBooks = Buku::orderByDesc('id')->take(5)->get();

        return view('dashboard', compact('stats', 'activeLoans', 'recentBooks'));
    }
}