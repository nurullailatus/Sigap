<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Halaman daftar semua laporan
    public function index(Request $request)
    {
        $query = Laporan::with(['pengguna', 'ruangan', 'kategori', 'perangkat']);

        // Filter by status kalau ada
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $laporan = $query->latest()->paginate(10);

        return view('admin.laporan.index', compact('laporan'));
    }

    // Halaman detail satu laporan
    public function show($id)
    {
        $laporan = Laporan::with([
            'pengguna', 'ruangan', 'kategori',
            'perangkat', 'fotoLaporan', 'penugasan.teknisi'
        ])->findOrFail($id);

        $teknisiList = Pengguna::where('role', 'teknisi')
                               ->where('status', 'aktif')
                               ->get();

        return view('admin.laporan.show', compact('laporan', 'teknisiList'));
    }

    // Proses terima laporan
    public function terima($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status' => 'diproses',
            'catatan_admin' => 'Laporan diterima dan sedang diproses.'
        ]);

        return redirect()->route('admin.laporan.show', $id)
                         ->with('success', 'Laporan berhasil diterima!');
    }

    // Proses tolak laporan
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|min:10'
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status' => 'ditolak',
            'alasan_ditolak' => $request->alasan_ditolak
        ]);

        return redirect()->route('admin.laporan.show', $id)
                         ->with('success', 'Laporan berhasil ditolak.');
    }
}