<?php

namespace App\Http\Controllers\Pelapor;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Ruangan;
use App\Models\Perangkat;
use App\Models\KategoriKerusakan;
use App\Models\FotoLaporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Halaman form buat laporan baru
    public function create()
    {
        $ruangan   = Ruangan::orderBy('nama_ruangan')->get();
        $kategori  = KategoriKerusakan::orderBy('nama_kategori')->get();

        return view('pelapor.create', compact('ruangan', 'kategori'));
    }

    // Proses simpan laporan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'ruangan_id'          => 'required|exists:ruangan,id',
            'perangkat_id'        => 'required|exists:perangkat,id',
            'kategori_kerusakan_id' => 'required|exists:kategori_kerusakan,id',
            'deskripsi_kerusakan' => 'required|min:20',
            'tingkat_urgensi'     => 'required|in:rendah,sedang,tinggi',
            'foto.*'              => 'nullable|image|max:2048',
        ]);

        // Buat kode laporan otomatis: LPR-2026-0006
        $tahun      = date('Y');
        $lastLaporan = Laporan::whereYear('created_at', $tahun)->count();
        $kodeLaporan = 'LPR-' . $tahun . '-' . str_pad($lastLaporan + 1, 4, '0', STR_PAD_LEFT);

        // Simpan laporan ke database
        $laporan = Laporan::create([
            'kode_laporan'        => $kodeLaporan,
            'pengguna_id'         => auth()->id(),
            'ruangan_id'          => $request->ruangan_id,
            'perangkat_id'        => $request->perangkat_id,
            'kategori_kerusakan_id' => $request->kategori_kerusakan_id,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'tingkat_urgensi'     => $request->tingkat_urgensi,
            'status'              => 'menunggu',
            'tanggal_laporan'     => now(),
        ]);

        // Simpan foto kalau ada yang diupload
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $urutan => $file) {
                $namaFile = time() . '_' . $urutan . '.' . $file->extension();
                $file->storeAs('foto_laporan', $namaFile, 'public');

                FotoLaporan::create([
                    'laporan_id' => $laporan->id,
                    'nama_file'  => $namaFile,
                    'urutan'     => $urutan + 1,
                ]);
            }
        }

        return redirect()->route('pelapor.dashboard')
                         ->with('success', 'Laporan berhasil dikirim! Kode: ' . $kodeLaporan);
    }

    // Halaman riwayat semua laporan milik pelapor
    public function index()
    {
        $laporan = Laporan::with(['ruangan', 'kategori', 'perangkat'])
                    ->where('pengguna_id', auth()->id())
                    ->latest()
                    ->paginate(10);

        return view('pelapor.laporan.index', compact('laporan'));
    }

    // Detail laporan milik pelapor
    public function show($id)
    {
        // findOrFail + pastikan laporan milik dia sendiri
        $laporan = Laporan::with(['ruangan', 'kategori', 'perangkat', 'fotoLaporan', 'penugasan.teknisi'])
                    ->where('pengguna_id', auth()->id())
                    ->findOrFail($id);

        return view('pelapor.laporan.show', compact('laporan'));
    }

    // Ambil perangkat berdasarkan ruangan (untuk dropdown dinamis)
    public function getPerangkat($ruanganId)
    {
        $perangkat = Perangkat::where('ruangan_id', $ruanganId)->get();
        return response()->json($perangkat);
    }
}