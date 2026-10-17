<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    protected $table = 'penugasan';
    protected $fillable = [
        'laporan_id', 'teknisi_id', 'admin_id',
        'prioritas', 'tanggal_ditugaskan',
        'tanggal_selesai', 'tindakan_perbaikan', 'catatan_teknisi'
    ];

    public function teknisi()
    {
        return $this->belongsTo(Pengguna::class, 'teknisi_id');
    }

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }
}