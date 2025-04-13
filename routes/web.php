<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JurnalController;

Route::get('/', function () {
    return view('welcome');
});

// Rute untuk Admin, hanya bisa diakses oleh user dengan role 'admin'
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
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
    Route::get('/admin/laporan/create', [LaporanController::class, 'create'])->name('admin.laporan.create');
    Route::post('/admin/laporan', [LaporanController::class, 'store'])->name('admin.laporan.store');
    Route::get('/admin/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('admin.laporan.edit');
    Route::put('/admin/laporan/{id}', [LaporanController::class, 'update'])->name('admin.laporan.update');
    Route::delete('/admin/laporan/{id}', [LaporanController::class, 'destroy'])->name('admin.laporan.destroy');
    Route::get('/admin/laporan/{id}/show', [LaporanController::class, 'show'])->name('admin.laporan.show');

    Route::get('/admin/penilaian/{id}/create', [PenilaianController::class, 'create'])->name('admin.penilaian.create');
    Route::post('/admin/penilaian/{id}', [PenilaianController::class, 'store'])->name('admin.penilaian.store');



    Route::get('/admin/jurnals/{id}/show', [JurnalController::class, 'show'])->name('admin.jurnal.show');
    Route::get('/admin/jurnals/{id}/edit', [JurnalController::class, 'edit'])->name('admin.jurnal.edit');
    Route::put('/admin/jurnals/{id}', [JurnalController::class, 'update'])->name('admin.jurnal.update');
    Route::delete('/admin/jurnals/{id}', [JurnalController::class, 'destroy'])->name('admin.jurnal.destroy');
});

// Rute untuk Karyawan, hanya bisa diakses oleh user dengan role 'karyawan'
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/karyawan/dashboard', fn () => view('karyawan.dashboard'))->name('karyawan.dashboard');
});

// Rute untuk Penilai, hanya bisa diakses oleh user dengan role 'penilai'
Route::middleware(['auth', 'role:penilai'])->group(function () {
    Route::get('/penilai/dashboard', fn () => view('penilai.dashboard'))->name('penilai.dashboard');
});

// Rute untuk Kepala, hanya bisa diakses oleh user dengan role 'kepala'
Route::middleware(['auth', 'role:kepala sekolah'])->group(function () {
    Route::get('/kepala/dashboard', fn () => view('kepala.dashboard'))->name('kepala.dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

