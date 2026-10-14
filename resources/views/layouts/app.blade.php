<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP - {{ $title ?? 'Dashboard' }}</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Warna utama SIGAP - navy gelap seperti desain Figma */
        :root {
            --sidebar-bg: #1a2744;
            --sidebar-active: #2d3f6e;
            --sidebar-text: #a8b4d0;
            --sidebar-text-active: #ffffff;
            --topbar-height: 60px;
            --sidebar-width: 240px;
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ===== SIDEBAR ===== */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand img {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .sidebar-brand span {
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            letter-spacing: 1px;
        }

        /* Info user di sidebar */
        .sidebar-user {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-user img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .sidebar-user .user-info small {
            color: var(--sidebar-text);
            font-size: 0.7rem;
        }

        .sidebar-user .user-info strong {
            color: white;
            font-size: 0.82rem;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        /* Badge role (Admin/Pelapor/Teknisi) */
        .role-badge {
            font-size: 0.6rem;
            padding: 2px 7px;
            border-radius: 10px;
            text-transform: capitalize;
        }

        /* Menu navigasi */
        .sidebar-nav {
            flex: 1;
            padding: 10px 0;
        }

        .nav-section-title {
            color: var(--sidebar-text);
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 20px 4px;
        }

        .sidebar-nav .nav-link {
            color: var(--sidebar-text);
            padding: 9px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
            border-radius: 0;
            transition: all 0.2s;
        }

        .sidebar-nav .nav-link:hover {
            color: var(--sidebar-text-active);
            background-color: rgba(255,255,255,0.08);
        }

        .sidebar-nav .nav-link.active {
            color: var(--sidebar-text-active);
            background-color: var(--sidebar-active);
            border-left: 3px solid #4e9af1;
        }

        .sidebar-nav .nav-link i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        /* Tombol keluar di bawah sidebar */
        .sidebar-footer {
            padding: 12px 16px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .btn-logout {
            width: 100%;
            background: rgba(255,255,255,0.08);
            color: #ff7b7b;
            border: none;
            padding: 8px;
            border-radius: 8px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-logout:hover {
            background: rgba(255, 100, 100, 0.2);
            color: #ff5555;
        }

        /* ===== TOPBAR ===== */
        #topbar {
            height: var(--topbar-height);
            background: white;
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }

        #topbar .page-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a2744;
            margin: 0;
        }

        /* ===== AREA KONTEN UTAMA ===== */
        #main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 24px;
            min-height: calc(100vh - var(--topbar-height));
        }
    </style>
</head>
<body>

{{-- ===== SIDEBAR ===== --}}
<div id="sidebar">

    {{-- Logo + Nama Sistem --}}
    <div class="sidebar-brand">
        <img src="{{ asset('logo_unuja.png') }}" alt="Logo UNUJA">
        <span>SIGAP</span>
    </div>

    {{-- Info User yang Login --}}
    <div class="sidebar-user">
        <img src="{{ auth()->user()->foto_profil
            ? asset('storage/' . auth()->user()->foto_profil)
            : asset('images/default-avatar.png') }}"
            alt="Foto Profil">
        <div class="user-info">
            <strong title="{{ auth()->user()->nama }}">{{ auth()->user()->nama }}</strong>
            {{-- Badge warna berbeda tiap role --}}
            @if(auth()->user()->role === 'admin')
                <span class="role-badge bg-primary text-white">Admin</span>
            @elseif(auth()->user()->role === 'teknisi')
                <span class="role-badge bg-success text-white">Teknisi</span>
            @else
                <span class="role-badge bg-warning text-dark">Pelapor</span>
            @endif
        </div>
    </div>

    {{-- Menu Navigasi: tampil berbeda sesuai role --}}
    <nav class="sidebar-nav">
        @if(auth()->user()->role === 'admin')
            {{-- MENU ADMIN --}}
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="#" class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill"></i> Laporan Masuk
            </a>
            <a href="#" class="nav-link {{ request()->routeIs('admin.penugasan*') ? 'active' : '' }}">
                <i class="bi bi-person-check-fill"></i> Penugasan Teknisi
            </a>

            <div class="nav-section-title">Data Master</div>
            <a href="#" class="nav-link {{ request()->routeIs('admin.perangkat*') ? 'active' : '' }}">
                <i class="bi bi-cpu-fill"></i> Data Perangkat
            </a>
            <a href="#" class="nav-link {{ request()->routeIs('admin.ruangan*') ? 'active' : '' }}">
                <i class="bi bi-building-fill"></i> Data Ruangan & Gedung
            </a>
            <a href="#" class="nav-link {{ request()->routeIs('admin.pengguna*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Data Pengguna
            </a>
            <a href="#" class="nav-link {{ request()->routeIs('admin.statistik*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i> Statistik & Laporan
            </a>

        @elseif(auth()->user()->role === 'teknisi')
            {{-- MENU TEKNISI --}}
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('teknisi.dashboard') }}"
               class="nav-link {{ request()->routeIs('teknisi.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-tools"></i> Tugas Saya
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-clock-history"></i> Riwayat Perbaikan
            </a>

        @else
            {{-- MENU PELAPOR --}}
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('pelapor.dashboard') }}"
               class="nav-link {{ request()->routeIs('pelapor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-plus-circle-fill"></i> Buat Laporan
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-clock-history"></i> Riwayat Laporan
            </a>
        @endif
    </nav>

    {{-- Tombol Logout --}}
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </button>
        </form>
    </div>
</div>

{{-- ===== TOPBAR ===== --}}
<div id="topbar">
    <h5 class="page-title">@yield('page-title', 'Dashboard')</h5>
    <div class="d-flex align-items-center gap-3">
        {{-- Ikon notifikasi --}}
        <a href="#" class="text-secondary position-relative">
            <i class="bi bi-bell-fill fs-5"></i>
            @php
                $unread = auth()->user()->notifikasi()->where('sudah_dibaca', 0)->count();
            @endphp
            @if($unread > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                      style="font-size:0.6rem">
                    {{ $unread }}
                </span>
            @endif
        </a>
        {{-- Foto profil di topbar --}}
        <img src="{{ auth()->user()->foto_profil
            ? asset('storage/' . auth()->user()->foto_profil)
            : asset('images/default-avatar.png') }}"
            alt="Profil"
            style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid #e0e0e0">
    </div>
</div>

{{-- ===== AREA KONTEN ===== --}}
<div id="main-content">
    @yield('content')
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>