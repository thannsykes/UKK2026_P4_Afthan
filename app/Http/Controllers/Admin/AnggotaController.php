<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = User::where('role', 'anggota')->orderBy('nama')->get();
        return view('admin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.anggota.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'kelas_id' => 'nullable|exists:kelas,id',
            'no_telp'  => 'nullable|string|max:20',
            'nis'      => 'nullable|string|max:20|unique:anggota,nis',
            'status'   => 'required|in:aktif,tidak aktif',
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nis.unique'         => 'NIS sudah terdaftar.',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'anggota',
        ]);

        Anggota::create([
            'user_id'  => $user->id,
            'kelas_id' => $request->kelas_id,
            'no_telp'  => $request->no_telp,
            'nis'      => $request->nis,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.anggota.index')
                         ->with('success', 'Akun anggota berhasil dibuat.');
    }

    public function edit(string $id)
    {
        $anggota      = User::where('role', 'anggota')->findOrFail($id);
        $kelas        = Kelas::orderBy('nama_kelas')->get();
        $kelasAnggota = Anggota::where('user_id', $id)->first();
        return view('admin.anggota.edit', compact('anggota', 'kelas', 'kelasAnggota'));
    }

    public function update(Request $request, string $id)
    {
        $anggota = User::where('role', 'anggota')->findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $anggota->id,
            'password' => 'nullable|min:6|confirmed',
            'kelas_id' => 'nullable|exists:kelas,id',
            'no_telp'  => 'nullable|string|max:20',
            'nis'      => 'nullable|string|max:20|unique:anggota,nis,' . optional(Anggota::where('user_id', $id)->first())->id,
            'status'   => 'required|in:aktif,tidak aktif',
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nis.unique'         => 'NIS sudah terdaftar.',
        ]);

        $data = [
            'nama'  => $request->nama,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $anggota->update($data);

        Anggota::updateOrCreate(
            ['user_id' => $anggota->id],
            [
                'kelas_id' => $request->kelas_id,
                'no_telp'  => $request->no_telp,
                'nis'      => $request->nis,
                'status'   => $request->status,
            ]
        );

        return redirect()->route('admin.anggota.index')
                         ->with('success', 'Data anggota berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $anggota = User::where('role', 'anggota')->findOrFail($id);
        $anggota->delete();

        return redirect()->route('admin.anggota.index')
                         ->with('success', 'Akun anggota berhasil dihapus.');
    }
}