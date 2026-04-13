<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'nama_kelas.unique'   => 'Nama kelas sudah ada.',
        ]);

        Kelas::create(['nama_kelas' => $request->nama_kelas]);

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, string $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $kelas->id,
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'nama_kelas.unique'   => 'Nama kelas sudah ada.',
        ]);

        $kelas->update(['nama_kelas' => $request->nama_kelas]);

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Kelas berhasil dihapus.');
    }
}