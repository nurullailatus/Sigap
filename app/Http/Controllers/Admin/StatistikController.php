<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKerusakan;
use App\Models\Laporan;
use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['nullable', 'in:menunggu,diproses,selesai,ditolak'],
            'kategori_id' => ['nullable', 'integer', 'exists:kategori_kerusakan,id'],
            'ruangan_id' => ['nullable', 'integer', 'exists:ruangan,id'],
        ]);

        $query = $this->filteredQuery($filters);

        $statusTotals = [
            'menunggu' => (clone $query)->where('status', 'menunggu')->count(),
            'diproses' => (clone $query)->where('status', 'diproses')->count(),
            'selesai' => (clone $query)->where('status', 'selesai')->count(),
            'ditolak' => (clone $query)->where('status', 'ditolak')->count(),
        ];

        $berdasarkanUrgensi = (clone $query)
            ->selectRaw('tingkat_urgensi, COUNT(*) as total')
            ->groupBy('tingkat_urgensi')
            ->pluck('total', 'tingkat_urgensi');

        $berdasarkanKategori = (clone $query)
            ->selectRaw('kategori_kerusakan_id, COUNT(*) as total')
            ->groupBy('kategori_kerusakan_id')
            ->with('kategori')
            ->get()
            ->map(fn (Laporan $laporan) => [
                'label' => $laporan->kategori?->nama_kategori ?? 'Tidak diketahui',
                'total' => $laporan->total,
            ]);

        $monthExpression = DB::connection()->getDriverName() === 'mysql'
            ? "DATE_FORMAT(tanggal_laporan, '%Y-%m')"
            : "strftime('%Y-%m', tanggal_laporan)";

        $perBulan = (clone $query)
            ->selectRaw("$monthExpression as bulan, COUNT(*) as total")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->map(fn (Laporan $laporan) => [
                'label' => $laporan->bulan,
                'total' => $laporan->total,
            ]);

        return view('admin.statistik.index', compact(
            'filters',
            'berdasarkanKategori',
            'perBulan',
            'berdasarkanUrgensi',
            'statusTotals'
        ) + [
            'total' => array_sum($statusTotals),
            'categories' => KategoriKerusakan::orderBy('nama_kategori')->get(),
            'rooms' => Ruangan::orderBy('nama_ruangan')->get(),
        ]);
    }

    private function filteredQuery(array $filters): Builder
    {
        return Laporan::query()
            ->when($filters['tanggal_mulai'] ?? null, fn (Builder $query, string $date) =>
                $query->whereDate('tanggal_laporan', '>=', $date))
            ->when($filters['tanggal_selesai'] ?? null, fn (Builder $query, string $date) =>
                $query->whereDate('tanggal_laporan', '<=', $date))
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) =>
                $query->where('status', $status))
            ->when($filters['kategori_id'] ?? null, fn (Builder $query, int $categoryId) =>
                $query->where('kategori_kerusakan_id', $categoryId))
            ->when($filters['ruangan_id'] ?? null, fn (Builder $query, int $roomId) =>
                $query->where('ruangan_id', $roomId));
    }
}