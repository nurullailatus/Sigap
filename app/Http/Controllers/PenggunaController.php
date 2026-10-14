<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::all();

        return view('pengguna.index', compact('pengguna'));
    }
}