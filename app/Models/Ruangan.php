<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';

    protected $fillable = ['gedung_id', 'kode_ruangan', 'nama_ruangan'];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'gedung_id');
    }

    public function perangkat()
    {
        return $this->hasMany(Perangkat::class, 'ruangan_id');
    }
}