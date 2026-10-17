<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKerusakan;
use App\Models\Laporan;
use App\Models\Pengguna;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Halaman daftar semua laporan
    public function index(Request $request)
    {
        $query = Laporan::with(['pengguna', 'ruangan', 'kategori', 'perangkat']);

        $filters = $request->validate([
            'status' => ['nullable', 'in:menunggu,diproses,selesai,ditolak'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'kategori_id' => ['nullable', 'integer', 'exists:kategori_kerusakan,id'],
            'ruangan_id' => ['nullable', 'integer', 'exists:ruangan,id'],
        ]);

        $query->when($filters['status'] ?? null, fn ($query, string $status) =>
            $query->where('status', $status))
            ->when($filters['tanggal_mulai'] ?? null, fn ($query, string $date) =>
                $query->whereDate('tanggal_laporan', '>=', $date))
            ->when($filters['tanggal_selesai'] ?? null, fn ($query, string $date) =>
                $query->whereDate('tanggal_laporan', '<=', $date))
            ->when($filters['kategori_id'] ?? null, fn ($query, int $categoryId) =>
                $query->where('kategori_kerusakan_id', $categoryId))
            ->when($filters['ruangan_id'] ?? null, fn ($query, int $roomId) =>
                $query->where('ruangan_id', $roomId));

        $laporan = $query->latest()->paginate(10)->withQueryString();

        return view('admin.laporan.index', [
            'laporan' => $laporan,
            'filters' => $filters,
            'categories' => KategoriKerusakan::orderBy('nama_kategori')->get(),
            'rooms' => Ruangan::orderBy('nama_ruangan')->get(),
        ]);
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

    // Proses tugaskan ke teknisi
    public function tugaskan(Request $request, $id)
    {
        $request->validate([
            'teknisi_id' => 'required|exists:pengguna,id',
            'prioritas'  => 'required|in:rendah,sedang,tinggi',
        ]);

        $laporan = Laporan::findOrFail($id);

        // Simpan data penugasan
        \App\Models\Penugasan::create([
            'laporan_id'         => $laporan->id,
            'teknisi_id'         => $request->teknisi_id,
            'admin_id'           => auth()->id(),
            'prioritas'          => $request->prioritas,
            'tanggal_ditugaskan' => now()->toDateString(),
        ]);

        // Update status laporan jadi diproses
        $laporan->update(['status' => 'diproses']);

        return redirect()->route('admin.laporan.show', $id)
                        ->with('success', 'Teknisi berhasil ditugaskan!');
        }
}