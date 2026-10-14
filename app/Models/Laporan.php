<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'kode_laporan', 'pengguna_id', 'ruangan_id', 'perangkat_id',
        'kategori_kerusakan_id', 'deskripsi_kerusakan', 'tingkat_urgensi',
        'status', 'alasan_ditolak', 'catatan_admin', 'tanggal_laporan'
    ];

    // Relasi ke tabel pengguna (siapa yang lapor)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    // Relasi ke tabel ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    // Relasi ke tabel kategori_kerusakan
    public function kategori()
    {
        return $this->belongsTo(KategoriKerusakan::class, 'kategori_kerusakan_id');
    }

    // Relasi ke tabel perangkat
    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class, 'perangkat_id');
    }

    protected $casts = [
        'tanggal_laporan' => 'datetime',
    ];

    // Relasi ke foto laporan
    public function fotoLaporan()
    {
        return $this->hasMany(FotoLaporan::class, 'laporan_id')
                    ->orderBy('urutan');
    }

    // Relasi ke penugasan
    public function penugasan()
    {
        return $this->hasMany(Penugasan::class, 'laporan_id');
    }
}
