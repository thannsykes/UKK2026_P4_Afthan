@extends('layouts.app')
@section('title', 'Kelola Anggota')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">
      <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="text-primary me-1"></iconify-icon>
      Kelola Anggota
    </h5>
    <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary">
      <iconify-icon icon="solar:add-circle-bold" class="me-1"></iconify-icon>
      Tambah Anggota
    </a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th width="50">No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Kelas</th>
              <th width="150">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($anggota as $i => $a)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $a->nama }}</td>
              <td>{{ $a->email }}</td>
              <td>{{ $a->anggota->kelas->nama_kelas ?? '-' }}</td>
              <td>
                <a href="{{ route('admin.anggota.edit', $a->id) }}"
                   class="btn btn-sm btn-warning">
                  <iconify-icon icon="solar:pen-bold"></iconify-icon>
                </a>
                <form method="POST" action="{{ route('admin.anggota.destroy', $a->id) }}"
                      class="d-inline"
                      onsubmit="return confirm('Hapus anggota {{ $a->nama }}?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">Belum ada anggota</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection
