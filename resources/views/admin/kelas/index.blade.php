@extends('layouts.app')
@section('title', 'Kelola Kelas')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">
      <iconify-icon icon="solar:buildings-bold-duotone" class="text-primary me-1"></iconify-icon>
      Kelola Kelas
    </h5>
    <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">
      <iconify-icon icon="solar:add-circle-bold" class="me-1"></iconify-icon>
      Tambah Kelas
    </a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th width="50">No</th>
              <th>Nama Kelas</th>
              <th>Jumlah Anggota</th>
              <th width="150">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($kelas as $i => $k)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $k->nama_kelas }}</td>
              <td>{{ $k->anggota->count() }} anggota</td>
              <td>
                <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn-sm btn-warning">
                  <iconify-icon icon="solar:pen-bold"></iconify-icon>
                </a>
                <form method="POST" action="{{ route('admin.kelas.destroy', $k->id) }}"
                      class="d-inline"
                      onsubmit="return confirm('Hapus kelas {{ $k->nama_kelas }}?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-4">Belum ada kelas</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection