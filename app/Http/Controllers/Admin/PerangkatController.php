<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perangkat;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class PerangkatController extends Controller
{
    public function index()
    {
        $perangkat = Perangkat::with('ruangan')->latest()->paginate(10);
        return view('admin.perangkat.index', compact('perangkat'));
    }

    public function create()
    {
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        return view('admin.perangkat.create', compact('ruangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id'     => 'required|exists:ruangan,id',
            'kode_perangkat' => 'required|unique:perangkat,kode_perangkat|max:30',
            'nama_perangkat' => 'required|max:100',
            'merk_model'     => 'nullable|max:100',
            'kondisi'        => 'required|in:baik,rusak,dalam_perbaikan',
        ]);

        Perangkat::create($request->all());

        return redirect()->route('admin.perangkat.index')
                         ->with('success', 'Perangkat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $perangkat = Perangkat::findOrFail($id);
        $ruangan   = Ruangan::orderBy('nama_ruangan')->get();
        return view('admin.perangkat.edit', compact('perangkat', 'ruangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ruangan_id'     => 'required|exists:ruangan,id',
            'nama_perangkat' => 'required|max:100',
            'merk_model'     => 'nullable|max:100',
            'kondisi'        => 'required|in:baik,rusak,dalam_perbaikan',
        ]);

        $perangkat = Perangkat::findOrFail($id);
        $perangkat->update($request->all());

        return redirect()->route('admin.perangkat.index')
                         ->with('success', 'Perangkat berhasil diperbarui!');
    }
}