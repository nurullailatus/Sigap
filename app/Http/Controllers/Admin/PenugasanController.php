<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;

class PenugasanController extends Controller
{
    public function index()
    {
        $penugasan = Penugasan::with(['laporan', 'teknisi'])
                    ->latest()
                    ->paginate(10);

        return view('admin.penugasan.index', compact('penugasan'));
    }
}