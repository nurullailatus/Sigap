@extends('layouts.app')

@section('page-title', 'Riwayat Laporan')

@section('content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Riwayat Laporan Saya</h6>
        <a href="{{ route('pelapor.laporan.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Buat Laporan
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fa">
                    <tr>
                        <th class="ps-3">Kode Laporan</th>
                        <th>Perangkat</th>
                        <th>Ruangan</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                    <tr>
                        <td class="ps-3 fw-semibold">{{ $item->kode_laporan }}</td>
                        <td>{{ $item->perangkat->nama_perangkat ?? '-' }}</td>
                        <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>
                            <a href="{{ route('pelapor.laporan.show', $item->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($laporan->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $laporan->links() }}
    </div>
    @endif
</div>
@endsection
