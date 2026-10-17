<?php

namespace App\Http\Controllers\Pelapor;

use App\Http\Controllers\Controller;
use App\Models\Laporan;

class DashboardController extends Controller
{
    public function index()
    {
        // auth()->id() = ambil ID user yang lagi login
        // where('pengguna_id') = filter laporan milik dia aja
        $userId = auth()->id();

        return view('pelapor.dashboard', [
            'totalLaporan' => Laporan::where('pengguna_id', $userId)->count(),
            'menunggu'     => Laporan::where('pengguna_id', $userId)->where('status', 'menunggu')->count(),
            'diproses'     => Laporan::where('pengguna_id', $userId)->where('status', 'diproses')->count(),
            'selesai'      => Laporan::where('pengguna_id', $userId)->where('status', 'selesai')->count(),
            'laporanTerbaru' => Laporan::with(['ruangan', 'kategori', 'perangkat'])
                                ->where('pengguna_id', $userId)
                                ->latest()
                                ->take(5)
                                ->get(),
        ]);
    }
}