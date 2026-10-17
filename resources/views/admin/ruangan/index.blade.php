@extends('layouts.app')

@section('page-title', 'Data Ruangan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Data Ruangan</h4>
        <p class="text-muted mb-0">Kelola semua ruangan per gedung</p>
    </div>
    <a href="{{ route('admin.ruangan.tambah') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Ruangan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Kode Ruangan</th>
                    <th>Nama Ruangan</th>
                    <th>Gedung</th>
                    <th>Jumlah Perangkat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ruangan as $item)
                <tr>
                    <td class="ps-4">{{ $loop->iteration }}</td>
                    <td><code>{{ $item->kode_ruangan }}</code></td>
                    <td>{{ $item->nama_ruangan }}</td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $item->gedung->nama_gedung ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-primary rounded-pill">
                            {{ $item->perangkat->count() }} perangkat
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.ruangan.edit', $item->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        Belum ada data ruangan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($ruangan->hasPages())
<div class="d-flex justify-content-end mt-3">
    {{ $ruangan->links() }}
</div>
@endif
@endsection