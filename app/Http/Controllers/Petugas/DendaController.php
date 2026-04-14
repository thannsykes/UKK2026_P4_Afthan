<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class DendaController extends Controller
{
    public function index()
    {
        // Transaksi yang sudah dikembalikan tapi masih ada denda
        $dendaBelumLunas = Transaksi::with(['user', 'detailTransaksi.buku'])
                            ->where('status', 'dikembalikan')
                            ->where('denda', '>', 0)
                            ->orderByDesc('id')
                            ->get();

        // Transaksi yang dendanya sudah dilunasi
        $dendaSudahLunas = Transaksi::with(['user', 'detailTransaksi.buku'])
                            ->where('status', 'dikembalikan')
                            ->where('denda', 0)
                            ->whereNotNull('tanggal_kembali')
                            ->orderByDesc('id')
                            ->take(10)
                            ->get();

        $totalDenda = $dendaBelumLunas->sum('denda');

        return view('petugas.denda.index', compact('dendaBelumLunas', 'dendaSudahLunas', 'totalDenda'));
    }

    public function lunasi(string $id)
    {
        $transaksi = Transaksi::where('status', 'dikembalikan')
                        ->where('denda', '>', 0)
                        ->findOrFail($id);

        $transaksi->update(['denda' => 0]);

        return back()->with('success', 'Denda berhasil dilunasi.');
    }
}