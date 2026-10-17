@extends('layouts.app')

@section('page-title', 'Data Perangkat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Data Perangkat</h4>
        <p class="text-muted mb-0">Kelola semua perangkat di setiap ruangan</p>
    </div>
    <a href="{{ route('admin.perangkat.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Perangkat
    </a>
</div>

{{-- Flash message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                    <th>Kode</th>
                    <th>Nama Perangkat</th>
                    <th>Merk/Model</th>
                    <th>Ruangan</th>
                    <th>Kondisi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($perangkat as $item)
                <tr>
                    <td class="ps-4">{{ $loop->iteration }}</td>
                    <td><code>{{ $item->kode_perangkat }}</code></td>
                    <td>{{ $item->nama_perangkat }}</td>
                    <td>{{ $item->merk_model ?? '-' }}</td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $item->ruangan->nama_ruangan ?? '-' }}
                        </span>
                    </td>
                    <td>
                        @if($item->kondisi === 'baik')
                            <span class="badge bg-success">Baik</span>
                        @elseif($item->kondisi === 'rusak')
                            <span class="badge bg-danger">Rusak</span>
                        @else
                            <span class="badge bg-warning text-dark">Dalam Perbaikan</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.perangkat.edit', $item->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        Belum ada data perangkat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if($perangkat->hasPages())
<div class="d-flex justify-content-end mt-3">
    {{ $perangkat->links() }}
</div>
@endif
@endsection