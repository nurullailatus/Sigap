@extends('layouts.app')

@section('page-title', 'Data Pengguna')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
        <h6 class="fw-bold mb-0">Daftar Pengguna</h6>
        <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pengguna
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fa">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIM/NIP</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengguna as $i => $user)
                    <tr>
                        <td class="ps-3">{{ $pengguna->firstItem() + $i }}</td>
                        <td class="fw-semibold">{{ $user->nama }}</td>
                        <td class="text-muted small">{{ $user->email }}</td>
                        <td>{{ $user->nim_nip ?? '-' }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-primary">Admin</span>
                            @elseif($user->role === 'teknisi')
                                <span class="badge bg-success">Teknisi</span>
                            @else
                                <span class="badge bg-warning text-dark">Pelapor</span>
                            @endif
                        </td>
                        <td>
                            @if($user->status === 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            {{-- Jangan tampilkan tombol toggle untuk akun sendiri --}}
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.pengguna.toggle', $user->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm {{ $user->status === 'aktif' ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                        onclick="return confirm('Ubah status pengguna ini?')">
                                    {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            @else
                            <span class="text-muted small">Akun Anda</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada pengguna
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pengguna->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $pengguna->links() }}
    </div>
    @endif
</div>

@endsection