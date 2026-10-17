@extends('layouts.app')

@section('page-title', 'Edit Ruangan')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.ruangan.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Ruangan
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold">Edit Ruangan</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.ruangan.update', $ruangan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Gedung <span class="text-danger">*</span></label>
                <select name="gedung_id" class="form-select @error('gedung_id') is-invalid @enderror">
                    <option value="">-- Pilih Gedung --</option>
                    @foreach($gedung as $g)
                        <option value="{{ $g->id }}"
                            {{ old('gedung_id', $ruangan->gedung_id) == $g->id ? 'selected' : '' }}>
                            {{ $g->nama_gedung }}
                        </option>
                    @endforeach
                </select>
                @error('gedung_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Kode Ruangan <span class="text-danger">*</span></label>
                <input type="text" name="kode_ruangan"
                       class="form-control @error('kode_ruangan') is-invalid @enderror"
                       value="{{ old('kode_ruangan', $ruangan->kode_ruangan) }}">
                @error('kode_ruangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Nama Ruangan <span class="text-danger">*</span></label>
                <input type="text" name="nama_ruangan"
                       class="form-control @error('nama_ruangan') is-invalid @enderror"
                       value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}">
                @error('nama_ruangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Update
                </button>
                <a href="{{ route('admin.ruangan.index') }}" class="btn btn-outline-secondary px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection