<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kelas;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::orderBy('judul')->get();
        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'penulis'  => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun'    => 'nullable|integer|min:1900|max:' . date('Y'),
            'stok'     => 'required|integer|min:0',
        ], [
            'judul.required'   => 'Judul wajib diisi.',
            'penulis.required' => 'Penulis wajib diisi.',
            'stok.required'    => 'Stok wajib diisi.',
            'stok.min'         => 'Stok tidak boleh negatif.',
        ]);

        Buku::create($request->only('judul', 'penulis', 'penerbit', 'tahun', 'stok'));

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul'    => 'required|string|max:255',
            'penulis'  => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun'    => 'nullable|integer|min:1900|max:' . date('Y'),
            'stok'     => 'required|integer|min:0',
        ], [
            'judul.required'   => 'Judul wajib diisi.',
            'penulis.required' => 'Penulis wajib diisi.',
            'stok.required'    => 'Stok wajib diisi.',
            'stok.min'         => 'Stok tidak boleh negatif.',
        ]);

        $buku->update($request->only('judul', 'penulis', 'penerbit', 'tahun', 'stok'));

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Data buku berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil dihapus.');
    }
}