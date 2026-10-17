@extends('layouts.app')

@section('page-title', 'Detail Laporan')

@section('content')
<div class="mb-3">
    <a href="{{ route('pelapor.laporan.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="fw-bold mb-0">Detail Laporan {{ $laporan->kode_laporan }}</h6>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-4">Ruangan</dt>
            <dd class="col-sm-8">{{ $laporan->ruangan->nama_ruangan ?? '-' }}</dd>
            <dt class="col-sm-4">Perangkat</dt>
            <dd class="col-sm-8">{{ $laporan->perangkat->nama_perangkat ?? '-' }}</dd>
            <dt class="col-sm-4">Kategori</dt>
            <dd class="col-sm-8">{{ $laporan->kategori->nama_kategori ?? '-' }}</dd>
            <dt class="col-sm-4">Tingkat Urgensi</dt>
            <dd class="col-sm-8">{{ ucfirst($laporan->tingkat_urgensi ?? '-') }}</dd>
            <dt class="col-sm-4">Status</dt>
            <dd class="col-sm-8">{{ ucfirst($laporan->status ?? '-') }}</dd>
            <dt class="col-sm-4">Deskripsi Kerusakan</dt>
            <dd class="col-sm-8">{{ $laporan->deskripsi_kerusakan }}</dd>
        </dl>
    </div>
</div>
@endsection
