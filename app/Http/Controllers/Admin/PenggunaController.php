<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    // Daftar semua pengguna
    public function index()
    {
        $pengguna = Pengguna::latest()->paginate(10);
        return view('admin.pengguna.index', compact('pengguna'));
    }

    // Form tambah pengguna
    public function create()
    {
        return view('admin.pengguna.create');
    }

    // Simpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|max:100',
            'email'    => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:pelapor,admin,teknisi',
            'nim_nip'  => 'nullable|max:20',
            'no_hp'    => 'nullable|max:20',
        ]);

        Pengguna::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'nim_nip'  => $request->nim_nip,
            'no_hp'    => $request->no_hp,
            'status'   => 'aktif',
        ]);

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // Nonaktifkan / aktifkan pengguna
    public function toggleStatus($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->update([
            'status' => $pengguna->status === 'aktif' ? 'nonaktif' : 'aktif'
        ]);

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Status pengguna berhasil diubah!');
    }
}