@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

{{-- 4 Kartu Statistik --}}
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
                    <div class="text-muted" style="font-size:0.7rem">Semua laporan masuk</div>
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
                <div class="rounded-3 p-3" style="background:#e8f5e9">
                    <i class="bi bi-wrench-adjustable-circle-fill fs-4" style="color:#2e7d32"></i>
                </div>
                <div>
                    <div class="text-muted small">Diproses</div>
                    <div class="fw-bold fs-4">{{ $diproses }}</div>
                    <div class="text-muted" style="font-size:0.7rem">Sedang ditangani teknisi</div>
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

{{-- Tabel Laporan Terbaru --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
        <h6 class="fw-bold mb-0">Laporan Terbaru</h6>
        <a href="#" class="text-primary small">5 Terbaru</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fa">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Kode Laporan</th>
                        <th>Pelapor</th>
                        <th>Ruangan</th>
                        <th>Kategori</th>
                        <th>Urgensi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanTerbaru as $i => $laporan)
                    <tr>
                        <td class="ps-3">{{ $i + 1 }}</td>
                        <td>
                            <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="text-primary fw-semibold">
                                {{ $laporan->kode_laporan }}
                            </a>
                        </td>
                        <td>{{ $laporan->pengguna?->nama ?? 'Tidak diketahui' }}</td>
                        <td>{{ $laporan->ruangan?->nama_ruangan ?? 'Tidak diketahui' }}</td>
                        <td>{{ $laporan->kategori?->nama_kategori ?? 'Tidak diketahui' }}</td>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada laporan masuk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection