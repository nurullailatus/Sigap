@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#e8f0fe">
                    <i class="bi bi-file-earmark-text-fill fs-4" style="color:#1a2744"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Laporan</div>
                    <div class="fw-bold fs-4">{{ $totalLaporan }}</div>
                    <div class="text-muted" style="font-size:0.7rem">Laporan saya</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#fff3e0">
                    <i class="bi bi-hourglass-split fs-4" style="color:#f57c00"></i>
                </div>
                <div>
                    <div class="text-muted small">Menunggu</div>
                    <div class="fw-bold fs-4">{{ $menunggu }}</div>
                    <div class="text-muted" style="font-size:0.7rem">Belum diverifikasi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#e3f2fd">
                    <i class="bi bi-wrench-adjustable-circle-fill fs-4" style="color:#1565c0"></i>
                </div>
                <div>
                    <div class="text-muted small">Diproses</div>
                    <div class="fw-bold fs-4">{{ $diproses }}</div>
                    <div class="text-muted" style="font-size:0.7rem">Sedang ditangani</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#e8f5e9">
                    <i class="bi bi-check-circle-fill fs-4" style="color:#388e3c"></i>
                </div>
                <div>
                    <div class="text-muted small">Selesai</div>
                    <div class="fw-bold fs-4">{{ $selesai }}</div>
                    <div class="text-muted" style="font-size:0.7rem">Berhasil diperbaiki</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-4">
    <a href="{{ route('pelapor.laporan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Buat Laporan Baru
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
        <h6 class="fw-bold mb-0">Laporan Terbaru Saya</h6>
        <a href="{{ route('pelapor.laporan.index') }}" class="text-primary small">Lihat Semua</a>
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
                        <th>Urgensi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanTerbaru as $laporan)
                    <tr>
                        <td class="ps-3 fw-semibold">{{ $laporan->kode_laporan }}</td>
                        <td>{{ $laporan->perangkat->nama_perangkat ?? '-' }}</td>
                        <td>{{ $laporan->ruangan->nama_ruangan ?? '-' }}</td>
                        <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            @if($laporan->tingkat_urgensi === 'tinggi')
                                <span class="badge bg-danger">Tinggi</span>
                            @elseif($laporan->tingkat_urgensi === 'sedang')
                                <span class="badge bg-warning text-dark">Sedang</span>
                            @else
                                <span class="badge bg-secondary">Rendah</span>
                            @endif
                        </td>
                        <td>
                            @if($laporan->status === 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($laporan->status === 'diproses')
                                <span class="badge bg-primary">Diproses</span>
                            @elseif($laporan->status === 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pelapor.laporan.show', $laporan->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Belum ada laporan.
                            <a href="{{ route('pelapor.laporan.create') }}">Buat laporan pertamamu!</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection