@extends('layouts.app')

@section('page-title', 'Penugasan Teknisi')

@section('content')

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Daftar Penugasan Teknisi</h6>
        <span class="text-muted small">Total: {{ $penugasan->total() }} penugasan</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fa">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Kode Laporan</th>
                        <th>Teknisi</th>
                        <th>Prioritas</th>
                        <th>Tgl Ditugaskan</th>
                        <th>Tgl Selesai</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penugasan as $i => $item)
                    <tr>
                        <td class="ps-3">{{ $penugasan->firstItem() + $i }}</td>
                        <td>
                            <a href="{{ route('admin.laporan.show', $item->laporan_id) }}"
                               class="text-primary fw-semibold">
                                {{ $item->laporan->kode_laporan ?? '-' }}
                            </a>
                        </td>
                        <td>{{ $item->teknisi->nama ?? '-' }}</td>
                        <td>
                            @if($item->prioritas === 'tinggi')
                                <span class="badge bg-danger">Tinggi</span>
                            @elseif($item->prioritas === 'sedang')
                                <span class="badge bg-warning text-dark">Sedang</span>
                            @else
                                <span class="badge bg-secondary">Rendah</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ \Carbon\Carbon::parse($item->tanggal_ditugaskan)->format('d/m/Y') }}
                        </td>
                        <td class="text-muted small">
                            {{ $item->tanggal_selesai
                                ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y')
                                : '-' }}
                        </td>
                        <td>
                            @if($item->tanggal_selesai)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-warning text-dark">Berlangsung</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.laporan.show', $item->laporan_id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Belum ada penugasan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($penugasan->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $penugasan->links() }}
    </div>
    @endif
</div>

@endsection