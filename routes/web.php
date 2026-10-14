<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Pelapor
Route::get('/pelapor/dashboard', function () {
    return view('pelapor.dashboard');
})->middleware('auth')->name('pelapor.dashboard');

// Admin
use App\Http\Controllers\Admin\DashboardController;

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('admin.dashboard');
    
// Teknisi
Route::get('/teknisi/dashboard', function () {
    return view('teknisi.dashboard');
})->middleware('auth')->name('teknisi.dashboard');

// Route Laporan Admin
Route::get('/admin/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])
    ->middleware('auth')->name('admin.laporan.index');

Route::get('/admin/laporan/{id}', [App\Http\Controllers\Admin\LaporanController::class, 'show'])
    ->middleware('auth')->name('admin.laporan.show');

Route::post('/admin/laporan/{id}/terima', [App\Http\Controllers\Admin\LaporanController::class, 'terima'])
    ->middleware('auth')->name('admin.laporan.terima');

Route::post('/admin/laporan/{id}/tolak', [App\Http\Controllers\Admin\LaporanController::class, 'tolak'])
    ->middleware('auth')->name('admin.laporan.tolak');