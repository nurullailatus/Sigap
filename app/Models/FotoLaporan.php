<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoLaporan extends Model
{
    protected $table = 'foto_laporan';
    public $timestamps = false;
    protected $fillable = ['laporan_id', 'nama_file', 'urutan'];
}