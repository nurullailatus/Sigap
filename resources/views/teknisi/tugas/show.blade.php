@extends('layouts.app')

@section('page-title', 'Detail Tugas')

@section('content')

<div class="mb-3">
    <a href="{{ route('teknisi.tugas.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
    {{-- Kolom Kiri: Info Laporan --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    Info Laporan — {{ $tugas->laporan->kode_laporan ?? '-' }}
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted ps-0" style="width:180px">Pelapor</td>
                        <td class="fw-semibold">{{ $tugas->laporan->pengguna->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Ruangan</td>
                        <td>{{ $tugas->laporan->ruangan->nama_ruangan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Perangkat</td>
                        <td>{{ $tugas->laporan->perangkat->nama_perangkat ?? '-' }}
                            <span class="text-muted small">
                                ({{ $tugas->laporan->perangkat->merk_model ?? '' }})
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Kategori</td>
                        <td>{{ $tugas->laporan->kategori->nama_kategori ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Prioritas Tugas</td>
                        <td>
                            @if($tugas->prioritas === 'tinggi')
                                <span class="badge bg-danger">Tinggi</span>
                            @elseif($tugas->prioritas === 'sedang')
                                <span class="badge bg-warning text-dark">Sedang</span>
                            @else
                                <span class="badge bg-secondary">Rendah</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Tgl Ditugaskan</td>
                        <td>{{ \Carbon\Carbon::parse($tugas->tanggal_ditugaskan)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0 align-top">Deskripsi Kerusakan</td>
                        <td>{{ $tugas->laporan->deskripsi_kerusakan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Foto Laporan --}}
        @if($tugas->laporan->fotoLaporan->count() > 0)
        <div class="card border-0 shadow-sm rounded-3 mt-4">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">Foto Kerusakan</h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    @foreach($tugas->laporan->fotoLaporan as $foto)
                    <div class="col-4">
                        <img src="{{ asset('storage/foto_laporan/' . $foto->nama_file) }}"
                             class="img-fluid rounded"
                             style="height:150px;width:100%;object-fit:cover"
                             onerror="this.src='https://via.placeholder.com/150?text=Foto'">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Kolom Kanan: Form Selesaikan Tugas --}}
    <div class="col-md-4">
        @if(!$tugas->tanggal_selesai)
        {{-- Tugas belum selesai, tampilkan form --}}
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">Selesaikan Tugas</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('teknisi.tugas.selesai', $tugas->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Tindakan Perbaikan <span class="text-danger">*</span>
                        </label>
                        <textarea name="tindakan_perbaikan" rows="4"
                                  class="form-control form-control-sm @error('tindakan_perbaikan') is-invalid @enderror"
                                  placeholder="Jelaskan tindakan yang dilakukan...">{{ old('tindakan_perbaikan') }}</textarea>
                        @error('tindakan_perbaikan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimal 10 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Catatan Tambahan</label>
                        <textarea name="catatan_teknisi" rows="2"
                                  class="form-control form-control-sm"
                                  placeholder="Catatan opsional...">{{ old('catatan_teknisi') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 btn-sm"
                            onclick="return confirm('Tandai tugas ini sebagai selesai?')">
                        <i class="bi bi-check-lg me-1"></i> Tandai Selesai
                    </button>
                </form>
            </div>
        </div>
        @else
        {{-- Tugas sudah selesai, tampilkan hasil --}}
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0 text-success">
                    <i class="bi bi-check-circle-fill me-1"></i> Tugas Selesai
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="text-muted small">Tanggal Selesai</div>
                    <div class="fw-semibold">
                        {{ \Carbon\Carbon::parse($tugas->tanggal_selesai)->format('d F Y') }}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small">Tindakan Perbaikan</div>
                    <div>{{ $tugas->tindakan_perbaikan }}</div>
                </div>
                @if($tugas->catatan_teknisi)
                <div>
                    <div class="text-muted small">Catatan</div>
                    <div>{{ $tugas->catatan_teknisi }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@endsection