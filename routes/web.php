<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\RuanganController;

//route log viewer
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Route Admin
use App\Http\Controllers\Admin\DashboardController;

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

use App\Http\Controllers\Admin\StatistikController;

Route::get('/admin/statistik', [StatistikController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.statistik.index');
    
// Route Laporan Admin
Route::get('/admin/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])
    ->middleware(['auth', 'admin'])->name('admin.laporan.index');

Route::get('/admin/laporan/{id}', [App\Http\Controllers\Admin\LaporanController::class, 'show'])
    ->middleware(['auth', 'admin'])->name('admin.laporan.show');

Route::post('/admin/laporan/{id}/terima', [App\Http\Controllers\Admin\LaporanController::class, 'terima'])
    ->middleware(['auth', 'admin'])->name('admin.laporan.terima');

Route::post('/admin/laporan/{id}/tolak', [App\Http\Controllers\Admin\LaporanController::class, 'tolak'])
    ->middleware(['auth', 'admin'])->name('admin.laporan.tolak');

Route::post('/admin/laporan/{id}/tugaskan', [App\Http\Controllers\Admin\LaporanController::class, 'tugaskan'])
    ->middleware(['auth', 'admin'])->name('admin.laporan.tugaskan');

Route::get('/admin/penugasan', [App\Http\Controllers\Admin\PenugasanController::class, 'index'])
    ->middleware(['auth', 'admin'])->name('admin.penugasan.index');

// ===== ROUTE PELAPOR =====
Route::get('/pelapor/dashboard', [App\Http\Controllers\Pelapor\DashboardController::class, 'index'])
    ->middleware('auth')->name('pelapor.dashboard');

Route::get('/pelapor/laporan', [App\Http\Controllers\Pelapor\LaporanController::class, 'index'])
    ->middleware('auth')->name('pelapor.laporan.index');

Route::get('/pelapor/laporan/buat', [App\Http\Controllers\Pelapor\LaporanController::class, 'create'])
    ->middleware('auth')->name('pelapor.laporan.create');

Route::post('/pelapor/laporan', [App\Http\Controllers\Pelapor\LaporanController::class, 'store'])
    ->middleware('auth')->name('pelapor.laporan.store');

Route::get('/pelapor/laporan/{id}', [App\Http\Controllers\Pelapor\LaporanController::class, 'show'])
    ->middleware('auth')->name('pelapor.laporan.show');

Route::get('/pelapor/profil', function () {
    return view('pelapor.profil');})
    ->middleware('auth')->name('pelapor.profil');

// API perangkat by ruangan (untuk dropdown dinamis)
Route::get('/api/perangkat/{ruanganId}', [App\Http\Controllers\Pelapor\LaporanController::class, 'getPerangkat'])
    ->middleware('auth')->name('api.perangkat');

    
// ===== ROUTE TEKNISI =====
Route::get('/teknisi/dashboard', [App\Http\Controllers\Teknisi\DashboardController::class, 'index'])
    ->middleware('auth')->name('teknisi.dashboard');

Route::get('/teknisi/tugas', [App\Http\Controllers\Teknisi\TugasController::class, 'index'])
    ->middleware('auth')->name('teknisi.tugas.index');

Route::get('/teknisi/tugas/{id}', [App\Http\Controllers\Teknisi\TugasController::class, 'show'])
    ->middleware('auth')->name('teknisi.tugas.show');

Route::post('/teknisi/tugas/{id}/selesai', [App\Http\Controllers\Teknisi\TugasController::class, 'selesai'])
    ->middleware('auth')->name('teknisi.tugas.selesai');

// Data Pengguna
Route::get('/admin/pengguna', [App\Http\Controllers\Admin\PenggunaController::class, 'index'])
    ->middleware(['auth', 'admin'])->name('admin.pengguna.index');

Route::get('/admin/pengguna/tambah', [App\Http\Controllers\Admin\PenggunaController::class, 'create'])
    ->middleware(['auth', 'admin'])->name('admin.pengguna.create');

Route::post('/admin/pengguna', [App\Http\Controllers\Admin\PenggunaController::class, 'store'])
    ->middleware(['auth', 'admin'])->name('admin.pengguna.store');

Route::post('/admin/pengguna/{id}/toggle', [App\Http\Controllers\Admin\PenggunaController::class, 'toggleStatus'])
    ->middleware(['auth', 'admin'])->name('admin.pengguna.toggle');

// Data Perangkat
Route::get('/admin/perangkat', [App\Http\Controllers\Admin\PerangkatController::class, 'index'])
    ->middleware(['auth', 'admin'])->name('admin.perangkat.index');
Route::get('/admin/perangkat/tambah', [App\Http\Controllers\Admin\PerangkatController::class, 'create'])
    ->middleware(['auth', 'admin'])->name('admin.perangkat.create');
Route::post('/admin/perangkat', [App\Http\Controllers\Admin\PerangkatController::class, 'store'])
    ->middleware(['auth', 'admin'])->name('admin.perangkat.store');
Route::get('/admin/perangkat/{id}/edit', [App\Http\Controllers\Admin\PerangkatController::class, 'edit'])
    ->middleware(['auth', 'admin'])->name('admin.perangkat.edit');
Route::put('/admin/perangkat/{id}', [App\Http\Controllers\Admin\PerangkatController::class, 'update'])
    ->middleware(['auth', 'admin'])->name('admin.perangkat.update');

// Data Ruangan
Route::get('/admin/ruangan', [RuanganController::class, 'index'])
    ->middleware(['auth', 'admin'])->name('admin.ruangan.index');
Route::get('/admin/ruangan/tambah', [RuanganController::class, 'create'])
    ->middleware(['auth', 'admin'])->name('admin.ruangan.tambah');
Route::post('/admin/ruangan/store', [RuanganController::class, 'store'])
    ->middleware(['auth', 'admin'])->name('admin.ruangan.store');
Route::get('/admin/ruangan/{id}/edit', [RuanganController::class, 'edit'])
    ->middleware(['auth', 'admin'])->name('admin.ruangan.edit');
Route::put('/admin/ruangan/{id}/update', [RuanganController::class, 'update'])
    ->middleware(['auth', 'admin'])->name('admin.ruangan.update');