<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::where('stok', '>', 0)->orderBy('judul')->get();
        return view('anggota.buku.index', compact('buku'));
    }

    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('anggota.buku.show', compact('buku'));
    }
}