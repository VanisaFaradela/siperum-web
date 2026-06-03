<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminGaleriController;
use App\Http\Controllers\TipeRumahController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;


Route::post('/promo-modal-seen', function() {
    session(['promo_closed' => true]);
    return response()->json(['success' => true]);
})->name('promo.modal.seen');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/kontak', [HomeController::class, 'kontak'])->name('kontak.submit');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::post('/message-submit', [MessageController::class, 'submit'])
    ->name('message.submit');

// Route untuk Berita
Route::prefix('berita')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/{identifier}', [BeritaController::class, 'show'])->name('berita.show');
    Route::post('/{id}/komentar', [BeritaController::class, 'komentar'])->name('berita.komentar'); // Tambahkan ini
});

// Route untuk Galeri
Route::prefix('galeri')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('galeri.index');
});

// Route Admin untuk Galeri
// Admin Authentication Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin/galeri')->group(function () {
    Route::get('/', [AdminGaleriController::class, 'index'])->name('admin.galeri.index');
    Route::get('/create', [AdminGaleriController::class, 'create'])->name('admin.galeri.create');
    Route::post('/', [AdminGaleriController::class, 'store'])->name('admin.galeri.store');
    Route::get('/{id}/edit', [AdminGaleriController::class, 'edit'])->name('admin.galeri.edit');
    Route::put('/{id}', [AdminGaleriController::class, 'update'])->name('admin.galeri.update');
    Route::delete('/{id}', [AdminGaleriController::class, 'destroy'])->name('admin.galeri.destroy');
});

// Route untuk Cluster (Kategori)
Route::prefix('cluster')->group(function () {
    Route::get('/', [ClusterController::class, 'index'])->name('cluster.index');
    Route::get('/{id}', [ClusterController::class, 'show'])->name('cluster.show');
});

// Route untuk detail tipe rumah
Route::get('/tipe-detail/{id}', [TipeRumahController::class, 'detail'])->name('tipe-detail');

// Route untuk Tentang Kami
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');

Route::post('/promo-modal-seen', function() {
    session(['promo_closed' => true]);
    return response()->json(['success' => true]);
})->name('promo.modal.seen');