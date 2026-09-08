<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController; // <-- Jangan lupa ini buat login
use App\Http\Controllers\TentangController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TentangSlide1Controller;

//HALAMAN PUBLIC

//home/beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

//mading berita public
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');

//halaman detail 1 artikel berita
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

//galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');

//tentang - foto & nama dari database (Anggota)
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');


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

    // Kelola Anggota Profil (Tentang) - foto dari database & bisa tambah di slide 3
    Route::get('/anggota', [AnggotaController::class, 'adminIndex'])->name('anggota.index');
    Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // Kelola Slide 1 Tentang - hanya judul, deskripsi, file (tidak tambah anggota)
    Route::get('/slide1/edit', [TentangSlide1Controller::class, 'edit'])->name('slide1.edit');
    Route::put('/slide1', [TentangSlide1Controller::class, 'update'])->name('slide1.update');
    Route::post('/slide1', [TentangSlide1Controller::class, 'update'])->name('slide1.store');

});