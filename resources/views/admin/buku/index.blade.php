@extends('layouts.app')
@section('title', 'Kelola Buku')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">
      <iconify-icon icon="solar:book-bold-duotone" class="text-primary me-1"></iconify-icon>
      Kelola Buku
    </h5>
    <a href="{{ route('admin.buku.create') }}" class="btn btn-primary">
      <iconify-icon icon="solar:add-circle-bold" class="me-1"></iconify-icon>
      Tambah Buku
    </a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th width="50">No</th>
              <th>Judul</th>
              <th>Penulis</th>
              <th>Penerbit</th>
              <th>Tahun</th>
              <th width="80">Stok</th>
              <th width="150">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($buku as $i => $b)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $b->judul }}</td>
              <td>{{ $b->penulis }}</td>
              <td>{{ $b->penerbit ?? '-' }}</td>
              <td>{{ $b->tahun ?? '-' }}</td>
              <td>
                <span class="badge {{ $b->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                  {{ $b->stok }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.buku.edit', $b->id) }}" class="btn btn-sm btn-warning">
                  <iconify-icon icon="solar:pen-bold"></iconify-icon>
                </a>
                <form method="POST" action="{{ route('admin.buku.destroy', $b->id) }}"
                      class="d-inline"
                      onsubmit="return confirm('Hapus buku {{ $b->judul }}?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">Belum ada buku</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection