<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Rak;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with(['rak', 'penerbit', 'pengarang', 'kategori'])->orderBy('judul')->get();
        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        $rak       = Rak::orderBy('nama_rak')->get();
        $penerbit  = Penerbit::orderBy('nama_penerbit')->get();
        $pengarang = Pengarang::orderBy('nama_pengarang')->get();
        $kategori  = Kategori::orderBy('nama_kategori')->get();
        return view('admin.buku.create', compact('rak', 'penerbit', 'pengarang', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'pengarang_id' => 'required|exists:pengarang,id',
            'penerbit_id'  => 'required|exists:penerbit,id',
            'kategori_id'  => 'nullable|exists:kategori,id',
            'tahun'        => 'nullable|integer|min:1900|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'rak_id'       => 'nullable|exists:rak,id',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'judul.required'        => 'Judul wajib diisi.',
            'pengarang_id.required' => 'Pengarang wajib dipilih.',
            'penerbit_id.required'  => 'Penerbit wajib dipilih.',
            'stok.required'         => 'Stok wajib diisi.',
            'foto.image'            => 'File harus berupa gambar.',
            'foto.mimes'            => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max'              => 'Ukuran foto maksimal 2MB.',
        ]);

        $data = $request->only('judul', 'pengarang_id', 'penerbit_id', 'kategori_id', 'tahun', 'stok', 'rak_id');

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/buku'), $namaFoto);
            $data['foto'] = 'uploads/buku/' . $namaFoto;
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $buku      = Buku::findOrFail($id);
        $rak       = Rak::orderBy('nama_rak')->get();
        $penerbit  = Penerbit::orderBy('nama_penerbit')->get();
        $pengarang = Pengarang::orderBy('nama_pengarang')->get();
        $kategori  = Kategori::orderBy('nama_kategori')->get();
        return view('admin.buku.edit', compact('buku', 'rak', 'penerbit', 'pengarang', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul'        => 'required|string|max:255',
            'pengarang_id' => 'required|exists:pengarang,id',
            'penerbit_id'  => 'required|exists:penerbit,id',
            'kategori_id'  => 'nullable|exists:kategori,id',
            'tahun'        => 'nullable|integer|min:1900|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'rak_id'       => 'nullable|exists:rak,id',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'judul.required'        => 'Judul wajib diisi.',
            'pengarang_id.required' => 'Pengarang wajib dipilih.',
            'penerbit_id.required'  => 'Penerbit wajib dipilih.',
            'stok.required'         => 'Stok wajib diisi.',
            'foto.image'            => 'File harus berupa gambar.',
            'foto.mimes'            => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max'              => 'Ukuran foto maksimal 2MB.',
        ]);

        $data = $request->only('judul', 'pengarang_id', 'penerbit_id', 'kategori_id', 'tahun', 'stok', 'rak_id');

        if ($request->hasFile('foto')) {
            if ($buku->foto && file_exists(public_path($buku->foto))) {
                unlink(public_path($buku->foto));
            }
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/buku'), $namaFoto);
            $data['foto'] = 'uploads/buku/' . $namaFoto;
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Data buku berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->foto && file_exists(public_path($buku->foto))) {
            unlink(public_path($buku->foto));
        }
        $buku->delete();

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil dihapus.');
    }
}