<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalLaporan'  => Laporan::count(),
            'menunggu'      => Laporan::where('status', 'menunggu')->count(),
            'diproses'      => Laporan::where('status', 'diproses')->count(),
            'selesai'       => Laporan::where('status', 'selesai')->count(),
            'laporanTerbaru'=> Laporan::with(['pengguna', 'ruangan', 'kategori'])
                                ->latest()
                                ->take(5)
                                ->get(),
        ]);
    }
}