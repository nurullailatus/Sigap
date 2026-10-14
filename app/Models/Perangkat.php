<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    protected $table = 'perangkat';
    protected $fillable = [
        'ruangan_id', 'kode_perangkat',
        'nama_perangkat', 'merk_model', 'kondisi'
    ];
}