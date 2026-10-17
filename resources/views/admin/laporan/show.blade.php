@extends('layouts.app')

@section('page-title', 'Detail Laporan')

@section('content')

{{-- Tombol Kembali --}}
<div class="mb-3">
    <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

{{-- Alert sukses --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">

    {{-- Kolom Kiri: Info Laporan --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">{{ $laporan->kode_laporan }}</h6>
                    @if($laporan->status === 'menunggu')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @elseif($laporan->status === 'diproses')
                        <span class="badge bg-primary">Diproses</span>
                    @elseif($laporan->status === 'selesai')
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted ps-0" style="width:160px">Pelapor</td>
                        <td class="fw-semibold">{{ $laporan->pengguna->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Ruangan</td>
                        <td>{{ $laporan->ruangan->nama_ruangan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Perangkat</td>
                        <td>{{ $laporan->perangkat->nama_perangkat ?? '-' }}
                            <span class="text-muted small">({{ $laporan->perangkat->merk_model ?? '' }})</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Kategori</td>
                        <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Tingkat Urgensi</td>
                        <td>
                            @if($laporan->tingkat_urgensi === 'tinggi')
                                <span class="badge bg-danger">Tinggi</span>
                            @elseif($laporan->tingkat_urgensi === 'sedang')
                                <span class="badge bg-warning text-dark">Sedang</span>
                            @else
                                <span class="badge bg-secondary">Rendah</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Tanggal Laporan</td>
                        <td>{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0 align-top">Deskripsi</td>
                        <td>{{ $laporan->deskripsi_kerusakan }}</td>
                    </tr>
                    @if($laporan->alasan_ditolak)
                    <tr>
                        <td class="text-muted ps-0 align-top">Alasan Ditolak</td>
                        <td class="text-danger">{{ $laporan->alasan_ditolak }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Foto Laporan --}}
        @if($laporan->fotoLaporan->count() > 0)
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">Foto Kerusakan</h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    @foreach($laporan->fotoLaporan as $foto)
                    <div class="col-4">
                        <img src="{{ asset('storage/foto_laporan/' . $foto->nama_file) }}"
                             class="img-fluid rounded"
                             style="height:150px;width:100%;object-fit:cover"
                             onerror="this.src='https://via.placeholder.com/150x150?text=Foto'">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Kolom Kanan: Aksi Admin --}}
    <div class="col-md-4">

        {{-- Tombol Aksi (hanya muncul kalau status menunggu) --}}
        @if($laporan->status === 'menunggu')
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">Tindakan Admin</h6>
            </div>
            <div class="card-body">
                {{-- Tombol Terima --}}
                <form action="{{ route('admin.laporan.terima', $laporan->id) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-success w-100"
                            onclick="return confirm('Terima laporan ini?')">
                        <i class="bi bi-check-lg me-1"></i> Terima Laporan
                    </button>
                </form>

                <hr>

                {{-- Form Tolak --}}
                <form action="{{ route('admin.laporan.tolak', $laporan->id) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Alasan Penolakan</label>
                        <textarea name="alasan_ditolak" class="form-control form-control-sm
                            @error('alasan_ditolak') is-invalid @enderror"
                            rows="3" placeholder="Jelaskan alasan penolakan..."></textarea>
                        @error('alasan_ditolak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-danger w-100"
                            onclick="return confirm('Tolak laporan ini?')">
                        <i class="bi bi-x-lg me-1"></i> Tolak Laporan
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Form Tugaskan Teknisi --}}
        @if($laporan->status === 'diproses' && $laporan->penugasan->count() === 0)
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">Tugaskan Teknisi</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.laporan.tugaskan', $laporan->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Pilih Teknisi</label>
                        <select name="teknisi_id" class="form-select form-select-sm">
                            <option value="">-- Pilih Teknisi --</option>
                            @foreach($teknisiList as $teknisi)
                            <option value="{{ $teknisi->id }}">{{ $teknisi->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Prioritas</label>
                        <select name="prioritas" class="form-select form-select-sm">
                            <option value="rendah">Rendah</option>
                            <option value="sedang" selected>Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-sm">
                        <i class="bi bi-person-check me-1"></i> Tugaskan
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Info Penugasan (kalau sudah ada) --}}
        @if($laporan->penugasan->count() > 0)
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">Info Penugasan</h6>
            </div>
            <div class="card-body">
                @foreach($laporan->penugasan as $tugas)
                <div class="mb-2">
                    <div class="text-muted small">Teknisi</div>
                    <div class="fw-semibold">{{ $tugas->teknisi->nama ?? '-' }}</div>
                </div>
                <div class="mb-2">
                    <div class="text-muted small">Tanggal Ditugaskan</div>
                    <div>{{ \Carbon\Carbon::parse($tugas->tanggal_ditugaskan)->format('d F Y') }}</div>
                </div>
                @if($tugas->tindakan_perbaikan)
                <div class="mb-2">
                    <div class="text-muted small">Tindakan</div>
                    <div>{{ $tugas->tindakan_perbaikan }}</div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection