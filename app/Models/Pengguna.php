<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';

    protected $fillable = [
        'nama', 'email', 'password', 'role',
        'nim_nip', 'no_hp', 'foto_profil', 'status'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Relasi ke notifikasi
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'pengguna_id');
    }
}