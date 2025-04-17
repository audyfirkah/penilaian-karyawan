<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\KaryawanJurnalController;
use App\Http\Controllers\PenilaiKategoriController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\DetailPenilaianController;
use App\Http\Controllers\DashboardController;


// Rute untuk Admin, hanya bisa diakses oleh user dengan role 'admin'
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/export-jurnal', [DashboardController::class, 'exportJurnalPDF'])->name('admin.export.jurnal');



    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    Route::get('/admin/divisi', [DivisiController::class, 'index'])->name('admin.divisi.index');
    Route::get('/admin/divisi/create', [DivisiController::class, 'create'])->name('admin.divisi.create');
    Route::post('/admin/divisi', [DivisiController::class, 'store'])->name('admin.divisi.store');
    Route::get('/admin/divisi/{id}/edit', [DivisiController::class, 'edit'])->name('admin.divisi.edit');
    Route::put('/admin/divisi/{id}', [DivisiController::class, 'update'])->name('admin.divisi.update');
    Route::delete('/admin/divisi/{id}', [DivisiController::class, 'destroy'])->name('admin.divisi.destroy');

    Route::get('admin/kategori-penilaian', [KategoriController::class, 'index'])->name('admin.kategori-penilaian.index');
    Route::get('admin/kategori-penilaian/create', [KategoriController::class, 'create'])->name('admin.kategori-penilaian.create');
    Route::post('admin/kategori-penilaian', [KategoriController::class, 'store'])->name('admin.kategori-penilaian.store');
    Route::get('admin/kategori-penilaian/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori-penilaian.edit');
    Route::put('admin/kategori-penilaian/{id}', [KategoriController::class, 'update'])->name('admin.kategori-penilaian.update');
    Route::delete('admin/kategori-penilaian/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori-penilaian.destroy');

    Route::get('/admin/karyawan', [KaryawanController::class, 'index'])->name('admin.karyawan.index');
    Route::get('/admin/karyawan/create', [KaryawanController::class, 'create'])->name('admin.karyawan.create');
    Route::post('/admin/karyawan', [KaryawanController::class, 'store'])->name('admin.karyawan.store');
    Route::get('/admin/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('admin.karyawan.edit');
    Route::put('/admin/karyawan/{id}', [KaryawanController::class, 'update'])->name('admin.karyawan.update');
    Route::delete('/admin/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('admin.karyawan.destroy');
    Route::get('/admin/karyawan/{id}/detail', [KaryawanController::class, 'detail'])->name('admin.karyawan.detail');

    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/admin/laporan/{id}/create', [LaporanController::class, 'create'])->name('admin.laporan.create');
    Route::post('/admin/laporan/{id}/store', [LaporanController::class, 'store'])->name('admin.laporan.store');
    Route::get('/admin/laporan/list', [LaporanController::class, 'list'])->name('admin.laporan.list');
    Route::get('/admin/laporan/{id}/detail', [LaporanController::class, 'detail'])->name('admin.laporan.detail');

    // routes/web.php
    Route::get('admin/laporan/{id}/export', [LaporanController::class, 'exportPdf'])->name('admin.laporan.export');


    Route::get('/admin/jurnals/{id}/show', [JurnalController::class, 'show'])->name('admin.jurnal.show');
    Route::get('/admin/jurnals/{id}/edit', [JurnalController::class, 'edit'])->name('admin.jurnal.edit');
    Route::put('/admin/jurnals/{id}', [JurnalController::class, 'update'])->name('admin.jurnal.update');
    Route::delete('/admin/jurnals/{id}', [JurnalController::class, 'destroy'])->name('admin.jurnal.destroy');
    Route::post('/admin/jurnals/{id}/revisi', [JurnalController::class, 'revisi'])->name('admin.jurnal.revisi');
    Route::post('/admin/jurnals/{id}/approve', [JurnalController::class, 'approve'])->name('admin.jurnal.approve');
});

// Rute untuk Karyawan, hanya bisa diakses oleh user dengan role 'karyawan'
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/karyawan/dashboard', [DashboardController::class, 'karyawan'])->name('karyawan.dashboard');

    Route::get('/karyawan/jurnals/{id}', [KaryawanJurnalController::class, 'show'])->name('karyawan.jurnal.show');
    Route::get('/karyawan/jurnals/{id}/create', [KaryawanJurnalController::class, 'create'])->name('karyawan.jurnal.create');
    Route::post('/karyawan/jurnals/{id}', [KaryawanJurnalController::class, 'store'])->name('karyawan.jurnal.store');
    Route::get('/karyawan/jurnals/{id}/edit', [KaryawanJurnalController::class, 'edit'])->name('karyawan.jurnal.edit');
    Route::put('/karyawan/jurnals/{id}', [KaryawanJurnalController::class, 'update'])->name('karyawan.jurnal.update');
    Route::delete('/karyawan/jurnals/{id}', [KaryawanJurnalController::class, 'destroy'])->name('karyawan.jurnal.destroy');

    Route::get('/karyawan/jurnals/{id}/histori', [JurnalController::class, 'histori'])->name('karyawan.jurnal.histori');

});

// Rute untuk Penilai, hanya bisa diakses oleh user dengan role 'penilai'
Route::middleware(['auth', 'role:penilai'])->group(function () {
    Route::get('/penilai/dashboard', [DashboardController::class, 'penilai'])->name('penilai.dashboard');

    Route::get('penilai/kategori-penilaian', [PenilaiKategoriController::class, 'index'])->name('penilai.kategori-penilaian.index');
    Route::get('penilai/kategori-penilaian/create', [PenilaiKategoriController::class, 'create'])->name('penilai.kategori-penilaian.create');
    Route::post('penilai/kategori-penilaian', [PenilaiKategoriController::class, 'store'])->name('penilai.kategori-penilaian.store');
    Route::get('penilai/kategori-penilaian/{id}/edit', [PenilaiKategoriController::class, 'edit'])->name('penilai.kategori-penilaian.edit');
    Route::put('penilai/kategori-penilaian/{id}', [PenilaiKategoriController::class, 'update'])->name('penilai.kategori-penilaian.update');
    Route::delete('penilai/kategori-penilaian/{id}', [PenilaiKategoriController::class, 'destroy'])->name('penilai.kategori-penilaian.destroy');


    Route::get('/penilai/penilaian', [PenilaianController::class, 'index'])->name('penilai.penilaian.index');
    Route::get('/penilai/penilaian/list', [PenilaianController::class, 'list'])->name('penilai.penilaian.list');
    Route::get('/penilai/penilaian/create/{id}', [PenilaianController::class, 'create'])->name('penilai.penilaian.create');
    Route::post('/penilai/penilaian/store/{id}', [PenilaianController::class, 'store'])->name('penilai.penilaian.store');
    // Route::get('/penilai/penilaian/{id}/edit', [PenilaianController::class, 'edit'])->name('penilai.penilaian.edit');
    // Route::put('/penilai/penilaian/{id}', [PenilaianController::class, 'update'])->name('penilai.penilaian.update');
    // Route::delete('/penilai/penilaian/{id}', [PenilaianController::class, 'destroy'])->name('penilai.penilaian.destroy');
    Route::get('/penilai/penilaian/{id}/detail', [DetailPenilaianController::class, 'detail'])->name('penilai.penilaian.detail');
    // Route::delete('/penilai/karyawan/{id}/detail', [PenilaianController::class, 'detail'])->name('penilai.karyawan.detail');
});

// Rute untuk Kepala, hanya bisa diakses oleh user dengan role 'kepala'
Route::middleware(['auth', 'role:kepala sekolah'])->group(function () {
    Route::get('/kepala/dashboard', [DashboardController::class, 'kepala'])->name('kepala.dashboard');

    Route::get('/kepala/penilaian', [PenilaianController::class, 'index'])->name('kepala.penilaian.index');
    Route::get('/kepala/penilaian/list', [PenilaianController::class, 'list'])->name('kepala.penilaian.list');
    Route::get('/kepala/penilaian/create/{id}', [PenilaianController::class, 'create'])->name('kepala.penilaian.create');
    Route::post('/kepala/penilaian/store/{id}', [PenilaianController::class, 'store'])->name('kepala.penilaian.store');
    // Route::get('kepalapenilai/penilaian/{id}/edit', [PenilaianController::class, 'edit'])->name('kepala.penilaian.edit');
    // Route::put('/kepala/penilaian/{id}', [PenilaianController::class, 'update'])->name('kepala.penilaian.update');
    // Route::delete('/kepala/penilaian/{id}', [PenilaianController::class, 'destroy'])->name('kepala.penilaian.destroy');
    Route::get('/kepala/penilaian/{id}/detail', [DetailPenilaianController::class, 'detail'])->name('kepala.penilaian.detail');
    // Route::delete('/kepala/karyawan/{id}/detail', [PenilaianController::class, 'detail'])->name('kepala.karyawan.detail');

    Route::get('/kepala/laporan', [LaporanController::class, 'index'])->name('kepala.laporan.index');
    Route::get('/kepala/laporan/{id}/create', [LaporanController::class, 'create'])->name('kepala.laporan.create');
    Route::post('/kepala/laporan/{id}/store', [LaporanController::class, 'store'])->name('kepala.laporan.store');
    Route::get('/kepala/laporan/list', [LaporanController::class, 'list'])->name('kepala.laporan.list');

    // routes/web.php
    Route::get('kepala/laporan/{id}/export', [LaporanController::class, 'exportPdf'])->name('laporan.export');

});

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

