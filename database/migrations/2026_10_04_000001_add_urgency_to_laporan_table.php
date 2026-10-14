<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('laporan', 'tingkat_urgensi')) {
            Schema::table('laporan', function (Blueprint $table): void {
                $table->string('tingkat_urgensi', 10)->default('rendah')->after('status');
            });
        }

        $kategori = [
            1 => 5, // Proyektor: Audio Visual
            2 => 1, // Komputer tidak booting: Hardware
            3 => 2, // Router terputus: Jaringan
            4 => 1, // AC: Hardware
            5 => 1, // Printer: Hardware
        ];

        $urgensi = [
            1 => 'tinggi',
            2 => 'tinggi',
            3 => 'sedang',
            4 => 'sedang',
            5 => 'rendah',
        ];

        foreach ($kategori as $laporanId => $kategoriId) {
            DB::table('laporan')
                ->where('id', $laporanId)
                ->whereNull('kategori_kerusakan_id')
                ->update(['kategori_kerusakan_id' => $kategoriId]);
        }

        foreach ($urgensi as $laporanId => $nilai) {
            DB::table('laporan')
                ->where('id', $laporanId)
                ->where(function ($query): void {
                    $query->whereNull('tingkat_urgensi')
                        ->orWhere('tingkat_urgensi', 'rendah');
                })
                ->update(['tingkat_urgensi' => $nilai]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('laporan', 'tingkat_urgensi')) {
            Schema::table('laporan', function (Blueprint $table): void {
                $table->dropColumn('tingkat_urgensi');
            });
        }
    }
};
