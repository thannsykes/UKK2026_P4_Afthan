<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function index()
    {
        $penerbit = Penerbit::orderBy('nama_penerbit')->get();
        return view('admin.penerbit.index', compact('penerbit'));
    }

    public function create()
    {
        return view('admin.penerbit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penerbit' => 'required|string|max:255|unique:penerbit,nama_penerbit',
        ], [
            'nama_penerbit.required' => 'Nama penerbit wajib diisi.',
            'nama_penerbit.unique'   => 'Nama penerbit sudah ada.',
        ]);

        Penerbit::create(['nama_penerbit' => $request->nama_penerbit]);

        return redirect()->route('admin.penerbit.index')
                         ->with('success', 'Penerbit berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $penerbit = Penerbit::findOrFail($id);
        return view('admin.penerbit.edit', compact('penerbit'));
    }

    public function update(Request $request, string $id)
    {
        $penerbit = Penerbit::findOrFail($id);

        $request->validate([
            'nama_penerbit' => 'required|string|max:255|unique:penerbit,nama_penerbit,' . $penerbit->id,
        ], [
            'nama_penerbit.required' => 'Nama penerbit wajib diisi.',
            'nama_penerbit.unique'   => 'Nama penerbit sudah ada.',
        ]);

        $penerbit->update(['nama_penerbit' => $request->nama_penerbit]);

        return redirect()->route('admin.penerbit.index')
                         ->with('success', 'Penerbit berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        Penerbit::findOrFail($id)->delete();

        return redirect()->route('admin.penerbit.index')
                         ->with('success', 'Penerbit berhasil dihapus.');
    }
}