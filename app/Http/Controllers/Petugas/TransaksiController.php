<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['user', 'detailTransaksi.buku'])
                        ->orderByDesc('id')
                        ->get();

        return view('petugas.transaksi.index', compact('transaksi'));
    }

    public function show(string $id)
    {
        $transaksi = Transaksi::with(['user', 'detailTransaksi.buku'])->findOrFail($id);
        return view('petugas.transaksi.show', compact('transaksi'));
    }

    // ✅ TERIMA PEMINJAMAN (FIX DI SINI)
    public function terima(string $id)
    {
        $transaksi = Transaksi::where('status', 'menunggu')->findOrFail($id);

        // Kurangi stok buku
        foreach ($transaksi->detailTransaksi as $detail) {
            $buku = Buku::findOrFail($detail->buku_id);

            if ($buku->stok <= 0) {
                return back()->with('error', 'Stok buku "' . $buku->judul . '" habis.');
            }

            $buku->decrement('stok');
        }

        // ✅ FIX: jangan ubah tanggal lagi
        $transaksi->update([
            'status' => 'dipinjam',
        ]);

        return back()->with('success', 'Peminjaman berhasil diterima.');
    }

    // Tolak peminjaman
    public function tolak(string $id)
    {
        $transaksi = Transaksi::where('status', 'menunggu')->findOrFail($id);
        $transaksi->update(['status' => 'ditolak']);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    // Proses pengembalian
    public function kembalikan(string $id)
    {
        $transaksi = Transaksi::whereIn('status', ['dipinjam', 'menunggu_kembali'])
                        ->findOrFail($id);

        // Hitung denda
        $denda = 0;
        $tanggalKembali = Carbon::parse($transaksi->tanggal_kembali);

        if (Carbon::now()->gt($tanggalKembali)) {
            $hariTerlambat = Carbon::now()->diffInDays($tanggalKembali);
            $denda = $hariTerlambat * 1000;
        }

        // Kembalikan stok buku
        foreach ($transaksi->detailTransaksi as $detail) {
            $detail->buku->increment('stok');
        }

        $transaksi->update([
            'status' => 'dikembalikan',
            'denda'  => $denda,
        ]);

        $msg = 'Buku berhasil dikembalikan.';
        if ($denda > 0) {
            $msg .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
        }

        return back()->with('success', $msg);
    }

    // Lunasi denda
    public function lunasi(string $id)
    {
        $transaksi = Transaksi::where('status', 'dikembalikan')
                        ->where('denda', '>', 0)
                        ->findOrFail($id);

        $transaksi->update(['denda' => 0]);

        return back()->with('success', 'Denda berhasil dilunasi.');
    }
}