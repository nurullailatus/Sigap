@extends('layouts.app')

@section('page-title', 'Laporan Masuk')

@section('content')

{{-- Filter laporan --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan.index') }}">
            <div class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua status</option>
                        @foreach(['menunggu' => 'Menunggu', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ $filters['tanggal_mulai'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control form-control-sm" value="{{ $filters['tanggal_selesai'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Kategori</label>
                    <select name="kategori_id" class="form-select form-select-sm">
                        <option value="">Semua kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) ($filters['kategori_id'] ?? '') === (string) $category->id)>{{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Ruangan</label>
                    <select name="ruangan_id" class="form-select form-select-sm">
                        <option value="">Semua ruangan</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" @selected((string) ($filters['ruangan_id'] ?? '') === (string) $room->id)>{{ $room->nama_ruangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-grow-1"><i class="bi bi-funnel"></i> Filter</button>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>
            </div>
        </form>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.laporan.index') }}"
               class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">
                Semua
            </a>
            <a href="{{ route('admin.laporan.index', ['status' => 'menunggu']) }}"
               class="btn btn-sm {{ request('status') == 'menunggu' ? 'btn-warning' : 'btn-outline-secondary' }}">
                Menunggu
            </a>
            <a href="{{ route('admin.laporan.index', ['status' => 'diproses']) }}"
               class="btn btn-sm {{ request('status') == 'diproses' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Diproses
            </a>
            <a href="{{ route('admin.laporan.index', ['status' => 'selesai']) }}"
               class="btn btn-sm {{ request('status') == 'selesai' ? 'btn-success' : 'btn-outline-secondary' }}">
                Selesai
            </a>
            <a href="{{ route('admin.laporan.index', ['status' => 'ditolak']) }}"
               class="btn btn-sm {{ request('status') == 'ditolak' ? 'btn-danger' : 'btn-outline-secondary' }}">
                Ditolak
            </a>
        </div>
    </div>
</div>

{{-- Tabel Laporan --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Daftar Laporan Masuk</h6>
        <span class="text-muted small">Total: {{ $laporan->total() }} laporan</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fa">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Kode Laporan</th>
                        <th>Pelapor</th>
                        <th>Perangkat</th>
                        <th>Ruangan</th>
                        <th>Kategori</th>
                        <th>Urgensi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $i => $item)
                    <tr>
                        <td class="ps-3">{{ $laporan->firstItem() + $i }}</td>
                        <td class="fw-semibold">{{ $item->kode_laporan }}</td>
                        <td>{{ $item->pengguna->nama ?? '-' }}</td>
                        <td>{{ $item->perangkat->nama_perangkat ?? '-' }}</td>
                        <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            @if($item->tingkat_urgensi === 'tinggi')
                                <span class="badge bg-danger">Tinggi</span>
                            @elseif($item->tingkat_urgensi === 'sedang')
                                <span class="badge bg-warning text-dark">Sedang</span>
                            @else
                                <span class="badge bg-secondary">Rendah</span>
                            @endif
                        </td>
                        <td>
                            @if($item->status === 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($item->status === 'diproses')
                                <span class="badge bg-primary">Diproses</span>
                            @elseif($item->status === 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d/m/Y') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.laporan.show', $item->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Tidak ada laporan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- Pagination --}}
    @if($laporan->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $laporan->links() }}
    </div>
    @endif
</div>

@endsection