<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Models\Gedung;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    // Tampilkan list semua ruangan
    public function index()
    {
        $ruangan = Ruangan::with('gedung')->paginate(10);
        return view('admin.ruangan.index', compact('ruangan'));
    }

    // Form tambah ruangan
    public function create()
    {
        $gedung = Gedung::all();
        return view('admin.ruangan.create', compact('gedung'));
    }

    // Simpan ruangan baru
    public function store(Request $request)
    {
        $request->validate([
            'gedung_id'     => 'required|exists:gedung,id',
            'kode_ruangan'  => 'required|unique:ruangan,kode_ruangan',
            'nama_ruangan'  => 'required|string|max:100',
        ]);

        Ruangan::create($request->only('gedung_id', 'kode_ruangan', 'nama_ruangan'));

        return redirect()->route('admin.ruangan.index')
                         ->with('success', 'Ruangan berhasil ditambahkan!');
    }

    // Form edit ruangan
    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $gedung  = Gedung::all();
        return view('admin.ruangan.edit', compact('ruangan', 'gedung'));
    }

    // Simpan perubahan ruangan
    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        $request->validate([
            'gedung_id'    => 'required|exists:gedung,id',
            'kode_ruangan' => 'required|unique:ruangan,kode_ruangan,' . $id,
            'nama_ruangan' => 'required|string|max:100',
        ]);

        $ruangan->update($request->only('gedung_id', 'kode_ruangan', 'nama_ruangan'));

        return redirect()->route('admin.ruangan.index')
                         ->with('success', 'Ruangan berhasil diperbarui!');
    }
}