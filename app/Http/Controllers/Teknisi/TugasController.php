<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;
use App\Models\Laporan;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    // Daftar semua tugas milik teknisi
    public function index()
    {
        $tugas = Penugasan::with(['laporan.ruangan', 'laporan.perangkat', 'laporan.kategori'])
                    ->where('teknisi_id', auth()->id())
                    ->latest()
                    ->paginate(10);

        return view('teknisi.tugas.index', compact('tugas'));
    }

    // Detail satu tugas
    public function show($id)
    {
        // Pastikan tugas ini memang milik teknisi yang login
        $tugas = Penugasan::with([
                    'laporan.ruangan',
                    'laporan.perangkat',
                    'laporan.kategori',
                    'laporan.fotoLaporan',
                    'laporan.pengguna'
                ])
                ->where('teknisi_id', auth()->id())
                ->findOrFail($id);

        return view('teknisi.tugas.show', compact('tugas'));
    }

    // Proses tandai tugas selesai
    public function selesai(Request $request, $id)
    {
        $request->validate([
            'tindakan_perbaikan' => 'required|min:10',
            'catatan_teknisi'    => 'nullable',
        ]);

        $tugas = Penugasan::where('teknisi_id', auth()->id())
                    ->findOrFail($id);

        // Update data penugasan
        $tugas->update([
            'tindakan_perbaikan' => $request->tindakan_perbaikan,
            'catatan_teknisi'    => $request->catatan_teknisi,
            'tanggal_selesai'    => now()->toDateString(),
        ]);

        // Update status laporan jadi selesai
        Laporan::where('id', $tugas->laporan_id)
               ->update(['status' => 'selesai']);

        return redirect()->route('teknisi.tugas.show', $id)
                         ->with('success', 'Tugas berhasil ditandai selesai!');
    }
}