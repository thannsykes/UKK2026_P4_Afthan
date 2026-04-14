<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index()
    {
        $rak = Rak::orderBy('nama_rak')->get();
        return view('admin.rak.index', compact('rak'));
    }

    public function create()
    {
        return view('admin.rak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:255|unique:rak,nama_rak',
            'lokasi'   => 'nullable|string|max:255',
        ], [
            'nama_rak.required' => 'Nama rak wajib diisi.',
            'nama_rak.unique'   => 'Nama rak sudah ada.',
        ]);

        Rak::create($request->only('nama_rak', 'lokasi'));

        return redirect()->route('admin.rak.index')
                         ->with('success', 'Rak berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $rak = Rak::findOrFail($id);
        return view('admin.rak.edit', compact('rak'));
    }

    public function update(Request $request, string $id)
    {
        $rak = Rak::findOrFail($id);

        $request->validate([
            'nama_rak' => 'required|string|max:255|unique:rak,nama_rak,' . $rak->id,
            'lokasi'   => 'nullable|string|max:255',
        ], [
            'nama_rak.required' => 'Nama rak wajib diisi.',
            'nama_rak.unique'   => 'Nama rak sudah ada.',
        ]);

        $rak->update($request->only('nama_rak', 'lokasi'));

        return redirect()->route('admin.rak.index')
                         ->with('success', 'Rak berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $rak = Rak::findOrFail($id);
        $rak->delete();

        return redirect()->route('admin.rak.index')
                         ->with('success', 'Rak berhasil dihapus.');
    }
}