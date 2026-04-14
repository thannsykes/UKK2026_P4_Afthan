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

    // Form konfirmasi peminjaman (pilih jumlah hari)
    public function konfirmasi(string $bukuId)
    {
        $buku = Buku::findOrFail($bukuId);

        if ($buku->stok <= 0) {
            return redirect()->route('anggota.buku.index')
                             ->with('error', 'Stok buku habis.');
        }

        return view('anggota.peminjaman.konfirmasi', compact('buku'));
    }

    // Simpan peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'buku_id'     => 'required|exists:buku,id',
            'jumlah_hari' => 'required|integer|min:1|max:30',
        ], [
            'buku_id.required'     => 'Buku tidak valid.',
            'jumlah_hari.required' => 'Jumlah hari wajib diisi.',
            'jumlah_hari.min'      => 'Minimal peminjaman 1 hari.',
            'jumlah_hari.max'      => 'Maksimal peminjaman 30 hari.',
        ]);

        $userId = Auth::id();

        // Cek apakah anggota sudah punya peminjaman aktif >= 3 buku
        $totalAktif = DetailTransaksi::whereHas('transaksi', function($q) use ($userId) {
            $q->where('user_id', $userId)
              ->whereIn('status', ['menunggu', 'dipinjam', 'menunggu_kembali']);
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
            'tanggal_kembali' => Carbon::now()->addDays((int)$request->jumlah_hari)->toDateString(),
            'status'          => 'menunggu',
            'denda'           => 0,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'buku_id'      => $buku->id,
            'jumlah'       => 1,
        ]);

        return redirect()->route('anggota.history')
                         ->with('success', 'Permintaan peminjaman berhasil diajukan selama ' . $request->jumlah_hari . ' hari. Menunggu persetujuan petugas.');
    }

    // Anggota mengajukan pengembalian
    public function kembalikan(string $id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
                        ->where('status', 'dipinjam')
                        ->findOrFail($id);

        $transaksi->update(['status' => 'menunggu_kembali']);

        return back()->with('success', 'Permintaan pengembalian berhasil diajukan. Menunggu konfirmasi petugas.');
    }
}