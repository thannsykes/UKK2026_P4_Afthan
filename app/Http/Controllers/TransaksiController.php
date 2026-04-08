<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    //  Menampilkan semua transaksi user
    public function index()
    {
        $transaksi = Transaksi::with('detailTransaksi.buku')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.transaksi.index', compact('transaksi'));
    }

    //  Detail transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.buku')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('user.transaksi.show', compact('transaksi'));
    }
}