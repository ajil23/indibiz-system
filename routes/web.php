<?php

use App\Http\Controllers\Admin\BahanBakarController;
use App\Http\Controllers\Admin\JenisProdukController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\PenawaranController;
use App\Http\Controllers\Admin\TnkbController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Users\AdminController;
use App\Http\Controllers\Users\PimpinanController;
use App\Http\Controllers\Users\SalesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['loginCheck:admin']], function () {
        // Kategori lokasi
        Route::get('/view/kategori-lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
        Route::post('/store/kategori-lokasi', [LokasiController::class, 'store'])->name('lokasi.store');
        Route::put('/lokasi/{id}/kategori-lokasi', [LokasiController::class, 'update'])->name('lokasi.update');
        Route::delete('/lokasi/{id}/kategori-lokasi', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

        // Jenis BBM
        Route::get('/view/jenis-bbm', [BahanBakarController::class, 'index'])->name('bbm.index');
        Route::post('/store/jenis-bbm', [BahanBakarController::class, 'store'])->name('bbm.store');
        Route::put('/bbm/{id}/jenis-bbm', [BahanBakarController::class, 'update'])->name('bbm.update');
        Route::delete('/bbm/{id}/jenis-bbm', [BahanBakarController::class, 'destroy'])->name('bbm.destroy');

        // TNKB
        Route::get('/view/tnkb', [TnkbController::class, 'index'])->name('tnkb.index');
        Route::post('/store/tnkb', [TnkbController::class, 'store'])->name('tnkb.store');
        Route::put('/tnkb/{id}/tnkb', [TnkbController::class, 'update'])->name('tnkb.update');
        Route::delete('/tnkb/{id}/tnkb', [TnkbController::class, 'destroy'])->name('tnkb.destroy');
        
        // Jenis Produk
        Route::get('/view/jenis-produk', [JenisProdukController::class, 'index'])->name('jenis-produk.index');
        Route::post('/store/jenis-produk', [JenisProdukController::class, 'store'])->name('jenis-produk.store');
        Route::put('/jenis-produk/{id}/jenis-produk', [JenisProdukController::class, 'update'])->name('jenis-produk.update');
        Route::delete('/jenis-produk/{id}/jenis-produk', [JenisProdukController::class, 'destroy'])->name('jenis-produk.destroy');
        
        // Penawaran
        Route::get('/view/penawaran', [PenawaranController::class, 'index'])->name('penawaran.index');
        Route::post('/store/penawaran', [PenawaranController::class, 'store'])->name('penawaran.store');
        Route::put('/penawaran/{id}/penawaran', [PenawaranController::class, 'update'])->name('penawaran.update');
        Route::delete('/penawaran/{id}/penawaran', [PenawaranController::class, 'destroy'])->name('penawaran.destroy');
    });
    Route::group(['middleware' => ['loginCheck:admin']], function () {
        Route::resource('pimpinan', PimpinanController::class);
    });
    Route::group(['middleware' => ['loginCheck:admin']], function () {
        Route::resource('sales', SalesController::class);
    });
});

Route::post('/export', [ExportController::class, 'exportData'])->name('export.data');