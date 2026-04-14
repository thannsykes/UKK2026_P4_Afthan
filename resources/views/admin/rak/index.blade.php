@extends('layouts.app')
@section('title', 'Kelola Rak Buku')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">
      <iconify-icon icon="solar:library-bold-duotone" class="text-primary me-1"></iconify-icon>
      Kelola Rak Buku
    </h5>
    <a href="{{ route('admin.rak.create') }}" class="btn btn-primary">
      <iconify-icon icon="solar:add-circle-bold" class="me-1"></iconify-icon>
      Tambah Rak
    </a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th width="50">No</th>
              <th>Nama Rak</th>
              <th>Lokasi</th>
              <th>Jumlah Buku</th>
              <th width="150">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rak as $i => $r)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $r->nama_rak }}</td>
              <td>{{ $r->lokasi ?? '-' }}</td>
              <td>{{ $r->buku->count() }} buku</td>
              <td>
                <a href="{{ route('admin.rak.edit', $r->id) }}" class="btn btn-sm btn-warning">
                  <iconify-icon icon="solar:pen-bold"></iconify-icon>
                </a>
                <form method="POST" action="{{ route('admin.rak.destroy', $r->id) }}"
                      class="d-inline"
                      onsubmit="return confirm('Hapus rak {{ $r->nama_rak }}?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">Belum ada rak</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection