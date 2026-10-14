<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    public $timestamps = false;

    protected $fillable = [
        'pengguna_id', 'laporan_id', 'judul', 'pesan', 'sudah_dibaca'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}