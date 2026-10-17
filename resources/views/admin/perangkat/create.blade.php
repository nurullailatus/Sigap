@extends('layouts.app')

@section('page-title', 'Tambah Perangkat')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.perangkat.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Perangkat
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 700px;">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold">Tambah Perangkat Baru</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.perangkat.store') }}" method="POST">
            @csrf

            {{-- Ruangan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Ruangan <span class="text-danger">*</span></label>
                <select name="ruangan_id" class="form-select @error('ruangan_id') is-invalid @enderror">
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($ruangan as $r)
                        <option value="{{ $r->id }}" {{ old('ruangan_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_ruangan }}
                        </option>
                    @endforeach
                </select>
                @error('ruangan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kode Perangkat --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Kode Perangkat <span class="text-danger">*</span></label>
                <input type="text" name="kode_perangkat"
                       class="form-control @error('kode_perangkat') is-invalid @enderror"
                       value="{{ old('kode_perangkat') }}"
                       placeholder="Contoh: PRY-001, AC-102">
                @error('kode_perangkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Kode unik untuk identifikasi perangkat</div>
            </div>

            {{-- Nama Perangkat --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Perangkat <span class="text-danger">*</span></label>
                <input type="text" name="nama_perangkat"
                       class="form-control @error('nama_perangkat') is-invalid @enderror"
                       value="{{ old('nama_perangkat') }}"
                       placeholder="Contoh: Proyektor, AC, Kipas Angin">
                @error('nama_perangkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Merk/Model --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Merk / Model</label>
                <input type="text" name="merk_model"
                       class="form-control @error('merk_model') is-invalid @enderror"
                       value="{{ old('merk_model') }}"
                       placeholder="Contoh: Epson EB-X41, LG Dual Cool">
                @error('merk_model')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Opsional, isi jika diketahui</div>
            </div>

            {{-- Kondisi --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Kondisi <span class="text-danger">*</span></label>
                <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror">
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="baik" {{ old('kondisi') === 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak" {{ old('kondisi') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="dalam_perbaikan" {{ old('kondisi') === 'dalam_perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                </select>
                @error('kondisi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.perangkat.index') }}" class="btn btn-outline-secondary px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection