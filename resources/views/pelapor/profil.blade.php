@extends('layouts.app')

@section('page-title', 'Profil Saya')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body text-center py-4">
                {{-- Avatar --}}
                <div class="mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama) }}&background=1a2744&color=fff&size=80"
                         class="rounded-circle" width="80" height="80">
                </div>
                <h5 class="fw-bold mb-1">{{ auth()->user()->nama }}</h5>
                <span class="badge bg-warning text-dark mb-3">Pelapor</span>

                <hr>

                <table class="table table-borderless text-start mb-0">
                    <tr>
                        <td class="text-muted" style="width:140px">Email</td>
                        <td class="fw-semibold">{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">NIM / NIP</td>
                        <td>{{ auth()->user()->nim_nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. HP</td>
                        <td>{{ auth()->user()->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status Akun</td>
                        <td>
                            <span class="badge bg-success">Aktif</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection