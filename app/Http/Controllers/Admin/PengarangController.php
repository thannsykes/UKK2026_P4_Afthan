<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengarang;
use Illuminate\Http\Request;

class PengarangController extends Controller
{
    public function index()
    {
        $pengarang = Pengarang::orderBy('nama_pengarang')->get();
        return view('admin.pengarang.index', compact('pengarang'));
    }

    public function create()
    {
        return view('admin.pengarang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengarang' => 'required|string|max:255|unique:pengarang,nama_pengarang',
        ], [
            'nama_pengarang.required' => 'Nama pengarang wajib diisi.',
            'nama_pengarang.unique'   => 'Nama pengarang sudah ada.',
        ]);

        Pengarang::create(['nama_pengarang' => $request->nama_pengarang]);

        return redirect()->route('admin.pengarang.index')
                         ->with('success', 'Pengarang berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $pengarang = Pengarang::findOrFail($id);
        return view('admin.pengarang.edit', compact('pengarang'));
    }

    public function update(Request $request, string $id)
    {
        $pengarang = Pengarang::findOrFail($id);

        $request->validate([
            'nama_pengarang' => 'required|string|max:255|unique:pengarang,nama_pengarang,' . $pengarang->id,
        ], [
            'nama_pengarang.required' => 'Nama pengarang wajib diisi.',
            'nama_pengarang.unique'   => 'Nama pengarang sudah ada.',
        ]);

        $pengarang->update(['nama_pengarang' => $request->nama_pengarang]);

        return redirect()->route('admin.pengarang.index')
                         ->with('success', 'Pengarang berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        Pengarang::findOrFail($id)->delete();

        return redirect()->route('admin.pengarang.index')
                         ->with('success', 'Pengarang berhasil dihapus.');
    }
}