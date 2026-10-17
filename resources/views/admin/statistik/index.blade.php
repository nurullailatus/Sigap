@extends('layouts.app')

@section('page-title', 'Statistik & Laporan')

@section('content')
<form method="GET" action="{{ route('admin.statistik.index') }}" class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $filters['tanggal_mulai'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="{{ $filters['tanggal_selesai'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua status</option>
                    @foreach(['menunggu' => 'Menunggu', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Kategori</label>
                <select name="kategori_id" class="form-select">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) ($filters['kategori_id'] ?? '') === (string) $category->id)>{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Ruangan</label>
                <select name="ruangan_id" class="form-select">
                    <option value="">Semua ruangan</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" @selected((string) ($filters['ruangan_id'] ?? '') === (string) $room->id)>{{ $room->nama_ruangan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary flex-grow-1" type="submit"><i class="bi bi-funnel"></i> Terapkan</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.statistik.index') }}" title="Reset filter"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </div>
    </div>
</form>

<div class="row g-3 mb-4">
    @foreach([
        ['Total laporan', $total, 'file-earmark-text', 'primary'],
        ['Menunggu', $statusTotals['menunggu'], 'hourglass-split', 'warning'],
        ['Diproses', $statusTotals['diproses'], 'wrench-adjustable-circle', 'info'],
        ['Selesai', $statusTotals['selesai'], 'check-circle', 'success'],
        ['Ditolak', $statusTotals['ditolak'], 'x-circle', 'danger'],
    ] as [$label, $value, $icon, $color])
        <div class="col-md">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ $label }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <strong class="fs-3">{{ $value }}</strong><i class="bi bi-{{ $icon }} text-{{ $color }} fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-lg-6"><div class="card border-0 shadow-sm rounded-3 h-100"><div class="card-header bg-white border-0 fw-bold">Status laporan</div><div class="card-body chart-container"><canvas id="statusChart"></canvas></div></div></div>
    <div class="col-lg-6"><div class="card border-0 shadow-sm rounded-3 h-100"><div class="card-header bg-white border-0 fw-bold">Tingkat urgensi</div><div class="card-body chart-container"><canvas id="urgencyChart"></canvas></div></div></div>
    <div class="col-lg-7"><div class="card border-0 shadow-sm rounded-3"><div class="card-header bg-white border-0 fw-bold">Tren laporan per bulan</div><div class="card-body chart-container"><canvas id="monthlyChart"></canvas></div></div></div>
    <div class="col-lg-5"><div class="card border-0 shadow-sm rounded-3"><div class="card-header bg-white border-0 fw-bold">Laporan per kategori</div><div class="card-body chart-container"><canvas id="categoryChart"></canvas></div></div></div>
</div>
@endsection

@push('scripts')
<style>.chart-container { min-height: 280px; }</style>
<script>
    const chartData = {
        status: { labels: @json(array_keys($statusTotals)), values: @json(array_values($statusTotals)) },
        urgency: { labels: @json($berdasarkanUrgensi->keys()->values()), values: @json($berdasarkanUrgensi->values()->values()) },
        monthly: { labels: @json($perBulan->pluck('label')->values()), values: @json($perBulan->pluck('total')->values()) },
        category: { labels: @json($berdasarkanKategori->pluck('label')->values()), values: @json($berdasarkanKategori->pluck('total')->values()) }
    };

    const createChart = (id, type, data, label, colors) => new Chart(document.getElementById(id), {
        type,
        data: { labels: data.labels, datasets: [{ label, data: data.values, backgroundColor: colors, borderColor: '#0d6efd', tension: 0.3 }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
    });

    createChart('statusChart', 'doughnut', chartData.status, 'Laporan', ['#ffc107', '#0d6efd', '#198754', '#dc3545']);
    createChart('urgencyChart', 'bar', chartData.urgency, 'Laporan', ['#6c757d', '#ffc107', '#dc3545']);
    createChart('monthlyChart', 'line', chartData.monthly, 'Laporan', '#0d6efd');
    createChart('categoryChart', 'bar', chartData.category, 'Laporan', '#6f42c1');
</script>
@endpush
