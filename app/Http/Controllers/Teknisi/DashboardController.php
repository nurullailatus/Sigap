<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Hitung statistik tugas milik teknisi yang login
        $totalTugas    = Penugasan::where('teknisi_id', $userId)->count();
        $tugasBerjalan = Penugasan::where('teknisi_id', $userId)
                            ->whereNull('tanggal_selesai')->count();
        $tugasSelesai  = Penugasan::where('teknisi_id', $userId)
                            ->whereNotNull('tanggal_selesai')->count();

        // 5 tugas terbaru milik teknisi ini
        $tugasTerbaru = Penugasan::with(['laporan.ruangan', 'laporan.perangkat', 'laporan.kategori'])
                            ->where('teknisi_id', $userId)
                            ->latest()
                            ->take(5)
                            ->get();

        return view('teknisi.dashboard', compact(
            'totalTugas', 'tugasBerjalan', 'tugasSelesai', 'tugasTerbaru'
        ));
    }
}