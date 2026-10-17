@extends('layouts.app')

@section('page-title', 'Dashboard Teknisi')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#e8f0fe">
                    <i class="bi bi-list-task fs-4" style="color:#1a2744"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Tugas</div>
                    <div class="fw-bold fs-4">{{ $totalTugas }}</div>
                    <div class="text-muted" style="font-size:0.7rem">Semua tugas saya</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#fff3e0">
                    <i class="bi bi-wrench fs-4" style="color:#f57c00"></i>
                </div>
                <div>
                    <div class="text-muted small">Sedang Berjalan</div>
                    <div class="fw-bold fs-4">{{ $tugasBerjalan }}</div>
                    <div class="text-muted" style="font-size:0.7rem">Belum selesai</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#e8f5e9">
                    <i class="bi bi-check-circle-fill fs-4" style="color:#388e3c"></i>
                </div>
                <div>
                    <div class="text-muted small">Selesai</div>
                    <div class="fw-bold fs-4">{{ $tugasSelesai }}</div>
                    <div class="text-muted" style="font-size:0.7rem">Berhasil diperbaiki</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
        <h6 class="fw-bold mb-0">Tugas Terbaru</h6>
        <a href="{{ route('teknisi.tugas.index') }}" class="text-primary small">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fa">
                    <tr>
                        <th class="ps-3">Kode Laporan</th>
                        <th>Perangkat</th>
                        <th>Ruangan</th>
                        <th>Prioritas</th>
                        <th>Tgl Ditugaskan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugasTerbaru as $tugas)
                    <tr>
                        <td class="ps-3 fw-semibold">
                            {{ $tugas->laporan->kode_laporan ?? '-' }}
                        </td>
                        <td>{{ $tugas->laporan->perangkat->nama_perangkat ?? '-' }}</td>
                        <td>{{ $tugas->laporan->ruangan->nama_ruangan ?? '-' }}</td>
                        <td>
                            @if($tugas->prioritas === 'tinggi')
                                <span class="badge bg-danger">Tinggi</span>
                            @elseif($tugas->prioritas === 'sedang')
                                <span class="badge bg-warning text-dark">Sedang</span>
                            @else
                                <span class="badge bg-secondary">Rendah</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ \Carbon\Carbon::parse($tugas->tanggal_ditugaskan)->format('d/m/Y') }}
                        </td>
                        <td>
                            @if($tugas->tanggal_selesai)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-warning text-dark">Berlangsung</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('teknisi.tugas.show', $tugas->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Belum ada tugas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection