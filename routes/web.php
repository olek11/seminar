<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\UserController;
use App\Models\Ruang;
use Illuminate\Support\Facades\Route;





// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('landing');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Bagian user
Route::middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::post('/peminjaman', [UserController::class, 'store'])->name('user.peminjaman.store');
});

// Definisikan rute untuk admin dengan middleware autentikasi dan admin
Route::middleware(['auth', 'adminMiddleware'])->group(function () {
    // =========================================================================
    // Bagian Dashboard
    // =========================================================================
    /**
     * Rute untuk menampilkan halaman dashboard admin
     */
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // =========================================================================
    // Bagian Pengguna
    // =========================================================================
    /**
     * Rute untuk menampilkan halaman kelola pengguna
     */
    Route::get('/admin/user', [AdminController::class, 'user'])->name('admin.user');

    /**
     * Rute untuk menampilkan form tambah pengguna baru
     */
    Route::get('/admin/user/create', [AdminController::class, 'create'])->name('admin.user.create');

    /**
     * Rute untuk menyimpan data pengguna baru
     */
    Route::post('/admin/user', [AdminController::class, 'store'])->name('admin.store');

    /**
     * Rute untuk menampilkan form edit pengguna
     */
    Route::get('/admin/user/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');

    /**
     * Rute untuk memperbarui data pengguna
     */
    Route::put('/admin/user/{id}', [AdminController::class, 'update'])->name('admin.update');

    /**
     * Rute untuk menghapus data pengguna
     */
    Route::delete('/admin/user/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // =========================================================================
    // Bagian Ruang
    // =========================================================================
    /**
     * Rute untuk menampilkan halaman daftar ruangan
     */
    Route::get('/admin/ruang', [AdminController::class, 'ruang'])->name('admin.ruang');

    /**
     * Rute untuk menampilkan form tambah ruangan baru
     */
    Route::get('/admin/ruang/create', [AdminController::class, 'createruang'])->name('admin.ruang.create');

    /**
     * Rute untuk menyimpan data ruangan baru
     */
    Route::post('/admin/ruang', [AdminController::class, 'storeruang'])->name('admin.ruang.store');

    /**
     * Rute untuk menampilkan form edit ruangan
     */
    Route::get('/admin/ruang/edit/{id}', [AdminController::class, 'editruang'])->name('admin.ruang.edit');

    /**
     * Rute untuk memperbarui data ruangan
     */
    Route::put('/admin/ruang/{id}', [AdminController::class, 'updateruang'])->name('admin.ruang.update');

    /**
     * Rute untuk menghapus data ruangan
     */
    Route::delete('/admin/ruang/{id}', [AdminController::class, 'destroyruang'])->name('admin.ruang.destroy');

    // =========================================================================
    // Bagian Peminjaman
    // =========================================================================
    /**
     * Rute untuk menampilkan halaman daftar peminjaman
     */
    Route::get('/admin/peminjaman', [AdminController::class, 'peminjaman'])->name('admin.peminjaman');

    /**
     * Rute untuk menampilkan form tambah peminjaman baru
     */
    Route::get('/admin/peminjaman/create', [AdminController::class, 'createpeminjaman'])->name('admin.peminjaman.create');

    /**
     * Rute untuk menyimpan data peminjaman baru
     */
    Route::post('/admin/peminjaman', [AdminController::class, 'storepeminjaman'])->name('admin.peminjaman.store');

    /**
     * Rute untuk menampilkan form edit peminjaman
     */
    Route::get('/admin/peminjaman/edit/{id}', [AdminController::class, 'editpeminjaman'])->name('admin.peminjaman.edit');

    /**
     * Rute untuk memperbarui data peminjaman
     */
    Route::put('/admin/peminjaman/{id}', [AdminController::class, 'updatepeminjaman'])->name('admin.peminjaman.update');

    /**
     * Rute untuk menghapus data peminjaman
     */
    Route::delete('/admin/peminjaman/{id}', [AdminController::class, 'destroypeminjaman'])->name('admin.peminjaman.destroy');

    /**
     * Rute untuk mengatur status peminjaman (menunggu, disetujui, ditolak)
     */
    Route::patch('/admin/peminjaman/{id}/set-status/{status}', [AdminController::class, 'setStatus'])->name('admin.peminjaman.setStatus');

    /**
     * Rute untuk menyetujui peminjaman
     */
    Route::post('/admin/peminjaman/{id}/approve', [AdminController::class, 'approvePeminjaman'])->name('admin.peminjaman.approve');

    /**
     * Rute untuk menolak peminjaman
     */
    Route::post('/admin/peminjaman/{id}/reject', [AdminController::class, 'rejectPeminjaman'])->name('admin.peminjaman.reject');
});

// // bagian admin
// Route::middleware(['auth', 'adminMiddleware'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
//     // user page di dashboard
//     Route::get('/admin/user', [AdminController::class, 'user'])->name('admin.user');
//     Route::get('/admin/user/create', [AdminController::class, 'create'])->name('admin.user.create');
//     Route::post('/admin/user/store', [AdminController::class, 'store'])->name('admin.store');
//     Route::get('/admin/user/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
//     Route::put('/admin/user/{id}', [AdminController::class, 'update'])->name('admin.update');
//     Route::delete('/admin/user/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
//     // ruang page di dashboard
//     Route::get('/admin/ruang/ruang', [AdminController::class, 'ruang'])->name('admin.ruang');
//     Route::get('/admin/ruang/create', [AdminController::class, 'createruang'])->name('admin.ruang.create');
//     Route::post('/admin/ruang/store', [AdminController::class, 'storeruang'])->name('admin.ruang.store');
//     Route::get('/admin/ruang/edit/{id}', [AdminController::class, 'editruang'])->name('admin.ruang.edit');
//     Route::put('/admin/ruang/{id}', [AdminController::class, 'updateruang'])->name('admin.ruang.update');
//     Route::delete('/admin/ruang/destroy/{id}', [AdminController::class, 'destroyruang'])->name('admin.ruang.destroy');
//     // peminjaman page di dashboard
//     Route::get('/admin/peminjaman/peminjaman', [AdminController::class, 'peminjaman'])->name('admin.peminjaman');
//     Route::get('/admin/peminjaman/create', [AdminController::class, 'createpeminjaman'])->name('admin.peminjaman.create');
//     Route::post('/admin/peminjaman/store', [AdminController::class, 'storepeminjaman'])->name('admin.peminjaman.store');
//     Route::get('/admin/peminjaman/edit/{id}', [AdminController::class, 'editpeminjaman'])->name('admin.peminjaman.edit');
//     Route::put('/admin/peminjaman/{id}', [AdminController::class, 'updatepeminjaman'])->name('admin.peminjaman.update');
//     Route::delete('/admin/peminjaman/destroy/{id}', [AdminController::class, 'destroypeminjaman'])->name('admin.peminjaman.destroy');
//     Route::patch('/admin/peminjaman/{id}/set-status/{status}', [AdminController::class, 'setStatus'])->name('admin.peminjaman.setStatus');
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboardadmin'])->name('admin.dashboard');
//     // Rute ini cukup buat dashboard dan aksi peminjaman. Kalau mau tambah fitur pengguna lain, bisa ditambahkan di sini.
//     Route::post('/admin/peminjaman/{id}/approve', [AdminController::class, 'approvePeminjaman'])->name('admin.peminjaman.approve');
//     Route::post('/admin/peminjaman/{id}/reject', [AdminController::class, 'rejectPeminjaman'])->name('admin.peminjaman.reject');
// });