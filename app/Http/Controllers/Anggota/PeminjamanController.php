<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // History semua peminjaman anggota
    public function history()
    {
        $transaksi = Transaksi::with(['detailTransaksi.buku'])
                        ->where('user_id', Auth::id())
                        ->orderByDesc('id')
                        ->get();

        return view('anggota.peminjaman.history', compact('transaksi'));
    }

    // Ajukan peminjaman buku
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ], [
            'buku_id.required' => 'Pilih buku yang ingin dipinjam.',
            'buku_id.exists'   => 'Buku tidak ditemukan.',
        ]);

        $userId = Auth::id();

        // Cek apakah anggota sudah punya peminjaman aktif >= 3 buku
        $totalAktif = DetailTransaksi::whereHas('transaksi', function($q) use ($userId) {
            $q->where('user_id', $userId)
              ->whereIn('status', ['menunggu', 'dipinjam']);
        })->count();

        if ($totalAktif >= 3) {
            return back()->with('error', 'Kamu sudah meminjam 3 buku. Kembalikan dulu sebelum meminjam lagi.');
        }

        // Cek stok buku
        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        // Buat transaksi
        $transaksi = Transaksi::create([
            'user_id'         => $userId,
            'tanggal_pinjam'  => Carbon::now()->toDateString(),
            'tanggal_kembali' => Carbon::now()->addDays(7)->toDateString(),
            'status'          => 'menunggu',
            'denda'           => 0,
        ]);

        // Buat detail transaksi
        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'buku_id'      => $buku->id,
            'jumlah'       => 1,
        ]);

        return redirect()->route('anggota.history')
                         ->with('success', 'Permintaan peminjaman berhasil diajukan. Menunggu persetujuan petugas.');
    }

    // Anggota mengajukan pengembalian
    public function kembalikan(string $id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
                        ->where('status', 'dipinjam')
                        ->findOrFail($id);

        $transaksi->update(['status' => 'menunggu_kembali']);

        return back()->with('success', 'Permintaan pengembalian berhasil diajukan.');
    }
}