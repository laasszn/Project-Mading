<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController; // <-- Jangan lupa ini buat login

//HALAMAN PUBLIC

//home/beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

//mading berita public
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');

//halaman detail 1 artikel berita
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

//galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');

//tentang
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');


//sistem login & logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//halaman admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    
    // Tabel Data Berita Admin
    Route::get('/berita', [BeritaController::class, 'adminIndex'])->name('berita.index');

    // Form Tambah Berita
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');

    // Simpan Berita Baru
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');

    // Form Edit Berita
    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');

    // Proses Update Berita
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');

    // Hapus Berita
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');


    // Tabel Data Galeri Admin
    Route::get('/galeri', [GaleriController::class, 'adminIndex'])->name('galeri.index');

    // Form Tambah Foto Galeri
    Route::get('/galeri/create', [GaleriController::class, 'create'])->name('galeri.create');

    // Simpan Foto Galeri Baru
    Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');

    // Form Edit Foto Galeri
    Route::get('/galeri/{id}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');

    // Proses Update Foto Galeri
    Route::put('/galeri/{id}', [GaleriController::class, 'update'])->name('galeri.update');

    // Hapus Foto Galeri
    Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

});