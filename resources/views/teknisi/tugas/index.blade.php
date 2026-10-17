@extends('layouts.app')

@section('page-title', 'Tugas Saya')

@section('content')

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
        <h6 class="fw-bold mb-0">Daftar Tugas Saya</h6>
        <span class="text-muted small">Total: {{ $tugas->total() }} tugas</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fa">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Kode Laporan</th>
                        <th>Perangkat</th>
                        <th>Ruangan</th>
                        <th>Prioritas</th>
                        <th>Tgl Ditugaskan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugas as $i => $item)
                    <tr>
                        <td class="ps-3">{{ $tugas->firstItem() + $i }}</td>
                        <td class="fw-semibold">{{ $item->laporan->kode_laporan ?? '-' }}</td>
                        <td>{{ $item->laporan->perangkat->nama_perangkat ?? '-' }}</td>
                        <td>{{ $item->laporan->ruangan->nama_ruangan ?? '-' }}</td>
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
                        <td>
                            @if($item->tanggal_selesai)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-warning text-dark">Berlangsung</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('teknisi.tugas.show', $item->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Belum ada tugas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tugas->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $tugas->links() }}
    </div>
    @endif
</div>

@endsection